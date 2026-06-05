<?php
require_once './settings.php';
if (!$_settings->userdata('id')) {
    echo '<script>alert("Faça login para se cadastrar como afiliado."); location.replace("/login.php");</script>';
    exit();
}

$user_id = $_settings->userdata('id');
$phone = $_settings->userdata('phone');
$is_affiliate = $_settings->userdata('is_affiliate');

if ($is_affiliate) {
    echo '<script>alert("Você já é afiliado!"); location.replace("/affiliate.php");</script>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $percentage = 10; // Comissão padrão
    $status = 0; // Pendente para aprovação
    $check = $conn->query("SELECT id FROM referral WHERE customer_id = '$user_id'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO referral (status, referral_code, percentage, amount_paid, amount_pending, customer_id) VALUES ($status, $user_id, $percentage, 0, 0, $user_id)");
    } else {
        $conn->query("UPDATE referral SET status=$status, percentage=$percentage WHERE customer_id='$user_id'");
    }
    $conn->query("UPDATE customer_list SET is_affiliate=0 WHERE id='$user_id'");
    echo '<script>alert("Solicitação enviada! Aguarde a aprovação do administrador."); location.replace("/");</script>';
    exit();
}
?>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Quero ser afiliado</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block text-sm mb-2">Telefone</label>
                <input type="text" class="block w-full mt-1 text-sm form-input" value="<?= htmlspecialchars($phone) ?>" disabled />
            </div>
            <button type="submit" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Solicitar afiliação</button>
        </form>
    </div>
</main> 