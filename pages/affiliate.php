<?php

require_once './settings.php';

// Permite acesso apenas se o usuário estiver logado
if (!$_settings->userdata('id')) {
    echo '<script>alert("Você não tem permissão para acessar essa página"); location.replace("/");</script>';
    exit();
}

if ($_settings->userdata('id') != '') {
    $qry = $conn->query('SELECT * FROM `customer_list` where id = \'' . $_settings->userdata('id') . '\'');

    if (0 < $qry->num_rows) {
        foreach ($qry->fetch_array() as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
} else {
    echo '<script>alert(\'Você não tem permissão para acessar essa página\'); ' . "\r\n" . '    location.replace(\'/\');</script>';
    exit();
}

$orders = $conn->query("SELECT amount_paid, amount_pending FROM referral WHERE customer_id = '{$_settings->userdata('id')}' LIMIT 10");
$orders2 = $conn->query("SELECT COUNT(id) FROM order_list WHERE referral_id = '{$_settings->userdata('id')}'");

if ($orders2->num_rows > 0) {
    $rowOrder = $orders2->fetch_assoc();
    $quantity = $rowOrder['COUNT(id)'];
}

if ($orders->num_rows > 0) {
    $row = $orders->fetch_assoc();
    $amount_paid = $row['amount_paid'];
    $amount_pending = $row['amount_pending'];
}

// Buscar referral_code do afiliado
$referral_code = '';
$qref = $conn->query("SELECT referral_code FROM referral WHERE customer_id = '{$_settings->userdata('id')}' LIMIT 1");
if ($qref && $qref->num_rows > 0) {
    $referral_code = $qref->fetch_assoc()['referral_code'];
}

// Buscar total de vendas aprovadas
$aprovado = 0;
if ($referral_code) {
    $qAprovado = $conn->query("SELECT SUM(total_amount) as total_aprovado FROM order_list WHERE status = 2 AND referral_id = '$referral_code'");
    if ($qAprovado && $qAprovado->num_rows > 0) {
        $aprovado = $qAprovado->fetch_assoc()['total_aprovado'] ?? 0;
    }
}

// Buscar porcentagem do afiliado
$percentage = 0;
$qperc = $conn->query("SELECT percentage FROM referral WHERE customer_id = '{$_settings->userdata('id')}' LIMIT 1");
if ($qperc && $qperc->num_rows > 0) {
    $percentage = $qperc->fetch_assoc()['percentage'] ?? 0;
}

// Calcular comissão total gerada
$comissao = $aprovado * ($percentage / 100);

// Buscar valor já pago ao afiliado
$pago = 0;
if ($referral_code) {
    $qPago = $conn->query("SELECT SUM(total_amount) as total_pago FROM referral_transactions WHERE referral_id = '$referral_code'");
    if ($qPago && $qPago->num_rows > 0) {
        $pago = $qPago->fetch_assoc()['total_pago'] ?? 0;
    }
}

// Calcular saldo (comissão - valor sacado)
$saldo = $comissao - $amount_paid;
if ($saldo < 0) $saldo = 0;
?>
<style>
    /* Layout ultra moderno para o painel do afiliado usando cores do sistema */
    * {
        box-sizing: border-box;
    }
    
    body {
        background: var(--incrivel-bg);
        min-height: 100vh;
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    .affiliate-panel {
        background: var(--incrivel-cardBg);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        padding: 40px 32px;
        max-width: 1000px;
        margin: 40px auto;
        border: 1px solid rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    
    .affiliate-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--incrivel-primaria), #50f, var(--incrivel-primaria));
        border-radius: 24px 24px 0 0;
    }
    
    .affiliate-header {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 40px;
        position: relative;
    }
    
    .affiliate-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 4px solid var(--incrivel-primaria);
        transition: transform 0.3s ease;
    }
    
    .affiliate-avatar:hover {
        transform: scale(1.05);
    }
    
    .affiliate-info h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        color: #fff;
    }
    
    .affiliate-info p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .affiliate-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .affiliate-card {
        background: linear-gradient(135deg, var(--incrivel-primaria) 0%, #50f 100%);
        color: #fff;
        border-radius: 20px;
        padding: 32px 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .affiliate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }
    
    .affiliate-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        transition: all 0.3s ease;
    }
    
    .affiliate-card:hover::before {
        transform: rotate(45deg) scale(1.2);
    }
    
    .affiliate-card span {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 12px;
        display: block;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }
    
    .affiliate-card strong {
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -2px;
        position: relative;
        z-index: 1;
    }
    
    .affiliate-link-box {
        background: linear-gradient(135deg, var(--incrivel-primaria) 0%, #50f 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .affiliate-link-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .affiliate-link-box > * {
        position: relative;
        z-index: 1;
    }
    
    .affiliate-link-box h3 {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0 0 16px 0;
    }
    
    .affiliate-link-box .link-container {
        display: flex;
        align-items: center;
        gap: 16px;
        background: rgba(255,255,255,0.15);
        border-radius: 12px;
        padding: 16px;
        backdrop-filter: blur(10px);
    }
    
    .affiliate-link-box input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 1rem;
        color: #fff;
        font-weight: 600;
        outline: none;
    }
    
    .affiliate-link-box input::placeholder {
        color: rgba(255,255,255,0.7);
    }
    
    .affiliate-link-box button {
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .affiliate-link-box button:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .affiliate-table-section {
        background: var(--incrivel-cardBg);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
    }
    
    .affiliate-table-section h3 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .affiliate-table-section h3::before {
        content: '📊';
        font-size: 1.2rem;
    }
    
    .affiliate-table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
        border-radius: 16px;
        overflow: hidden;
    }
    
    .affiliate-table th {
        background: linear-gradient(135deg, var(--incrivel-primaria), #50f);
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        padding: 20px 16px;
        text-align: left;
    }
    
    .affiliate-table td {
        padding: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        font-weight: 500;
    }
    
    .affiliate-table tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pendente {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .status-aprovado {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    @media (max-width: 768px) {
        .affiliate-panel {
            margin: 20px;
            padding: 24px 20px;
        }
        
        .affiliate-header {
            flex-direction: column;
            text-align: center;
            gap: 16px;
        }
        
        .affiliate-cards {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .affiliate-link-box .link-container {
            flex-direction: column;
            gap: 12px;
        }
        
        .affiliate-table {
            font-size: 0.9rem;
        }
        
        .affiliate-table th,
        .affiliate-table td {
            padding: 12px 8px;
        }
    }
    
    /* Animações */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .affiliate-panel {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .affiliate-card {
        animation: fadeInUp 0.6s ease-out;
        animation-delay: calc(var(--card-index) * 0.1s);
    }

    .affiliate-table th,
    .affiliate-table td,
    .affiliate-table tr {
        color: #fff !important;
    }
</style>

<main>
    <div class="affiliate-panel">
        <div class="affiliate-header">
            <img class="affiliate-avatar" src="<?php echo validate_image($avatar); ?>" alt="Avatar">
            <div class="affiliate-info">
                <h2><?php echo $firstname . ' ' . $lastname; ?></h2>
                <p>📱 <?php echo formatPhoneNumber($phone); ?></p>
                        </div>
                    </div>

        <div class="affiliate-cards">
            <div class="affiliate-card" style="--card-index: 1;">
                <span>💰 Saldo Disponível</span>
                <strong>R$<?= number_format($saldo, 2, ',', '.') ?></strong>
            </div>
            <div class="affiliate-card" style="--card-index: 2;">
                <span>🏦 Saldo Sacado</span>
                <strong>R$<?= number_format($amount_paid, 2, ',', '.') ?></strong>
            </div>
            <div class="affiliate-card" style="--card-index: 3;">
                <span>👥 Total de Indicações</span>
                <strong><?= $quantity ?></strong>
            </div>
        </div>

        <div class="affiliate-link-box">
            <h3>🎯 Compartilhe seu Link de Afiliado</h3>
            <div class="link-container">
                <input disabled id="affiliate_url" type="text" value="<?php echo BASE_REF . '?ref=' . $referral_code; ?>" placeholder="Seu link de afiliado..." />
                <button id="copy">📋 Copiar Link</button>
                    </div>
                </div>

        <div class="affiliate-table-section">
            <h3>Histórico de Referências</h3>
            <table class="affiliate-table">
                    <thead>
                        <tr>
                        <th>📦 Produto</th>
                        <th>💵 Comissão</th>
                        <th>📅 Data</th>
                        <th>📊 Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $uid = intval($uid);
                        $query = "SELECT o.product_name, o.status, o.total_amount, o.date_created, r.percentage 
          FROM order_list o 
          INNER JOIN referral r ON o.referral_id = r.referral_code 
          WHERE o.status <> 3 AND o.referral_id = '{$_settings->userdata('id')}'";

                        $orders = $conn->query($query);
                        while ($row = $orders->fetch_assoc()) {
                            $status = $row['status'];
                            $product = $row['product_name'];
                            $percentage = $row['percentage'];
                            $amount = $row['total_amount'];
                            $date = $row['date_created'];
                        ?>
                        <tr>
                            <td><?= $product ?></td>
                            <td><strong>R$<?= number_format(($amount * $percentage) / 100, 2, ',', '.') ?></strong></td>
                            <td><?= date('d/m/Y', strtotime($date)) . ' às ' . date('H:i', strtotime($date)) ?></td>
                            <td>
                                <span class="status-badge <?= $status == 1 ? 'status-pendente' : 'status-aprovado' ?>">
                                    <?= $status == 1 ? '⏳ Pendente' : '✅ Aprovado' ?>
                                </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            var button = $("#copy");
            button.on("click", function() {
                var copyText = $("#affiliate_url");
                copyText[0].select();
                copyText[0].setSelectionRange(0, 99999);
                document.execCommand("copy");
                navigator.clipboard.writeText(copyText.val()).then(function() {
                    // Feedback visual moderno
                    button.text('✅ Copiado!');
                    button.style.background = 'rgba(25, 135, 84, 0.2)';
                    button.style.borderColor = 'rgba(25, 135, 84, 0.5)';
                    
                    setTimeout(function() {
                        button.text('📋 Copiar Link');
                        button.style.background = 'rgba(255,255,255,0.2)';
                        button.style.borderColor = 'rgba(255,255,255,0.3)';
                    }, 2000);
                }, function(err) {
                    console.error('Erro ao copiar texto: ', err);
                });
            });
        });
    </script>
</main>