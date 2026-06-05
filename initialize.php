<?php
// Opcional: garanta o fuso do servidor
date_default_timezone_set('America/Campo_Grande');

$date_expirate = '2027-10-05';

if ($date_expirate <= date('Y-m-d')) {
    ?>
    <div style="width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <h1>Pagamento não identificado!</h1>
        <div>
            <span>Entre em contato com o administrador do site.</span>
        </div>
    </div>
    <?php
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(1); /// error_reporting(E_ALL);

    // --- Defina aqui UMA vez:
    $BASE_URL  = rtrim(getenv('BASE_URL') ?: 'https://rifa.obetzera.bet/', '/') . '/';
    $BASE_PATH = rtrim(str_replace('\\', '/', __DIR__), '/') . '/';

    // --- Todas as constantes partem das duas canônicas acima:
    $consts = [
        'BASE_URL'   => $BASE_URL,
        'BASE_REF'   => $BASE_URL,
        'base_url'   => $BASE_URL,
        'BASE_APP'   => $BASE_PATH,
        'base_app'   => $BASE_PATH,
        'DB_SERVER'  => getenv('DB_SERVER')   ?: 'localhost',
        'DB_USERNAME'=> getenv('DB_USERNAME') ?: 'root',
        'DB_PASSWORD'=> getenv('DB_PASSWORD') ?: '',
        'DB_NAME'    => getenv('DB_NAME')     ?: 'rifa',
    ];

    foreach ($consts as $name => $value) {
        if (!defined($name)) define($name, $value);
    }
}
?>
