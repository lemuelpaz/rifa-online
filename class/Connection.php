<?php

/**
 * Wrapper PostgreSQL com interface compatível com mysqli.
 * Substitui a conexão mysqli original para funcionar no Render com PostgreSQL.
 */

class DBResult
{
    public int $num_rows = 0;
    private array $rows = [];
    private int $position = 0;

    public function __construct(array $rows)
    {
        $this->rows     = $rows;
        $this->num_rows = count($rows);
    }

    public function fetch_assoc(): ?array
    {
        if ($this->position >= $this->num_rows) return null;
        return $this->rows[$this->position++];
    }

    public function fetch_row(): ?array
    {
        $row = $this->fetch_assoc();
        return $row ? array_values($row) : null;
    }

    public function fetch_array(): ?array
    {
        return $this->fetch_assoc();
    }
}

/** Divide string por delimitador ignorando conteúdo entre aspas simples */
function pg_split_outside_quotes(string $str, string $delim = ','): array
{
    $result = [];
    $current = '';
    $inQuote = false;

    for ($i = 0, $len = strlen($str); $i < $len; $i++) {
        $c = $str[$i];
        if ($inQuote) {
            $current .= $c;
            if ($c === "'" && ($i === 0 || $str[$i - 1] !== '\\')) $inQuote = false;
        } elseif ($c === "'") {
            $inQuote = true;
            $current .= $c;
        } elseif ($c === $delim) {
            $result[] = $current;
            $current = '';
        } else {
            $current .= $c;
        }
    }
    if ($current !== '') $result[] = $current;
    return $result;
}

/** Simula mysqli_stmt para prepared statements */
class PgStatement
{
    private \PDOStatement $stmt;
    private array $params = [];

    public function __construct(\PDOStatement $stmt)
    {
        $this->stmt = $stmt;
    }

    public function bind_param(string $types, mixed &...$vars): void
    {
        $this->params = array_values($vars);
    }

    public function execute(): bool
    {
        // Converte string vazia para null (PostgreSQL é estrito com tipos)
        $params = array_map(fn($p) => ($p === '') ? null : $p, $this->params);
        return $this->stmt->execute($params);
    }

    public function get_result(): DBResult
    {
        return new DBResult($this->stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function close(): void {}
}

class PgConnection
{
    private PDO $pdo;
    public string $error = '';
    public int $insert_id = 0;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function convertInsertSet(string $sql): string
    {
        // Converte: INSERT INTO table SET col='val', col2='val2'
        //       →   INSERT INTO table (col, col2) VALUES ('val', 'val2')
        if (!preg_match('/^\s*INSERT\s+INTO\s+`?(\w+)`?\s+set\s+(.+)$/is', $sql, $m)) {
            return $sql;
        }
        $table = $m[1];
        $pairs = pg_split_outside_quotes(trim($m[2]));
        $cols  = [];
        $vals  = [];
        foreach ($pairs as $pair) {
            $pair = trim($pair);
            $eq   = strpos($pair, '=');
            if ($eq === false) continue;
            $cols[] = trim(trim(substr($pair, 0, $eq)), '`\'" ');
            $vals[] = trim(substr($pair, $eq + 1));
        }
        if (empty($cols)) return $sql;
        return 'INSERT INTO ' . $table . ' (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $vals) . ')';
    }

    private function translate(string $sql): string
    {
        // INSERT INTO table SET → padrão SQL
        $sql = $this->convertInsertSet($sql);
        // Backticks → sem aspas
        $sql = preg_replace('/`([^`]+)`/', '$1', $sql);
        // REGEXP → ~
        $sql = preg_replace('/\bREGEXP\b/i', '~', $sql);
        // RAND() → RANDOM()
        $sql = preg_replace('/\bRAND\s*\(\s*\)/i', 'RANDOM()', $sql);
        // UNIX_TIMESTAMP(expr) → EXTRACT(EPOCH FROM expr)::bigint
        $sql = preg_replace('/\bUNIX_TIMESTAMP\s*\(([^)]+)\)/i', 'EXTRACT(EPOCH FROM $1)::bigint', $sql);
        // FIND_IN_SET(val, col) → val = ANY(string_to_array(col, ','))
        $sql = preg_replace_callback(
            '/FIND_IN_SET\s*\(([^,]+),([^)]+)\)/i',
            fn($m) => trim($m[1]) . ' = ANY(string_to_array(' . trim($m[2]) . ", ','))",
            $sql
        );
        // LIMIT offset, count → LIMIT count OFFSET offset (sintaxe MySQL)
        $sql = preg_replace('/\bLIMIT\s+(\d+)\s*,\s*(\d+)/i', 'LIMIT $2 OFFSET $1', $sql);
        return $sql;
    }

    public function prepare(string $sql): PgStatement
    {
        $sql  = $this->translate($sql);
        $stmt = $this->pdo->prepare($sql);
        return new PgStatement($stmt);
    }

    public function query(string $sql): DBResult|bool
    {
        try {
            $sql  = $this->translate($sql);
            $type = strtoupper(substr(ltrim($sql), 0, 6));

            if ($type === 'INSERT') {
                $hasTurning = stripos($sql, 'RETURNING') !== false;
                $stmt = $this->pdo->query($hasTurning ? $sql : $sql . ' RETURNING id');
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->insert_id = !empty($rows[0]['id']) ? (int) $rows[0]['id'] : 0;
                return new DBResult([]);
            }

            $stmt = $this->pdo->query($sql);
            return new DBResult($stmt->fetchAll(PDO::FETCH_ASSOC));

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('[DB] ' . $e->getMessage() . ' | SQL: ' . $sql);
            return false;
        }
    }

    public function real_escape_string(string $str): string
    {
        return str_replace("'", "''", $str);
    }

    public function set_charset(string $charset): void {}

    public function close(): void {}
}

class DBConnection
{
    public PgConnection $conn;

    public function __construct()
    {
        if (!defined('DB_SERVER')) {
            require_once __DIR__ . '/../initialize.php';
        }

        // Tenta todas as formas de ler variáveis de ambiente (Docker/Render)
        $database_url = getenv('DATABASE_URL')
            ?: ($_ENV['DATABASE_URL']    ?? '')
            ?: ($_SERVER['DATABASE_URL'] ?? '');

        if ($database_url) {
            $p    = parse_url($database_url);
            $host = $p['host'];
            $port = $p['port'] ?? 5432;
            $user = $p['user'];
            $pass = urldecode($p['pass'] ?? '');
            $name = ltrim($p['path'], '/');
            $dsn  = "pgsql:host={$host};port={$port};dbname={$name};sslmode=require";
        } else {
            $port = defined('DB_PORT') ? DB_PORT : 5432;
            $dsn  = 'pgsql:host=' . DB_SERVER . ';port=' . $port . ';dbname=' . DB_NAME;
            $user = DB_USERNAME;
            $pass = DB_PASSWORD;
        }

        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $this->conn = new PgConnection($pdo);
    }

    public function __destruct() {}
}

if (!defined('DB_SERVER')) {
    require_once '../initialize.php';
}
