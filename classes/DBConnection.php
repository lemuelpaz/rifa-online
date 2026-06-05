<?php

/**
 * Wrapper que replica a interface do mysqli mas usa PostgreSQL via PDO.
 * Todo o código existente que usa $conn->query(), ->num_rows, ->fetch_assoc()
 * e ->real_escape_string() continua funcionando sem alterações.
 */
class DBResult
{
    public int $num_rows = 0;
    private array $rows = [];
    private int $position = 0;

    public function __construct(array $rows)
    {
        $this->rows    = $rows;
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

class PgConnection
{
    private PDO $pdo;
    public string $error = '';
    public int $insert_id = 0;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Converte sintaxe MySQL → PostgreSQL */
    private function translate(string $sql): string
    {
        // Backticks → sem aspas (nomes em lowercase já funcionam no PG)
        $sql = preg_replace('/`([^`]+)`/', '$1', $sql);
        // REGEXP → ~ (operador regex do PostgreSQL)
        $sql = preg_replace('/\bREGEXP\b/i', '~', $sql);
        return $sql;
    }

    public function query(string $sql): DBResult|bool
    {
        try {
            $sql  = $this->translate($sql);
            $type = strtoupper(substr(ltrim($sql), 0, 6));

            if ($type === 'INSERT') {
                // RETURNING id permite capturar o ID gerado
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
        // Escapa aspas simples para uso em queries concatenadas
        return str_replace("'", "''", $str);
    }

    public function set_charset(string $charset): void {} // no-op no PDO

    public function close(): void {} // PDO fecha automaticamente
}

class DBConnection
{
    public PgConnection $conn;

    public function __construct()
    {
        if (!defined('DB_SERVER')) {
            require_once __DIR__ . '/../initialize.php';
        }

        $port = defined('DB_PORT') ? DB_PORT : 5432;
        $dsn  = 'pgsql:host=' . DB_SERVER . ';port=' . $port . ';dbname=' . DB_NAME;

        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $this->conn = new PgConnection($pdo);
    }

    public function __destruct() {} // PDO fecha no GC
}

if (!defined('DB_SERVER')) {
    require_once '../initialize.php';
}
