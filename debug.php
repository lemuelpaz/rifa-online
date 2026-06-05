<?php
// Diagnóstico — DELETE após resolver o problema
if (($_GET['token'] ?? '') !== 'rifa2024') { http_response_code(403); die('Acesso negado.'); }

echo '<pre>';

$db_url = getenv('DATABASE_URL') ?: ($_ENV['DATABASE_URL'] ?? '') ?: ($_SERVER['DATABASE_URL'] ?? '');
echo "DATABASE_URL lida: " . ($db_url ? 'SIM (' . strlen($db_url) . ' chars)' : 'NÃO ENCONTRADA') . "\n";

if ($db_url) {
    $p = parse_url($db_url);
    echo "Host: " . ($p['host'] ?? 'N/A') . "\n";
    echo "Port: " . ($p['port'] ?? '5432') . "\n";
    echo "User: " . ($p['user'] ?? 'N/A') . "\n";
    echo "Pass: " . (isset($p['pass']) ? str_repeat('*', strlen($p['pass'])) : 'N/A') . "\n";
    echo "DB:   " . ltrim($p['path'] ?? '', '/') . "\n\n";

    $dsn = "pgsql:host={$p['host']};port=" . ($p['port'] ?? 5432) . ";dbname=" . ltrim($p['path'], '/') . ";sslmode=require";
    echo "DSN: " . $dsn . "\n\n";

    try {
        $pdo = new PDO($dsn, $p['user'], urldecode($p['pass'] ?? ''), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "✅ Conexão com banco: SUCESSO\n";
    } catch (PDOException $e) {
        echo "❌ Erro de conexão: " . $e->getMessage() . "\n";
    }
} else {
    echo "⚠️  Verifique se DATABASE_URL está configurada no painel do Render.\n";
}

echo "\nPHP: " . PHP_VERSION . "\n";
echo "Extensions: pdo_pgsql=" . (extension_loaded('pdo_pgsql') ? 'OK' : 'FALTANDO') . "\n";
echo '</pre>';
