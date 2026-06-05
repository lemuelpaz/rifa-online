<?php
/**
 * Script de importação do banco PostgreSQL — USE UMA VEZ E DELETE!
 * Acesse: https://seu-site.onrender.com/migrate.php?token=rifa2024
 */

if (($_GET['token'] ?? '') !== 'rifa2024') {
    http_response_code(403);
    die('Acesso negado.');
}

$database_url = getenv('DATABASE_URL');
if (!$database_url) {
    die('DATABASE_URL não configurada.');
}

$p    = parse_url($database_url);
$host = $p['host'];
$port = $p['port'] ?? 5432;
$user = $p['user'];
$pass = $p['pass'];
$name = ltrim($p['path'], '/');
$dsn  = "pgsql:host={$host};port={$port};dbname={$name}";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die('Erro de conexão: ' . $e->getMessage());
}

$sql = file_get_contents(__DIR__ . '/database-postgresql.sql');

echo '<pre>';
echo "Conectado ao banco: {$name}\n\n";

// Executa o SQL completo
try {
    $pdo->exec($sql);
    echo "✅ Banco importado com sucesso!\n";
    echo "\nTabelas criadas e dados inseridos.\n";
    echo "\n⚠️  DELETE o arquivo migrate.php agora por segurança!";
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}

echo '</pre>';
