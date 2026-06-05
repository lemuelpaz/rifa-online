<style>
    .btn-warning,
    .bg-warning {
        background-color: #00307a !important;
        color: #fff !important;
    }
</style>
<?php
require_once('./settings.php');
if (isset($_GET['utm_source'])) {
    $_SESSION['ads'] = $_GET['utm_source'];
    page_view(2, 'campanha', $id ? $id : null, $user_id ? $user_id : null);
} else {
    page_view(1, 'campanha', $id ? $id : null, $user_id ? $user_id : null);
}

$string = isset($tipo_auto_cota) ? $tipo_auto_cota : '';
$string_roleta = ($status_auto_cota_roleta == 1) ? $tipo_auto_cota_roleta : '';
$string_box = ($status_auto_cota_box == 1) ? $tipo_auto_cota_box : '';
$numbers = [];
// Se não estiver vazio, adiciona os valores ao array $numbers
if (!empty($string)) {
    $numbers = array_merge($numbers, explode(',', $string));  // Adiciona os elementos de $string
}
if (!empty($string_roleta)) {
    $numbers = array_merge($numbers, explode(',', $string_roleta));  // Adiciona os elementos de $string_roleta
}
if (!empty($string_box)) {
    $numbers = array_merge($numbers, explode(',', $string_box));  // Adiciona os elementos de $string_box
}

$cotas_reservadas = count($numbers);

if (substr($string, -1) == ',') {
    $cotas_reservadas--;
}
if (substr($string_roleta, -1) == ',') {
    $cotas_reservadas--;
}
if (substr($string_box, -1) == ',') {
    $cotas_reservadas--;
}


$paid_and_pending = $pending_numbers + $paid_numbers;
$total_reservadas = $paid_numbers;

// if ($status_auto_cota == 0) {
//     $cotas_reservadas = 0;
// }
$available = (int) $qty_numbers - $paid_and_pending - $cotas_reservadas;
$percent = (($paid_and_pending + $cotas_reservadas) * 100) / $qty_numbers;
$enable_share = $_settings->info('enable_share');
$enable_groups = $_settings->info('enable_groups');
$telegram_group_url = $_settings->info('telegram_group_url');
$whatsapp_group_url = $_settings->info('whatsapp_group_url');
$support_number = $_settings->info('phone');
$theme = $_settings->info('theme');
$bgTheme = "";
$textTheme = "";
if ($theme == 1) {
    $bgTheme = "bg-white";
    $textTheme = "text-dark";
} else if ($theme == 2) {
    $bgTheme = "bg-dark";
    $textTheme = "text-light";
} else if ($theme == 3) {
    $bgTheme = "bg-secondary";
    $textTheme = "text-light";
} else if ($theme == 4) {
    $bgTheme = "bg-primary-custom";
    $textTheme = "text-light";
} else if ($theme == 5) {
    $bgTheme = "bg-dark";
    $textTheme = "text-light";
}



$max_discount = 0;
if ($available < $min_purchase) {
    $min_purchase = $available;
}
$enable_cpf = $_settings->info('enable_cpf');

if ($enable_cpf == 1) {
    $search_type = 'search_orders_by_cpf';
} else {
    $search_type = 'search_orders_by_phone';
}

$major = [];
$minor = [];

// Prepare the base SQL query
$sql = 'SELECT * FROM order_list WHERE product_id = ?';

// Prepare and execute the query
$stmt = $conn->prepare($sql);

$stmt->bind_param('s', $id);

$stmt->execute();
$result = $stmt->get_result();

// Loop through the results and calculate the major and minor values
while ($row = $result->fetch_assoc()) {
    $order_numbers .= $row['order_numbers'] . ',';
}
if (!empty($order_numbers)) {
    $order_numbers = rtrim($order_numbers, ',');
    $order_numbers = explode(',', $order_numbers);
    $order_numbers = array_filter($order_numbers);

    $stmt = $conn->prepare('SELECT o.customer_id, c.firstname, c.lastname, o.date_created,c.phone
                        FROM order_list o 
                        INNER JOIN customer_list c ON o.customer_id = c.id 
                        WHERE FIND_IN_SET(?, order_numbers) AND product_id = ? AND status = 2');
    $order_number = max($order_numbers); // Ensure $order_numbers is an array or list
    $stmt->bind_param('si', $order_number, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Check if a row is fetched
        $major['cota'] = $order_number;
        $major['winner'] = $row['firstname'] . ' ' . $row['lastname'];
        $major['date_created'] = date('d/m/Y H:i:s', strtotime($row['date_created']));
        $major['phone'] = $row['phone'];
    }

    $stmt = $conn->prepare('SELECT o.customer_id, c.firstname, c.lastname, o.date_created, c.phone
                        FROM order_list o 
                        INNER JOIN customer_list c ON o.customer_id = c.id 
                        WHERE FIND_IN_SET(?, order_numbers) AND product_id = ? AND status = 2');
    $order_number = min($order_numbers); // Ensure $order_numbers is an array or list
    $stmt->bind_param('si', $order_number, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Check if a row is fetched
        $minor['cota'] = $order_number;
        $minor['winner'] = $row['firstname'] . ' ' . $row['lastname'];
        $minor['date_created'] = date('d/m/Y H:i:s', strtotime($row['date_created']));
        $minor['phone'] = $row['phone'];
    }
}

// Close the statement and connection
$stmt->close();

?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style2.css">
<style>
    .hr {
        border: 0;
        height: 1px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), #343a40, rgba(0, 0, 0, 0));
        margin-block: 4px;
    }

    .lessons__category {
        margin-bottom: 16px;

        background: green;

        display: inline-block;
        padding: 8px 8px 6px;
        border-radius: 4px;
        font-size: 1.2rem;
        text-align: center;
        line-height: 1;
        font-weight: 700;
        text-transform: uppercase;
        color: #FCFCFD;
    }

    .maior,
    .menor {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column
    }

    .hidden {
        display: none !important;
    }


    .skeleton {
        background-color: #343a40;
        border-radius: 0.2rem;
        font-weight: 600;
        animation: blink 1s infinite;
        cursor: pointer;
        width: 98%;
        height: 12px;
        margin: 6px;


    }

    #overlay,
    .carousel-item {
        width: 100%;
        display: none
    }


    .visually-hidden-focusable:not(:focus):not(:focus-within) {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important
    }

    .d-block {
        display: block !important
    }

    .mt-3 {
        margin-top: 1rem !important
    }

    .sorteio_sorteioShare__247_t {
        position: fixed;
        bottom: 120px;
        right: 12px;
        display: -moz-box;
        display: flex;
        -moz-box-orient: vertical;
        -moz-box-direction: normal;
        flex-direction: column
    }

    .top-compradores {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        margin-top: 20px
    }

    .comprador {
        margin-right: 3px;
        margin-bottom: 8px;
        border: 1px solid #198754;
        padding: 22px;
        text-align: center;
        margin-left: 10px;
        background: #fff;
        border-radius: 6px;
        min-width: 160px
    }

    .ranking {
        margin-bottom: 5px;
        font-weight: 700;
        font-size: 18px
    }

    .customer-details {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 14px
    }

    #overlay {
        position: fixed;
        top: 0;
        height: 100%;
        background: rgba(0, 0, 0, .8);
        z-index: 99999999
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #ddd;
        border-top: 4px solid <?= $color ?>;
        border-radius: 50%;
        animation: .8s linear infinite sp-anime
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg)
        }
    }

    .is-hide {
        display: none
    }

    @media only screen and (max-width:600px) {
        .custom-image {
            height: 350px !important
        }
    }

    @media only screen and (min-width:768px) {
        .custom-image {
            height: 450px !important
        }
    }

    .btn-primary {
        background-color: #7e3af2;
        border-color: #7e3af2;
    }

    .btn-primary:hover {
        background-color: #7e3af2;
        border-color: #7e3af2;
        opacity: 0.8;
    }

    .btn-primary:focus {
        background-color: #7e3af2;
        border-color: #7e3af2;
    }

    .bg-app-primary-latte {
        --tw-bg-opacity: 1;
        background-color: rgb(245 242 235 /1);
    }

    .rounded-3xl {
        border-radius: 1.5rem;
    }

    .overflow-hidden {
        overflow: hidden;
    }

    .w-full {
        width: 100%;
    }

    .mb-6 {
        margin-bottom: 1.5rem;
    }

    .relative {
        position: relative;
    }

    .w-\[400px\] {
        width: 400px;
    }

    .aspect-square {
        aspect-ratio: 1 / 1;
    }

    .z-0 {
        z-index: 0;
    }

    .-right-\[160px\] {
        right: -160px;
    }

    .-top-\[40px\] {
        top: -40px;
    }

    .absolute {
        position: absolute;
    }

    .w-\[150px\] {
        width: 150px;
    }

    .bottom-0 {
        bottom: 0;
    }

    .right-0 {
        right: 0;
    }

    .py-6 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .flex-col {
        flex-direction: column;
    }

    .flex {
        display: flex;
    }

    .z-10 {
        z-index: 10;
    }

    .top-0 {
        top: 0;
    }

    .text-app-primary-blue {
        --tw-text-opacity: 1;
        color: rgb(40 128 254 / var(--tw-text-opacity));
    }

    .font-bold {
        font-weight: 700;
    }

    .text-base {
        font-size: 1rem;
        line-height: 1.5rem;
    }

    .text-app-neutral-dark-1 {
        --tw-text-opacity: 1;
        color: rgb(3 29 39 / var(--tw-text-opacity));
    }

    .font-bold {
        font-weight: 700;
    }

    .text-base {
        font-size: 1rem;
        line-height: 1.5rem;
    }

    .mb-3 {
        margin-bottom: .75rem;
    }

    .px-3 {
        padding-left: .75rem;
        padding-right: .75rem;
    }

    .bg-app-neutral-dark-1 {
        --tw-bg-opacity: 1;
        background-color: rgb(3 29 39 / var(--tw-bg-opacity));
    }

    .rounded-2xl {
        border-radius: 1rem;
    }

    .justify-around {
        justify-content: space-around;
    }

    .items-center {
        align-items: center;
    }

    .w-fit {
        width: -moz-fit-content;
        width: fit-content;
    }

    .h-4 {
        height: 1rem;
    }

    .inline {
        display: inline;
    }

    .ml-1 {
        margin-left: .25rem;
    }
</style>
<style>
    .carousel,
    .carousel-inner,
    .carousel-item {
        position: relative;
    }

    #overlay,
    .carousel-item {
        width: 100%;
        display: none;
    }

    @media (min-width: 1200px) {
        h3 {
            font-size: 1.75rem;
        }
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    img {
        vertical-align: middle;
    }

    button {
        border-radius: 0;
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        text-transform: none;
    }

    button:focus:not(:focus-visible) {
        outline: 0;
    }

    [type=button],
    button {
        -webkit-appearance: button;
    }

    .form-control-color:not(:disabled):not([readonly]),
    .form-control[type=file]:not(:disabled):not([readonly]),
    [type=button]:not(:disabled),
    [type=reset]:not(:disabled),
    [type=submit]:not(:disabled),
    button:not(:disabled) {
        cursor: pointer;
    }

    ::-moz-focus-inner {
        padding: 0;
        border-style: none;
    }

    ::-webkit-datetime-edit-day-field,
    ::-webkit-datetime-edit-fields-wrapper,
    ::-webkit-datetime-edit-hour-field,
    ::-webkit-datetime-edit-minute,
    ::-webkit-datetime-edit-month-field,
    ::-webkit-datetime-edit-text,
    ::-webkit-datetime-edit-year-field {
        padding: 0;
    }

    ::-webkit-inner-spin-button {
        height: auto;
    }

    ::-webkit-search-decoration {
        -webkit-appearance: none;
    }

    ::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    ::-webkit-file-upload-button {
        font: inherit;
        -webkit-appearance: button;
    }

    ::file-selector-button {
        font: inherit;
        -webkit-appearance: button;
    }

    .container-fluid {
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
        width: 100%;
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        margin-right: auto;
        margin-left: auto;
    }

    .form-control::file-selector-button {
        padding: .375rem .75rem;
        margin: -.375rem -.75rem;
        -webkit-margin-end: .75rem;
        margin-inline-end: .75rem;
        color: #212529;
        background-color: #e9ecef;
        pointer-events: none;
        border: 0 solid;
        border-inline-end-width: 1px;
        border-radius: 0;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        border-color: inherit;
    }

    .form-control:hover:not(:disabled):not([readonly])::-webkit-file-upload-button {
        background-color: #dde0e3;
    }

    .form-control:hover:not(:disabled):not([readonly])::file-selector-button {
        background-color: #dde0e3;
    }

    .form-control-sm::file-selector-button {
        padding: .25rem .5rem;
        margin: -.25rem -.5rem;
        -webkit-margin-end: .5rem;
        margin-inline-end: .5rem;
    }

    .form-control-lg::file-selector-button {
        padding: .5rem 1rem;
        margin: -.5rem -1rem;
        -webkit-margin-end: 1rem;
        margin-inline-end: 1rem;
    }

    .form-floating>.form-control-plaintext:not(:-moz-placeholder-shown),
    .form-floating>.form-control:not(:-moz-placeholder-shown) {
        padding-top: 1.625rem;
        padding-bottom: .625rem;
    }

    .form-floating>.form-control:not(:-moz-placeholder-shown)~label {
        opacity: .65;
        transform: scale(.85) translateY(-.5rem) translateX(.15rem);
    }

    .input-group>.form-control:not(:focus).is-valid,
    .input-group>.form-floating:not(:focus-within).is-valid,
    .input-group>.form-select:not(:focus).is-valid,
    .was-validated .input-group>.form-control:not(:focus):valid,
    .was-validated .input-group>.form-floating:not(:focus-within):valid,
    .was-validated .input-group>.form-select:not(:focus):valid {
        z-index: 3;
    }

    .input-group>.form-control:not(:focus).is-invalid,
    .input-group>.form-floating:not(:focus-within).is-invalid,
    .input-group>.form-select:not(:focus).is-invalid,
    .was-validated .input-group>.form-control:not(:focus):invalid,
    .was-validated .input-group>.form-floating:not(:focus-within):invalid,
    .was-validated .input-group>.form-select:not(:focus):invalid {
        z-index: 4;
    }

    .btn:focus-visible {
        color: var(--bs-btn-hover-color);
        background-color: var(--bs-btn-hover-bg);
        border-color: var(--bs-btn-hover-border-color);
        outline: 0;
        box-shadow: var(--bs-btn-focus-box-shadow);
    }

    .btn-check:focus-visible+.btn {
        border-color: var(--bs-btn-hover-border-color);
        outline: 0;
        box-shadow: var(--bs-btn-focus-box-shadow);
    }

    .btn-check:checked+.btn:focus-visible,
    .btn.active:focus-visible,
    .btn.show:focus-visible,
    .btn:first-child:active:focus-visible,
    :not(.btn-check)+.btn:active:focus-visible {
        box-shadow: var(--bs-btn-focus-box-shadow);
    }

    .btn-link:focus-visible {
        color: var(--bs-btn-color);
    }

    .carousel-inner {
        width: 100%;
        overflow: hidden;
    }

    .carousel-inner::after {
        display: block;
        clear: both;
        content: "";
    }

    .carousel-item {
        float: left;
        margin-right: -100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        transition: transform .6s ease-in-out;
    }

    .carousel-item.active {
        display: block;
    }

    .carousel-control-next,
    .carousel-control-prev {
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 15%;
        padding: 0;
        color: #fff;
        text-align: center;
        background: 0 0;
        border: 0;
        opacity: .5;
        transition: opacity .15s;
    }

    .carousel-control-next:focus,
    .carousel-control-next:hover,
    .carousel-control-prev:focus,
    .carousel-control-prev:hover {
        color: #fff;
        text-decoration: none;
        outline: 0;
        opacity: .9;
    }

    .carousel-control-prev {
        left: 0;
    }

    .carousel-control-next {
        right: 0;
    }

    .carousel-control-next-icon,
    .carousel-control-prev-icon {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: 100% 100%;
    }

    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e");
    }

    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .carousel-indicators {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 2;
        display: flex;
        justify-content: center;
        padding: 0;
        margin-right: 15%;
        margin-bottom: 1rem;
        margin-left: 15%;
        list-style: none;
    }

    .carousel-indicators [data-bs-target] {
        box-sizing: content-box;
        flex: 0 1 auto;
        width: 30px;
        height: 3px;
        padding: 0;
        margin-right: 3px;
        margin-left: 3px;
        text-indent: -999px;
        cursor: pointer;
        background-color: #fff;
        background-clip: padding-box;
        border: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        opacity: .5;
        transition: opacity .6s;
    }

    @media (prefers-reduced-motion: reduce) {
        .form-control::file-selector-button {
            transition: none;
        }

        .carousel-control-next,
        .carousel-control-prev,
        .carousel-indicators [data-bs-target],
        .carousel-item {
            transition: none;
        }
    }

    .carousel-indicators .active {
        opacity: 1;
    }

    .visually-hidden-focusable:not(:focus):not(:focus-within) {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important;
    }

    .d-block {
        display: block !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .sorteio_sorteioShare__247_t {
        position: fixed;
        bottom: 120px;
        right: 12px;
        display: flex;
        flex-direction: column;
    }

    .top-compradores {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .comprador {
        margin-right: 3px;
        margin-bottom: 8px;
        border: 1px solid #198754;
        padding: 22px;
        text-align: center;
        margin-left: 10px;
        background: #fff;
        border-radius: 6px;
        min-width: 160px;
    }

    .ranking {
        margin-bottom: 5px;
        font-weight: 700;
        font-size: 18px;
    }

    .customer-details {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 14px;
    }

    #overlay {
        position: fixed;
        top: 0;
        height: 100%;
        background: rgba(0, 0, 0, .8);
        z-index: 99999999;
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #ddd;
        border-top: 4px solid #2e93e6;
        border-radius: 50%;
        animation: .8s linear infinite sp-anime;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
    }

    @media only screen and (max-width: 600px) {
        .custom-image {
            height: 350px !important;
        }
    }

    @media only screen and (min-width: 768px) {
        .custom-image {
            height: 450px !important;
        }
    }

    .animation-r {
        transition: 0.5s ease-in-out;
    }

    .accordion-collapse {
        transition: 0.7s ease-in-out !important;
    }

    .rotate {
        transform: rotate(135deg);
    }

    .btn-descricao:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: rgb(25, 135, 84);
    }
</style>


<div id="overlay">
    <div class="cv-spinner">
        <div class="card" style="border:none; padding:10px;background: transparent;color: #fff !important;font-weight: 800;">
            <span class="spinner mb-2" style="align-self:center;"></span>
            <div class="text-center font-xs">
                Estamos gerando seu pedido, aguarde...
            </div>
        </div>
    </div>
</div>
<div class="container app-main">
    <div class="campanha-header SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer custom-highlight-card">

        <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
            <div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                    $image_gallery = isset($image_gallery) ? $image_gallery : '';

                    if ($image_gallery != '[]' && !empty($image_gallery)) {
                        $image_gallery = json_decode($image_gallery, true);
                        array_unshift($image_gallery, $image_path);
                        echo '               ';
                        $slide = 0;

                        foreach ($image_gallery as $image) {
                            ++$slide;
                    ?>
                            <div class="custom-image carousel-item <?= ($slide == 1) ? 'active' : '' ?>">
                                <?php

                                ?>
                                <img alt="<?php isset($name) ? $name : '' ?>" src=" <?= validate_image($image)  ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI">
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="custom-image carousel-item active">
                            <img src="<?= validate_image(isset($image_path) ? $image_path : '') ?>" alt="<?= isset($name) ? $name : '' ?>"
                                class="SorteioTpl_imagem__2GXxI" style="width:100%">
                        </div>
                    <?php
                    }

                    ?>
                </div>
            </div>
            <?php

            if ($image_gallery != '[]' && !empty($image_gallery)) { ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            <?php } ?>
        </div>
        <div class="SorteioTpl_info__t1BZr custom-content-wrapper <?php echo $status_display != '4' && $status_display != '5' ? 'custom-content-wrapper-details' : ''; ?>">
            <h1 class="SorteioTpl_title__3RLtu"><?php echo isset($name) ? $name : ''; ?></h1>
            <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">
                <?= isset($subtitle) ? $subtitle : '' ?>
            </p>
            <div class="custom-badge-display mt-3">
                <?php
                if ($status_display == 1) { ?>
                    <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
                <?php }
                if ($status_display == 2) { ?>
                    <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
                <?php }
                if ($status_display == 3) { ?>
                    <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
                <?php }
                if ($status_display == 4) { ?>
                    <span class="badge bg-dark font-xsss">Concluído</span>
                <?php }
                if ($status_display == 5) { ?>
                    <span class="badge bg-dark font-xsss">Em breve!</span>
                <?php }
                if ($status_display == 6) { ?>
                    <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <div class="campanha-buscas mt-2">

        <div class="row row-gutter-sm">
            <div class="col">
                <div>
                    <?php if (0 < $percent && $enable_progress_bar == 1) {
                        if ($enable_progress_bar_fake == 1) { ?>

                            <div class="progress">
                                <div class="progress-bar bg-info progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                <div class="progress-bar bg-success progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow=" <?= number_format($enable_progress_bar_fake_value, 1, '.', '') ?>"
                                    aria-valuemin="0" aria-valuemax="<?= $qty_numbers ?>" style="width: <?= number_format($enable_progress_bar_fake_value, 1, '.', '') ?>%">

                                    <?= number_format($enable_progress_bar_fake_value, 1, '.', ''); ?>%</div>
                            </div>

                        <?php } else { ?>
                            <div class="progress">
                                <div class="progress-bar bg-info progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                <div class="progress-bar bg-success progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow=" <?= number_format($percent, 1, '.', '') ?>"
                                    aria-valuemin="0" aria-valuemax="<?= $qty_numbers ?>" style="width: <?= number_format($percent, 1, '.', '') ?>%">

                                    <?= number_format($percent, 1, '.', ''); ?>%</div>
                            </div>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="campanha-preco porApenas font-xs d-flex align-items-center justify-content-center mt-2 mb-2 font-weight-500">
        <div class="item d-flex align-items-center font-xs me-2">
            <?php
            if (!empty($date_of_draw)) { ?>
                <span class="ms-2 me-1">Campanha</span>
                <div class="tag btn btn-sm bg-white bg-opacity-50 font-xss box-shadow-08">
                    <?php
                    $dataFormatada = date('d/m/y', strtotime($date_of_draw));
                    $horaFormatada = date('H\\hi', strtotime($date_of_draw));
                    $date_of_draw = $dataFormatada . ' às ' . $horaFormatada;
                    echo $date_of_draw;
                    ?>
                </div>
            <?php  } ?>

        </div>
        <div class="item d-flex align-items-center font-xs">
            <div class="me-1 text-white">por apenas</div>
            <div style="height: 22px;min-width: 22px;line-height: 0;border-radius: 6px;align-items: center;white-space: nowrap;display: inline-flex;justify-content: center;color: rgb(255, 255, 255);font-weight: 700;border: 1px solid rgba(145, 158, 171, 0.32);font-size: 14px;background-color: rgb(22, 28, 36);padding: 16px 8px;cursor: pointer;">R$ <?= isset($price) ? format_num($price, 2) : '' ?>
            </div>
        </div>
    </div>
    <?php




    if ($status_display == '6') { ?>
        <div class="alert alert-warning font-xss mb-2 mt-2">Todos os números já foram reservados ou pagos</div>
        <?php  }

    $discount_qty = isset($discount_qty) ? $discount_qty : '';
    $discount_amount = isset($discount_amount) ? $discount_amount : '';

    if ($roleta || $box) {
        $roleta_qty = isset($roleta_qty) ? $roleta_qty : '';
        $roleta_amount = isset($roleta_amount) ? $roleta_amount : '';

        $roleta_qty = json_decode($roleta_qty, true);
        $roleta_amount = json_decode($roleta_amount, true);
        $roletas = [];

        foreach ($roleta_qty as $qty_index => $qty) {
            foreach ($roleta_amount as $amount_index => $amount) {
                if ($qty_index === $amount_index) {
                    $roletas[$qty_index] = [
                        'qty' => $qty,
                        'amount' => $amount,
                    ];
                }
            }
        }

        $box_qty = isset($box_qty) ? $box_qty : '';
        $box_amount = isset($box_amount) ? $box_amount : '';
        $box_qty = json_decode($box_qty, true);
        $box_amount = json_decode($box_amount, true);
        $boxs = [];

        foreach ($box_qty as $qty_index => $qty) {
            foreach ($box_amount as $amount_index => $amount) {
                if ($qty_index === $amount_index) {
                    $boxs[$qty_index] = [
                        'qty' => $qty,
                        'amount' => $amount,
                    ];
                }
            }
        }
    }




    if ($available > 0 && $discount_qty && $discount_amount && $enable_discount == 1) {
        $discount_qty = json_decode($discount_qty, true);
        $discount_amount = json_decode($discount_amount, true);
        $discount_roleta = json_decode($discount_roleta, true);
        $discounts = [];

        foreach ($discount_qty as $qty_index => $qty) {
            foreach ($discount_amount as $amount_index => $amount) {
                // Quando os índices de quantidade e valor coincidirem, vamos adicionar o desconto
                if ($qty_index === $amount_index) {
                    // Adiciona os valores de quantidade, valor e roleta ao array $discounts
                    $discounts[$qty_index] = [
                        'qty' => $qty,
                        'amount' => $amount,
                        'roleta' => isset($discount_roleta[$qty_index]) ? $discount_roleta[$qty_index] : null // Adiciona roleta
                    ];
                }
            }
        }

        if (isset($discounts)) {
            $max_discount = count($discounts);
        } else {
            $max_discount = 0;
        }

        if ($status == '1') { ?>

            <?php
            if ($available > 0 && $discount_qty && $discount_amount && $enable_discount == 1) { ?>

                <div class="app-promocao-numeros mb-2">
                    <div class="app-title mb-2 gap-2" style="align-items: flex-start;">
                        <h1 style="font-size: 1.125rem;">📣 Promoção</h1>
                        <div class="app-title-desc">Compre mais barato!</div>
                    </div>
                    <div class="app-card card">
                        <div class="card-body pb-1 px-0">
                            <div class="d-flex flex-wrap gap-1">
                                <style>
                                    .swiper-slide {
                                        text-align: center;
                                        font-size: 18px;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }

                                    .swiper-button-next:after,
                                    .swiper-rtl .swiper-button-prev:after,
                                    .swiper-button-prev:after,
                                    .swiper-rtl .swiper-button-next:after {
                                        font-size: 18px;
                                    }

                                    .swiper-pagination-bullet-active {
                                        background: #fff;
                                    }
                                </style>
                                <div class="swiper" style="height: 80px;">
                                    <!-- Additional required wrapper -->
                                    <div class="swiper-wrapper">

                                        <?php
                                        $count = 0;
                                        foreach ($discounts as $discount) {
                                        ?>

                                            <div class="swiper-slide">
                                                <?php if ($user_id) { ?>
                                                    <button onclick="qtyRaffle(<?= $discount['qty'] ?>, true)" class="btn btn-success w-100 text-nowrap font-xss">
                                                    <?php } else { ?>
                                                        <span id="add_to_cart"></span>
                                                        <button data-bs-toggle="modal" data-bs-target="#newCheckoutModal" onclick="qtyRaffle(<?= $discount['qty'] ?>, true)" class="btn btn-success w-100 text-nowrap font-xss">
                                                        <?php } ?>
                                                        <span class="font-weight-600" id="discount_qty_<?= $count ?>"><?= $discount['qty'] ?> POR
                                                            <span id="discount_amount_<?= $count ?>" style="display:none">
                                                                <?= $discount['amount'] ?>
                                                            </span>
                                                            <?php
                                                            $discount_price = $price * $discount['qty'] - $discount['amount'];
                                                            echo 'R$ ' . number_format($discount_price, 2, ',', '.');
                                                            ?>
                                                        </span>
                                                        </button>
                                            </div>

                                        <?php
                                            ++$count;
                                        }
                                        ?>

                                    </div>
                                    <!-- If we need pagination -->
                                    <div class="swiper-pagination"></div>

                                    <!-- If we need navigation buttons -->
                                    <div class="swiper-button-prev text-white"></div>
                                    <div class="swiper-button-next text-white"></div>

                                </div>
                            </div>
                            <script>
                                const swiper = new Swiper('.swiper', {
                                    // Optional parameters

                                    autoplay: {
                                        delay: 2500,
                                        disableOnInteraction: false,
                                    },
                                    pagination: {
                                        el: ".swiper-pagination",
                                        clickable: true,
                                    },
                                    navigation: {
                                        nextEl: ".swiper-button-next",
                                        prevEl: ".swiper-button-prev",
                                    },
                                    breakpoints: {
                                        640: {
                                            slidesPerView: 1,
                                            spaceBetween: 10,
                                        },
                                        768: {
                                            slidesPerView: 1,
                                            spaceBetween: 10,
                                        },
                                        1024: {
                                            slidesPerView: 3,
                                            spaceBetween: 10,
                                        },
                                    },
                                });
                            </script>
                        </div>
                    </div>
                </div>

        <?php
            }
        }
    }


    $agora = date('Y-m-d H:i:s');

    if ($enable_double == 1 && strtotime($double_ini) < strtotime($agora) && strtotime($agora) < strtotime($double_fim)) {
        $timestamp_ini = strtotime($double_ini);
        $timestamp_fim = strtotime($double_fim);
        $timestamp_hoje = time(); // Timestamp atual

        if ($timestamp_hoje < $timestamp_fim && $timestamp_hoje > $timestamp_ini) {
            $progresso = ($timestamp_hoje - $timestamp_ini) / ($timestamp_fim - $timestamp_ini) * 100;
        } else {
            $progresso = 0; // Se não estiver no intervalo, a barra fica em 0
        }
        ?>
        <style>
            .barra {
                width: 100%;
                background-color: #f3f3f3;
                border: 1px solid #ddd;
                height: 30px;
                border-radius: 5px;
            }

            .progresso {
                height: 100%;
                background: repeating-linear-gradient(45deg,
                        rgb(255, 0, 0),
                        rgb(255, 0, 0) 10px,
                        rgb(255, 137, 137) 10px,
                        rgb(255, 137, 137) 20px);
                border-radius: 5px;
                text-align: center;
                color: white;
                line-height: 30px;
                font-weight: 800;
            }
        </style>
        <div class="card bg-gradient-red2 my-3">
            <div class="card-body text-white text-center">
                <h5 class="fw-bolder ">🔥 Bilhetes em Dobro! 🔥</h5>
                <div class="barra my-2">
                    <div class="progresso text-nowrap" style="width: <?= $progresso ?>%;"><?= round($progresso, 2) ?>%</div>
                </div>
                <div>
                    <div class="fw-bold">Compre agora e ganhe o dobro!</div>
                    <div>
                        Válido de <?= $data_formatada_ini = date('d/m/Y H:i', strtotime($double_ini)) ?> a <?= $data_formatada_fim = date('d/m/Y H:i', strtotime($double_fim)) ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    if ($status_display != '4' && $status_display != '5') {
    ?>
        <div class="d-flex flex-column gap-2 mb-3">
            <div class="btn btn-sm btn-secondary box-shadow-08 w-100" data-bs-toggle="modal" data-bs-target="#modal-consultaCompras">
                <i class="bi bi-bag me-2"></i>Ver meus bilhetes
            </div>
            <!-- <div class="btn btn-sm btn-success box-shadow-08 w-100" data-bs-toggle="modal" data-bs-target="#modal-titulos">
                <i class="bi bi-star-fill me-2"></i>Bilhetes Premiados
            </div> -->
            <?php if (0 < $enable_ranking) { ?>
                <div class="btn btn-sm bg-gradient-green text-white box-shadow-08 w-100" data-bs-toggle="modal" data-bs-target="#modal-premios">
                    <i class="bi bi-trophy me-2"></i>Top Compradores
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="app-card card mb-2">
        <div class="card-body text-center p-1">
            <p class="text-muted font-xss">Quanto mais Bilhetes, mais chances de ganhar!</p>
        </div>
    </div>
    <?php


    if ($available > 0 && $status == '1') {

    ?>

        <div class="app-vendas-express mb-2">
            <div class="numeros-select d-flex align-items-center justify-content-center flex-column">
                <div class="vendasExpressNumsSelect v2 w-100">
                    <?php if ($qty_select_1 > 0): ?>
                        <div onclick="qtyRaffle('<?= $qty_select_1 ?>', false)" class="item mb-2">
                            <div class="item-content flex-column p-2">
                                <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small>
                                    <?= $qty_select_1 ?>
                                </h3>
                                <p class="item-content-txt font-xss text-uppercase mb-0" style="font-size:0.7rem;">Selecionar</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($qty_select_2 > 0): ?>
                        <div onclick="qtyRaffle('<?= $qty_select_2 ?>', false)" class="item mb-2">
                            <div class="item-content flex-column p-2">
                                <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small>
                                    <?= $qty_select_2 ?>
                                </h3>
                                <p class="item-content-txt font-xss text-uppercase mb-0" style="font-size:0.7rem;">Selecionar</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($qty_select_3 > 0): ?>
                        <div onclick="qtyRaffle('<?= $qty_select_3 ?>', false)" class="item mb-2 bg-success" style="position: relative; ">
                            <div class="px-2  rounded text-white" style="background-color: rgb(25, 135, 84);border-radius: 5px;position: absolute;font-family: Montserrat;font-size: 0.8em;padding: 4px;color: rgb(255, 255, 255);top: -7px;">Mais popular</div>
                            <div class="item-content flex-column p-2 text-dark" style="background: rgb(200, 250, 205) !important">
                                <h3 class="mb-0 text-dark"><small class="item-content-plus font-xsss text-dark">+</small>
                                    <?= $qty_select_3 ?>
                                </h3>
                                <p class="item-content-txt font-xss text-uppercase mb-0" style="font-size:0.7rem;">Selecionar</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($qty_select_4 > 0): ?>
                        <div onclick="qtyRaffle('<?= $qty_select_4 ?>', false)" class="item mb-2">
                            <div class="item-content flex-column p-2">
                                <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small>
                                    <?= $qty_select_4 ?>
                                </h3>
                                <p class="item-content-txt font-xss text-uppercase mb-0" style="font-size:0.7rem;">Selecionar</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($qty_select_5 > 0): ?>
                        <div onclick="qtyRaffle('<?= $qty_select_5 ?>', false)" class="item mb-2">
                            <div class="item-content flex-column p-2">
                                <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small>
                                    <?= $qty_select_5 ?>
                                </h3>
                                <p class="item-content-txt font-xss text-uppercase mb-0" style="font-size:0.7rem;">Selecionar</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($qty_select_6 > 0): ?>
                        <div onclick="qtyRaffle('<?= $qty_select_6 ?>', false)" class="item mb-2">
                            <div class="item-content flex-column p-2">
                                <h3 class="mb-0"><small class="item-content-plus font-xsss">+</small>
                                    <?= $qty_select_6 ?>
                                </h3>
                                <p class="item-content-txt font-xss text-uppercase mb-0" style="font-size:0.7rem;">Selecionar</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-flex w-100 justify-content-center items-center flex-column">
                    <div class="vendasExpressNums app-card card mb-2 w-100 font-xs me-1">
                        <div class="card-body d-flex align-items-center justify-content-center font-xss p-1 css-19efcuh">
                            <div class="left pointer">
                                <div class="removeNumero numeroChange"><i class="bi bi-dash-circle"></i></div>
                            </div>
                            <div class="center w-100">
                                <input class="form-control text-center qty css-uv8p8d" readonly value="<?= isset($min_purchase) ? $min_purchase : '' ?>" aria-label="Quantidade de números" placeholder="<?= isset($min_purchase) ? $min_purchase : '' ?>">
                            </div>
                            <div class="right pointer">
                                <div class="addNumero numeroChange"><i class="bi bi-plus-circle"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($user_id) { ?>
                        <button id="add_to_cart" data-bs-toggle="modal" data-bs-target="#newCheckoutModal" class="btn btn-success py-1 w-100 mb-2">
                        <?php } else { ?>
                            <span id="add_to_cart"></span>
                            <button data-bs-toggle="modal" data-bs-target="#newCheckoutModal" class="btn btn-success text-white py-1 w-100 mb-2">
                            <?php   }
                            ?>
                            <div class="py-2 d-flex align-items-center justify-content-between">
                                <span class="me-2" style="display:flex; align-items:center">
                                    <i class="bi bi-check2-circle" style="font-size: 24px;"></i>
                                </span>
                                <div style="flex-direction:column; display:flex; align-items: flex-start;">
                                    <div class="text-nowrap"><span class="css-c2wfi1">Quero participar</span></div>
                                </div>
                                <div class="text-nowrap price-mobile">
                                    <span id="total" style="opacity: 1; font-size:1.1rem !important">R$
                                        <?php
                                        if (isset($price)) {
                                            $price_total = $price * $min_purchase;
                                            echo format_num($price_total, 2);
                                        }
                                        ?>

                                    </span>
                                </div>
                            </div>
                            </button>
                </div>
            </div>

            <?php }

        if ($available > 0 && $status == '1') {
            if ($description) {
            ?>
                <div class="accordion mb-3" id="accordionExample">
                    <div class="accordion-item card p-2" style="background-color: transparent;">
                        <h2 class="accordion-header">
                            <button class="btn btn-dark w-100 fs-6 btn-descricao d-flex align-items-center justify-content-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne" style="background-color: #212b36;">
                                <div class="animation-r rotate"><i class="bi bi-plus-circle"></i></div>
                                <div>Descrição/Regulamento</div>

                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body text-white">
                                <?= blockHTML($description) ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
            <?php
            if ($roleta) { ?>
                <div class="app-title mb-2 gap-2" style="align-items: flex-start;">

                    <h1 style="font-size: 1.125rem;">🎯 Roletas Instantâneas</h1>
                    <div class="app-title-desc">premiadas</div>

                </div>
                <div class="mb-3">
                    <?php
                    $count = 0;
                    foreach ($roletas as $roleta) {
                        if ($roleta) { ?>
                            <div class="mb-2">
                                <?php if ($user_id) { ?>
                                    <button onclick="qtyRaffle(<?= $roleta['amount'] ?> + 1, true)" class="btn w-100 text-center mb-1 lh-1 bg-gradient-green text-white" style="border-radius: 16px;">
                                    <?php } else { ?>
                                        <span></span>
                                        <button data-bs-toggle="modal" data-bs-target="#newCheckoutModal" onclick="qtyRaffle(<?= $roleta['amount'] ?> + 1, true)" class="btn w-100 text-center bg-gradient-green mb-1 text-white" style="border-radius: 16px;">
                                        <?php } ?>
                                        <div class="row mb-1 font-xs">
                                            <div class="col text-start">
                                                <div class="mb-1"><span style="font-size: 0.75rem;font-weight: 400;line-height: 1.5">A partir de</div>
                                                <div class="mb-1"><span class="fs-6" style="font-size: 1rem;"><?= $roleta['amount'] ?></span> Bilhetes</div>
                                                <div style="font-size: 0.75rem;font-weight: 400;line-height: 1.5"><small><?= $roleta['qty'] ?> chance(s) de contemplação nas Roletas Instantâneas</small>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <div>Recebe <?= $roleta['qty'] ?> Roleta(s)</div>
                                                <div class="col-auto">🎯</div>
                                            </div>
                                        </div>
                                        </button>
                                    </button>
                            </div>


                    <?php }
                        ++$count;
                    }
                    ?>

                </div>
            <?php } ?>
            <?php
            if ($roleta && $cotas_premiadas_roleta) {
                $cotas_premiadas_array_roleta = explode(',', $cotas_premiadas_roleta);

                foreach ($cotas_premiadas_array_roleta as $num) {
                    if (empty($num)) {
                        continue;
                    }
                    $stmt = $conn->prepare('SELECT customer_id FROM order_list WHERE FIND_IN_SET(?, order_numbers) AND product_id = ? AND status = 2 ');
                    $stmt->bind_param('si', $num, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    if ($result->num_rows > 0) {
                        $cotas_vendidas[] = ['cota' => $num, 'winner' => $row['customer_id']];
                    }
                }
                if ($cotas_vendidas) {
                    $all_lucky_numbers = array_column($cotas_vendidas, 'cota');
                    $cotas_premiadas_all = $cotas_premiadas_array_roleta;
                    $cotas_premiadas_sold_roleta = array_intersect($all_lucky_numbers, $cotas_premiadas_all);
                }
            ?>
                <div class="app-title mb-2 justify-content-between gap-2">
                    <div class="d-flex align-items-center">
                        <h1 style="font-size: 1.125rem;">🎯 Roletas Premiadas</h1>
                        <div class="app-title-desc p-0 m-0"><?= $cotas_premiadas_descricao_roleta ? $cotas_premiadas_descricao_roleta : 'Instantâneos' ?></div>
                    </div>
                    <div>
                        <span class="css-dtzixn">
                            <h6 class="MuiTypography-root MuiTypography-h6 css-1uw6jz8"><?= $cotas_premiadas_sold_roleta ? count($cotas_premiadas_sold_roleta) : 0 ?></h6> / <?= count($cotas_premiadas_array_roleta) ?>
                        </span>
                    </div>
                </div>
                <?php
                if ($available > 0 && $status == '1') {
                    if ($cotas_premiadas_roleta) {
                ?>
                        <div class="my-3">

                            <div id="cotas-container_roleta" class="mais app-titulos-premiados--lista d-flex flex-column mb-2 font-xs">

                            </div>
                            <?php if (count($cotas_premiadas_array_roleta) > 6) { ?>
                                <div id="cotas-container_roleta_mais">
                                    <button class="btn_mais_roleta MuiButton-root MuiButton-text MuiButton-textPrimary MuiButton-sizeMedium MuiButton-textSizeMedium MuiButton-fullWidth MuiButtonBase-root  css-1mcv32d" tabindex="0" type="button"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--mdi" sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6z"></path>
                                        </svg>Mostrar mais<span class="MuiTouchRipple-root css-w0pj6f"></span></button>
                                </div>
                            <?php } ?>
                        </div>
                <?php
                    }
                }
            }

            if ($box) { ?>
                <div class="app-title mb-2 gap-2" style="align-items: flex-start;">

                    <h1 style="font-size: 1.125rem;">🎁 Caixas Instantâneas</h1>
                    <div class="app-title-desc">premiadas</div>

                </div>
                <div class="mb-3">
                    <?php
                    $count = 0;
                    foreach ($boxs as $box) {
                        if ($box) { ?>
                            <div class="mb-2">
                                <?php if ($user_id) { ?>
                                    <div onclick="qtyRaffle(<?= $box['amount'] ?> + 1 , true)" class="btn w-100 text-center lh-1 bg-gradient-green text-white">
                                    <?php } else { ?>
                                        <div data-bs-toggle="modal" data-bs-target="#newCheckoutModal" onclick="qtyRaffle(<?= $box['amount'] ?> + 1, true)" class="btn w-100 text-center lh-1 bg-gradient-green text-white">
                                        <?php } ?>
                                        <div class="row mb-1 font-xs">
                                            <div class="col text-start">
                                                <div class="mb-1"><span style="font-size: 0.75rem;font-weight: 400;line-height: 1.5">A partir de</div>
                                                <div class="mb-1"><span class="fs-6" style="font-size: 1rem;"><?= $box['amount'] ?></span> Bilhetes</div>
                                                <div style="font-size: 0.75rem;font-weight: 400;line-height: 1.5"><small><?= $box['qty'] ?> chance(s) de contemplação nas Caixas Instantâneas</small>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <div>Recebe <?= $box['qty'] ?> Caixa(s)</div>
                                                <div class="col-auto">🎁</div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php
                            ++$count;
                        }
                            ?>

                            </div>
                </div>
            <?php
            }
            ?>

            <?php if ($box && $cotas_premiadas_box) {
                $cotas_premiadas_array_box = explode(',', $cotas_premiadas_box);
                foreach ($cotas_premiadas_array_box as $num) {
                    if (empty($num)) {
                        continue;
                    }

                    $stmt = $conn->prepare('SELECT customer_id FROM order_list WHERE FIND_IN_SET(?, order_numbers) AND product_id = ? AND status = 2 ');
                    $stmt->bind_param('si', $num, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    if ($result->num_rows > 0) {
                        $cotas_vendidas_box[] = ['cota' => $num, 'winner' => $row['customer_id']];
                    }
                }
                if ($cotas_vendidas_box) {
                    $all_lucky_numbers = array_column($cotas_vendidas_box, 'cota');
                    $cotas_premiadas_all = $cotas_premiadas_array_box;
                    $cotas_premiadas_sold_box = array_intersect($all_lucky_numbers, $cotas_premiadas_all);
                }
            ?>
                <div class="app-title mb-2 justify-content-between gap-2">
                    <div class="d-flex align-items-center">
                        <h1 style="font-size: 1.125rem;">🎁 Caixas Premiadas</h1>
                        <div class="app-title-desc"><?= $cotas_premiadas_descricao_box ? $cotas_premiadas_descricao_box : 'Instantâneos' ?></div>
                    </div>
                    <div>
                        <span class="css-dtzixn">
                            <h6 class="MuiTypography-root MuiTypography-h6 css-1uw6jz8"><?= $cotas_premiadas_sold_box ? count($cotas_premiadas_sold_box) : 0 ?></h6> / <?= count($cotas_premiadas_array_box) ?>
                        </span>
                    </div>
                </div>
                <?php
                if ($available > 0 && $status == '1') {
                    if ($cotas_premiadas_box) {
                ?>
                        <div class="my-3">

                            <div id="cotas-container_box" class="mais app-titulos-premiados--lista d-flex flex-column mb-3 font-xs">

                            </div>
                            <?php if (count($cotas_premiadas_array_box) > 6) { ?>
                                <div id="cotas-container_box_mais">
                                    <button class="btn_mais_box MuiButton-root MuiButton-text MuiButton-textPrimary MuiButton-sizeMedium MuiButton-textSizeMedium MuiButton-fullWidth MuiButtonBase-root  css-1mcv32d" tabindex="0" type="button"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--mdi" sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6z"></path>
                                        </svg>Mostrar mais<span class="MuiTouchRipple-root css-w0pj6f"></span></button>
                                </div>
                            <?php } ?>
                        </div>
            <?php
                    }
                }
            }

            ?>
            <?php if ($cotas_premiadas) { ?>
                <div class="app-title mb-2 gap-2" style="align-items: flex-start;">
                    <h1 style="font-size: 1.125rem;">🏆 Bilhetes Premiados</h1>
                    <div class="app-title-desc">Instantâneos</div>
                </div>
                <?php
                if ($available > 0 && $status == '1') {
                    if ($cotas_premiadas) {
                        $cotas_premiada = explode(',', $cotas_premiadas);
                ?>
                        <div class="my-3">

                            <div id="cotas-container" class="app-titulos-premiados--lista d-flex flex-column mb-2 font-xs">
                                <div class="skeleton"></div>
                                <div class="hr"></div>
                                <div class="skeleton"></div>
                                <div class="hr"></div>
                                <div class="skeleton"></div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>

            <?php

        }



        if (!empty($draw_number)) {
            $winners_qty = 5;
            $draw_number = isset($draw_number) ? $draw_number : '';
            if ($winners_qty && $draw_number) {
                $draw_winner = json_decode($draw_winner, true);
                $draw_number = json_decode($draw_number, true);
                $winners = [];

                foreach ($draw_winner as $qty_index => $name) {
                    foreach ($draw_number as $amount_index => $number) {
                        $query = $conn->query('SELECT CONCAT(firstname, \' \', lastname) as name, avatar FROM customer_list WHERE phone = \'' . $name . '\'');
                        $rowCustomer = $query->fetch_assoc();

                        if ($qty_index === $amount_index) {
                            $winners[$qty_index] = [
                                'name' => $rowCustomer['name'],
                                'number' => $number,
                                'image' => $rowCustomer['avatar'] ? validate_image($rowCustomer['avatar']) : BASE_URL . 'assets/img/avatar.png',
                            ];
                        }
                    }
                }
            }

            $count = 0;

            foreach ($winners as $winner) {
                ++$count;
            ?>
                <div class="app-card card bg-success text-white mb-2 mt-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="rounded-pill" style="width: 56px; height: 56px; position: relative; overflow: hidden;">
                                    <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                        <img alt="<?= $winner['name'] ?>" src="<?= $winner['image'] ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                        <noscript></noscript>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="mb-0" style="text-transform: uppercase;">
                                    <?= $count ?>º - <?= $winner['name'] ?><i class="bi bi-check-circle text-white-50"></i>
                                </h5>
                                <div class="text-white-50"><small>Ganhador(a) com a cota <?= $winner['number'] ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php

            }
        }



        ?>
        <div class="modal fade" id="modal-consultaCompras">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form id="consultMyNumbers">
                        <div class="modal-header">
                            <h6 class="modal-title">Consulta de compras</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <?php

                                if ($enable_cpf != 1) {
                                ?>
                                    <label class="form-label">Informe seu telefone</label>
                                    <div class="input-group mb-2">
                                        <input onkeyup="formatarTEL(this);" maxlength="15" class="form-control" aria-label="Número de telefone" maxlength="15" id="phone" name="phone" required="" value="">
                                        <button class="btn btn-secondary" type="submit" id="button-addon2">
                                            <div class=""><i class="bi bi-check-circle"></i></div>
                                        </button>
                                    </div>
                                <?php
                                } else { ?>
                                    <label class="form-label">Informe seu CPF</label>
                                    <div class="input-group mb-2">
                                        <input name="cpf" class="form-control" id="cpf" value="" maxlength="14" minlength="14" placeholder="000.000.000-00" oninput="formatarCPF(this.value)" required>
                                        <button class="btn btn-secondary" type="submit" id="button-addon2">
                                            <div class=""><i class="bi bi-check-circle"></i></div>
                                        </button>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal checkout -->
        <div class="modal fade" id="modal-checkout">
            <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <span class="d-none">Usuário não autenticado</span>
                    <div class="modal-header">
                        <h5 class="modal-title">Checkout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body checkout">
                        <div class="alert alert-info p-2 mb-2 font-xs"><i class="bi bi-check-circle"></i> Você está adquirindo<span class="font-weight-500">&nbsp;<span id="qty_cotas"></span> cotas</span><span>&nbsp;da ação entre amigos</span><span class="font-weight-500">&nbsp;<?= isset($name) ? $name : '' ?>
                            </span>,<span>&nbsp;seus números serão gerados</span><span>&nbsp;assim que concluir a compra.</span></div>
                        <div class="mb-3">
                            <div class="card app-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="rounded-pill p-1 bg-white box-shadow-08" style="width: 56px; height: 56px; position: relative; overflow: hidden;">
                                                <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                                    <img src="<?= validate_image($_settings->userdata('avatar')) ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                                    <noscript></noscript>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-1"><?= $_settings->userdata('firstname') ?> <?= $_settings->userdata('lastname') ?></h5>
                                            <div>
                                                <small><?= formatPhoneNumber($_settings->userdata('phone')) ?></small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-chevron-compact-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="place_order" data-id="<?= $_SESSION['ref'] ? $_SESSION['ref'] : '' ?>" class="btn btn-success w-100 mb-2">
                            Concluir reserva <i class="bi bi-arrow-right-circle"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-sm text-secondary text-decoration-none w-100 my-2"><a href="<?= BASE_URL . 'logout?' . $_SERVER['REQUEST_URI'] ?>">Utilizar outra conta</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal checkout -->
        <!-- Modal Aviso -->
        <button id="aviso_sorteio" data-bs-toggle="modal" data-bs-target="#modal-aviso" class="btn btn-success w-100 py-2" style="display:none"></button>
        <div class="modal fade" id="modal-aviso">
            <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title">Aviso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body checkout">
                        <div class="alert alert-danger p-2 mb-2 font-xs aviso-content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Aviso -->
        <div class="modal fade" id="modal-indique">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Indique e ganhe!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">Faça login para ter seu link de indicao, e ganhe at 0,00% de créditos nas compras aprovadas!</div>
                </div>
            </div>
        </div>
        <?php
        if ($enable_groups == 1) {
        ?>
            <div class="sorteio_sorteioShare__247_t" style="z-index:10;">
                <div class="campanha-share d-flex mb-1 justify-content-between align-items-center">
                    <?php

                    if ($enable_share == 1) { ?>

                        <div class="item d-flex align-items-center">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= BASE_URL ?>campanha/<?= $slug ?>" target="_blank">
                                <div alt="Compartilhe no Facebook" class="sorteio_sorteioShareLinkFacebook__2McKU" style="margin-right:5px;">
                                    <i class="bi bi-facebook"></i>
                                </div>
                            </a>
                            <a href="https://t.me/share/url?url=<?= BASE_URL ?>campanha/<?= $slug ?>" text='<?= $name ?>' target="_blank">
                                <div alt="Compartilhe no Telegram" class="sorteio_sorteioShareLinkTelegram__3a2_s" style="margin-right:5px;">
                                    <i class="bi bi-telegram"></i>
                                </div>
                            </a>
                            <a href="https://www.twitter.com/share?url=<?= BASE_URL ?>campanha/<?= $slug ?>" target="_blank">
                                <div alt="Compartilhe no Twitter" class="sorteio_sorteioShareLinkTwitter__1E4XC" style="margin-right:5px;">
                                    <i class="bi bi-twitter"></i>
                                </div>
                            </a>
                            <a href="https://api.whatsapp.com/send/?text=<?= $name ?>%21%21%3A+<?= BASE_URL ?>campanha/<?= $slug ?>&type=custom_url&app_absent=0" target="_blank">
                                <div alt="Compartilhe no WhatsApp" class="sorteio_sorteioShareLinkWhatsApp__2Vqhy"><i class="bi bi-whatsapp"></i></div>
                            </a>
                        </div>
                    <?php
                    }

                    ?>
                </div>
                <?php

                if ($whatsapp_group_url) {
                ?>
                    <a href="<?= $whatsapp_group_url ?>" target="_blank">
                        <div class="whatsapp-grupo">
                            <div class="btn btn-sm btn-success mb-1 w-100"><i class="bi bi-whatsapp"></i> Grupo</div>
                        </div>
                    </a>
                <?php
                }


                if ($telegram_group_url) {
                ?>
                    <a href="<?= $telegram_group_url ?>" target="_blank">
                        <div class="telegram-grupo">
                            <div class="btn btn-sm btn-info btn-block text-white mb-1 w-100"><i class="bi bi-telegram"></i> Telegram</div>
                        </div>
                    </a>
                <?php
                }


                if ($support_number) { ?>
                    <a href="https://api.whatsapp.com/send?phone=55<?= $support_number ?>" target="_blank">
                        <div class="suporte">
                            <div class="btn btn-sm btn-warning mb-1 w-100"><i class="bi bi-headset"></i></i> Suporte</div>
                        </div>
                    </a>
                <?php
                }

                ?>
            </div> <?php
                }

                    ?>




        <?php


        if ($quantidade_auto_cota == 1 || $quantidade_auto_cota_diario == 1): ?>
            <div class="app-title mb-2 gap-2" style="align-items: flex-start;">
                <h1 style="font-size: 1.125rem; filter: blur(0px);">🔄  Bilhete Maior e Menor</h1>
                <div class="app-title-desc" style="filter: blur(0px);">Instantâneos</div>
            </div>

            <div class="card <?= $bgTheme ?> sc-3f9a15f1-2 eAApiE bottom-container rounded-3xl w-full relative  mb-6 mt-6" style="border: 2px solid hsla(0, 0%, 100%, .16); padding: .5rem .5rem 1.5rem .5rem;">
                <div class="card-body ">
                    <?php if ($quantidade_auto_cota == 1): ?>
                        <div class="text-center text-white">Geral</div>
                        <div class="d-flex justify-content-evenly align-items-center gap-2 text-center">
                            <div class="maior text-white">
                                <h4 style="text-align:center; font-size: 1em !important; margin-block:1rem"><strong>Menor Bilhete</strong></h4>
                                <div class="category-green btn btn-success mb-2" id="minor-cota">
                                    <div class="skeleton" style="width: 100%; display: inline-flex; height: 100%; border-radius: 10px; background-color: inherit !important;"></div>
                                </div>
                                <span class="text-white mb-1" style="font-size: 16px" id="minor-winner">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                                <span class="text-white" style="font-size: 12px; opacity:0.8" id="minor-date">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                            </div>
                            <div class="menor text-white">
                                <h4 style="text-align:center; font-size: 1em !important; margin-block:1rem"><strong>Maior Bilhete</strong></h4>
                                <div class="category-green btn btn-success mb-2" id="major-cota">
                                    <div class="skeleton"
                                        style="width: 100%; display: inline-flex; height: 100%; border-radius: 10px; background-color: inherit !important;"></div>
                                </div>
                                <span class="text-white mb-1" style="font-size: 16px" id="major-winner">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                                <span class="text-white" style="font-size: 12px; opacity:0.8" id="major-date">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($quantidade_auto_cota_diario == 1): ?>
                        <!-- <div style="height: 1px !important" class="hr my-3"></div> -->
                        <div class="text-center text-white">Hoje</div>
                        <?php if ($cota_diaria_ini != '0000-00-00 00:00:00' && $cota_diaria_fim != '0000-00-00 00:00:00') {

                            // Converte a data para um objeto DateTime
                            $data_ini = new DateTime($cota_diaria_ini);
                            $data_fim = new DateTime($cota_diaria_fim);

                            // Formata a data para o formato 'DD/MM/YYYY HH:MM:SS'
                            $data_formatada_ini = $data_ini->format('d/m/Y H:i:s');
                            $data_formatada_fim = $data_fim->format('d/m/Y H:i:s');

                        ?>
                            <div class="text-center text-white  mb-1">Atenção esta geração de Maior e Menor Cota é contabilizado de <b><?= $data_formatada_ini ?></b> até <b><?= $data_formatada_fim ?></b></div>
                            <div class="text-center text-white fw-bolder">Promoção acaba em <button class="btn btn-sm btn-success px-2 py-0 contadorseg" id="contadorseg"></button></div>
                        <?php } ?>
                        <div class="d-flex justify-content-evenly align-items-center gap-2 text-center">
                            <div class="maior text-white ">
                                <h4 style="text-align:center; font-size: 1em !important; margin-block:1rem"><strong>Menor Bilhete</strong></h4>
                                <div class="category-green btn btn-success mb-2" id="minor-cota_today">
                                    <div class="skeleton" style="width: 100%; display: inline-flex; height: 100%; border-radius: 10px; background-color: inherit !important;"></div>
                                </div>
                                <span class=" mb-1" style="font-size: 16px" id="minor-winner_today">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                                <span class="" style="font-size: 12px; opacity:0.8" id="minor-date_today">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                            </div>
                            <div class="menor text-white">
                                <h4 style="text-align:center; font-size: 1em !important; margin-block:1rem"><strong>Maior Bilhete</strong></h4>
                                <div class="category-green btn btn-success mb-2" id="major-cota_today">
                                    <div class="skeleton"
                                        style="width: 100%; display: inline-flex; height: 100%; border-radius: 10px; background-color: inherit !important;"></div>
                                </div>
                                <span class=" mb-1" style="font-size: 16px" id="major-winner_today">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                                <span class="" style="font-size: 12px; opacity:0.8" id="major-date_today">
                                    <div class="skeleton" style="display: inline-flex; width:  100% !important; min-width:75px"></div>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        <?php endif;
        ?>






        <div class="sorteio-share d-flex mb-2 justify-content-between align-items-center">
            <div class="item d-flex align-items-center box-share-sorteio">
                <div alt="Compartilhe no Facebook" class="sorteio_sorteioShareLinkFacebook__2McKU"><i class="bi bi-facebook"></i></div>
                <div alt="Compartilhe no Telegram" class="sorteio_sorteioShareLinkTelegram__3a2_s"><i class="bi bi-telegram"></i></div>
                <div alt="Compartilhe no Twitter" class="sorteio_sorteioShareLinkTwitter__1E4XC"><i class="bi bi-twitter"></i></div>
                <div alt="Compartilhe no WhatsApp" class="sorteio_sorteioShareLinkWhatsApp__2Vqhy"><i class="bi bi-whatsapp"></i></div>
            </div>
        </div>
        <?= $_settings->userdata('is_affiliate') == 1 ? "afiliado" : "" ?>
        <?php if ($status == '1' && $_settings->userdata('is_affiliate') == 1) {
        ?>
            <section style="margin-top: 20px;background-color:#0f121a " class=" rounded-3xl flex overflow-hidden w-full relative mb-6 bg-app-primary-latte">
                <div class="top-0 px-6 xl:px-12 py-6 xl:py-10 z-10 flex flex-col w-full items-center">
                    <p style="color:white; margin-bottom:8px" class="font-bold text-base md:text-[32px] ">
                        Compartilhe com seus amigos
                    </p>
                    <p class="font-bold  md:text-[24px] " style="color:#157347; font-size:0.75rem; margin-bottom:16px ">
                        Ganhe comissões por cada venda!
                    </p>
                    <?php if ($_settings->userdata('id')) { ?>
                        <div data-bs-toggle="modal" data-bs-target="#modal-afiliado"
                            style="background-color:#157347; border-color:#157347;cursor:pointer;pointer-events:all; margin-inline:auto"
                            class="rounded-2xl py-2 px-3 text-caption bg-app-neutral-dark-1  hover:bg-app-neutral-dark-3 active:bg-app-neutral-dark-2  text-app-neutral-light-1 flex justify-around items-center  w-fit ">
                        <?php } else { ?>
                            <button data-bs-toggle="modal" data-bs-target="#newCheckoutModal"
                                style="background-color:#157347;color:#fff; border-color:#157347;cursor:pointer;pointer-events:all; "
                                class="rounded-2xl py-2 px-3 text-caption bg-app-neutral-dark-1  hover:bg-app-neutral-dark-3 active:bg-app-neutral-dark-2  text-app-neutral-light-1 flex justify-around items-center  w-fit ">
                            <?php } ?>


                            <p class="font-bold" style="margin-bottom:0">
                                <?php if ($_settings->userdata('id')) { ?>
                                    Gerar link
                                <?php } else { ?>
                                    Faça login para aproveitar
                                <?php } ?>
                            </p>
                            </button>
                        </div>
            </section>
        <?php
        } ?>
        <div style="color:#fff;max-height:100%" class="modal fade" tabindex="-1" id="modal-cotas">
            <div class="modal-dialog cotas">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="sc-3f9a15f1-13 byugCZ" style="gap:12px">
                            <div class="sc-3f9a15f1-28 kfFTzL line">🔥</div>
                            <h5 style="font-size: 1.3em !important;color: rgba(var(--incrivel-rgbaInvert), 0.9);padding-right: 5px;font-weight: 600;margin: 0;" class="sc-3f9a15f1-14 jQlWTy">Cotas premiadas</h5>
                        </div>
                        <button type="button" class=" btn btn-link text-dark menu-mobile--button pe-0 font-lgg"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 4px">
                        <div class="cotas_modal" style="padding:4px; height:100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-afiliado" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="justify-content: space-between" class="modal-header">
                        <button style="z-index:99999999999999" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="congrats__details">
                        <div class="congrats__title h1">
                            Quase lá!
                        </div>
                        <div class="congrats__content" style="align-items: center; display: flex; flex-direction: column; justify-content: center;">
                            Compartilhe seu link com todo mundo!
                            <button data-bs-toggle="modal" data-bs-target="#modal-afiliado-link"
                                style="background-color:#157347;color:#fff; border-color:#157347;cursor:pointer;pointer-events:all; margin-block: 10px;"
                                class="rounded-2xl py-2 px-3 text-caption bg-app-neutral-dark-1  hover:bg-app-neutral-dark-3 active:bg-app-neutral-dark-2  text-app-neutral-light-1 flex justify-around items-center  w-fit ">
                                <span class="text-caption">Compartilhar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-premios">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Top compradores</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Estes são os top compradores do sorteio <span class="font-weight-600"><?= $name ?></span>.</p>
                        <?php if ($enable_ranking_definido == 1): ?>
                            <?php if ($ranking_ini != '0000-00-00 00:00:00' && $ranking_fim != '0000-00-00 00:00:00') {

                                // Converte a data para um objeto DateTime
                                $r_data_ini = new DateTime($ranking_ini);
                                $r_data_fim = new DateTime($ranking_fim);

                                // Formata a data para o formato 'DD/MM/YYYY HH:MM:SS'  
                                $r_data_formatada_ini = $r_data_ini->format('d/m/Y H:i:s');
                                $r_data_formatada_fim = $r_data_fim->format('d/m/Y H:i:s');

                            ?>
                                <div class="text-center text-dark mb-1">Atenção esta ranking é contabilizado de <b><?= $r_data_formatada_ini ?></b> até <b><?= $r_data_formatada_fim ?></b></div>
                                <div class="text-center d-flex justify-content-center align-items-center text-white fw-bolder btn btn-dark">
                                    <div>Top Comprador acaba em</div> <button class="btn btn-sm btn-danger px-2 py-0 contadorsegranking" id="contadorsegranking"></button>
                                </div>
                        <?php }
                        endif;
                        ?>
                        <?php
                        $today = date('Y-m-d');
                        $hoje = date('Y-m-d H:i:s');
                        if ($ranking_type == 1 && $enable_ranking_definido == 0) {
                            $requests = $conn->query("\r\n" . ' SELECT c.firstname, SUM(o.quantity) AS total_quantity' . "\r\n" . ' FROM order_list o' . "\r\n" . ' INNER JOIN customer_list c ON o.customer_id = c.id' . "\r\n" . ' WHERE o.product_id = ' . $id . ' AND o.status = 2' . "\r\n" . ' GROUP BY o.customer_id' . "\r\n" . ' ORDER BY total_quantity DESC' . "\r\n" . ' LIMIT ' . $ranking_qty . "\r\n" . ' ');
                        } else if ($enable_ranking_definido == 1) {

                            if ($ranking_ini != '0000-00-00 00:00:00' && $ranking_fim != '0000-00-00 00:00:00') {
                                $requests = $conn->query("\r\n" . ' SELECT c.firstname, SUM(o.quantity) AS total_quantity' . "\r\n" . ' FROM order_list o' . "\r\n" . ' INNER JOIN customer_list c ON o.customer_id = c.id' . "\r\n" . ' WHERE o.product_id = ' . $id . ' AND o.status = 2' . "\r\n" . ' AND o.date_created >= \'' . $ranking_ini . '\' AND o.date_created <= \'' . $ranking_fim . '\'' . "\r\n" . ' GROUP BY o.customer_id' . "\r\n" . ' ORDER BY total_quantity DESC' . "\r\n" . ' LIMIT ' . $ranking_qty . "\r\n" . ' ');
                            }
                        } else {
                            $requests = $conn->query("\r\n" . ' SELECT c.firstname, SUM(o.quantity) AS total_quantity' . "\r\n" . ' FROM order_list o' . "\r\n" . ' INNER JOIN customer_list c ON o.customer_id = c.id' . "\r\n" . ' WHERE o.product_id = ' . $id . ' AND o.status = 2' . "\r\n" . ' AND o.date_created BETWEEN \'' . $today . ' 00:00:00\' AND \'' . $today . ' 23:59:59\'' . "\r\n" . ' GROUP BY o.customer_id' . "\r\n" . ' ORDER BY total_quantity DESC' . "\r\n" . ' LIMIT ' . $ranking_qty . "\r\n" . ' ');
                        }

                        $count = 0;

                        while ($row = $requests->fetch_assoc()) {
                            ++$count;

                            if ($count == 1) {
                                $medal = '<i class="bi bi-trophy text-warning" style="font-size:30px"></i>';
                            } elseif ($count == 2) {
                                $medal = '<i class="bi bi-trophy text-success" style="font-size:25px"></i>';
                            } elseif ($count == 3) {
                                $medal = '<i class="bi bi-trophy text-success" style="font-size:20px"></i>';
                            } else {
                                $medal = '👤';
                            }

                        ?>
                            <div>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="d-inline-block position-relative text-center py-1" style="width:50px"><span style="top:8px;right:-3px;font-size:12px;color:rgba(0,0,0,.6)" class="d-block position-absolute"></span><?= $medal ?></div>
                                    </div>
                                    <div class="col font-weight-600"><span style="font-size:20px"><?= $row['firstname'] ?>
                                            <?php if ($enable_ranking_show) { ?>
                                                -
                                                <?= $row['total_quantity'] ?>
                                                Bilhetes
                                            <?php } ?>
                                        </span></div>
                                </div>
                            </div>
                        <?php
                        }

                        ?>


                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-titulos">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bilhetes Premiados</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        if ($available > 0 && $status == '1') {
                            if ($cotas_premiadas) {
                                $cotas_premiada = explode(',', $cotas_premiadas);
                        ?>
                                <div class="my-3">

                                    <div id="cotas-container" class="app-titulos-premiados--lista d-flex flex-column mb-2 font-xs">
                                        <div class="skeleton"></div>
                                        <div class="hr"></div>
                                        <div class="skeleton"></div>
                                        <div class="hr"></div>
                                        <div class="skeleton"></div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-afiliado-link" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="justify-content: space-between" class="modal-header">
                        <button style="z-index:99999999999999" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align: center; margin-top: -25px; " class="congrats__title h1">
                            Link gerado!
                        </div>
                        <div class="congrats__content" style="align-items: center; display: flex; flex-direction: column; justify-content: center;">
                            Agora é só compartilhar!
                            <div class="share__field mt-4">
                                <input id="affiliate_url" class="share__input" type="text" name="site" disabled
                                    value="<?php echo BASE_REF . '?&ref=' . $id; ?>">
                                <button class="share__copy" onclick="copyPix()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-copy icon icon-copy" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" />
                                    </svg>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

</div>

<?php
if (isset($price)) {
    $price_total_upsell = intval($qtd_upsell) * (floatval($price) - ((floatval($price) * floatval($desconto_upsell)) / 100));
}
?>
<script>
    $(function() {
        $('.btn-descricao').click(function() {
            $('.animation-r').toggleClass('rotate')
        })
        $('#add_to_cart').click(function() {
            add_cart();
        })
        $('#place_order').click(function() {
            var ref = $(this).attr("data-id");
            place_order(ref);
        })
        $(".addNumero").click(function() {
            let value = parseInt($(".qty").val());
            value++;
            $(".qty").val(value);
            calculatePrice(value);
        })
        $(".removeNumero").click(function() {
            let value = parseInt($(".qty").val());
            if (value <= 1) {
                value = 1;
            } else {
                value--;
            }
            $(".qty").val(value);
            calculatePrice(value);
        })

        function place_order($ref) {
            $("#overlay").fadeIn(300);
            let valorUpsell = 0
            let qtdUpsell = 0
            if ($('#upsell').is(':checked')) {
                valorUpsell = parseFloat('<?= $price_total_upsell ?>');
                qtdUpsell = parseInt('<?= $qtd_upsell ?>')
            }
            $.ajax({
                url: _base_url_ + 'class/Main.php?action=place_order_process',
                method: 'POST',
                data: {
                    ref: $ref,
                    product_id: parseInt("<?= isset($id) ? $id : '' ?>"),
                    valorUpsell: valorUpsell,
                    qtdUpsell: qtdUpsell
                },
                dataType: 'json',
                timeout: 60000, // Define o timeout para 30 segundos (30000 ms)
                error: err => {
                    console.error(err)
                },
                success: function(resp) {
                    console.log(resp)
                    if (resp.status == 'success') {
                        location.replace(resp.redirect)
                    } else if (resp.status == 'pay2m') {
                        alert(resp.error);
                        location.replace(resp.redirect)
                    } else {
                        alert(resp.error);
                        location.reload();
                    }
                }
            })
        }
    })

    function formatCurrency(total) {
        var decimalSeparator = ',';
        var thousandsSeparator = '.';
        var formattedTotal = total.toFixed(2); // Define 2 casas decimais
        // Substitui o ponto pelo separador decimal desejado
        formattedTotal = formattedTotal.replace('.', decimalSeparator);
        // Formata o separador de milhar
        var parts = formattedTotal.split(decimalSeparator);
        parts[0] = parts[0].replace(/\\B(?=(\\d{3})+(?!\\d))/g, thousandsSeparator);
        // Retorna o valor formatado
        return parts.join(decimalSeparator);
    }

    function calculatePrice(qty) {
        let price = '<?= $price ?>'
        let enable_sale = parseInt(<?= $enable_sale ?>);
        let sale_qty = parseInt(<?= $sale_qty ?>);
        let sale_price = <?= $sale_price ?>;
        let available = parseInt(<?= $available ?>);
        let total = price * qty;
        var max = parseInt(<?= isset($max_purchase) ? $max_purchase : '' ?>);
        var min = parseInt(<?= isset($min_purchase) ? $min_purchase : '' ?>);
        if (qty > available) {
            //calculatePrice(available);   
            //alert(\'Há apenas : \' + available + \' cotas disponíveis no momento.\');
            $('.aviso-content').html('Restam apenas ' + available + ' cotas disponíveis no momento.');
            $('#aviso_sorteio').click();
            $(".qty").val(available);
            //total = price * available;
            //$(\'#total\').html(\'R$ \'+formatCurrency(total)+\'\');
            calculatePrice(available);
            return;
        }
        if (qty < min) {
            // calculatePrice(min);   
            //alert(\'A quantidade mínima de cotas é de: \' + min + \'\');
            $('.aviso-content').html('A quantidade mínima de cotas é de: ' + min + '');
            //$(\'#aviso_sorteio\').click();
            $(".qty").val(min);
            total = price * min;
            calculatePrice(min);
            //$(\'#total\').html(\'R$ \'+formatCurrency(total)+\'\');
            return;
        }

        if (qty > max) {
            //alert(\'A quantidade máxima de cotas é de: \' + max + \'\');
            $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
            //$(\'#aviso_sorteio\').click();
            $(".qty").val(max);
            total = price * max;
            calculatePrice(max);
            //$(\'#total\').html(\'R$ \'+formatCurrency(total)+\'\');
            return;
        }
        // Desconto acumulativo
        var qtd_desconto = parseInt(<?= $max_discount ?>);
        let dropeDescontos = [];
        for (i = 0; i < qtd_desconto; i++) {
            dropeDescontos[i] = {
                qtd: parseInt($(`#discount_qty_${i}`).text()),
                vlr: parseFloat($(`#discount_amount_${i}`).text())
            };
        }
        //console.log(dropeDescontos);
        var drope_desconto_qty = null;
        var drope_desconto = null;
        for (i = 0; i < dropeDescontos.length; i++) {
            if (qty >= dropeDescontos[i].qtd) {
                drope_desconto_qty = dropeDescontos[i].qtd;
                drope_desconto = dropeDescontos[i].vlr;
            }
        }
        var drope_desconto_aplicado = total;
        var desconto_acumulativo = false;
        var quantidade_de_numeros = drope_desconto_qty;
        var valor_do_desconto = drope_desconto;


        <?php
        if ($enable_cumulative_discount == 1) {
        ?>
            desconto_acumulativo = true;
        <?php
        }
        ?>
        if (desconto_acumulativo && qty >= quantidade_de_numeros) {
            var multiplicador_do_desconto = Math.floor(qty / quantidade_de_numeros);
            drope_desconto_aplicado = total - (valor_do_desconto * multiplicador_do_desconto);
        }
        // Aplicar desconto normal quando desconto acumulativo estiver desativado' .
        if (!desconto_acumulativo && qty >= drope_desconto_qty) {
            drope_desconto_aplicado = total - valor_do_desconto;
        }
        console.log(drope_desconto_qty)
        if (parseInt(qty) >= parseInt(drope_desconto_qty)) {
            $('#total').html('R$ ' + formatCurrency(drope_desconto_aplicado));
            $('.total').html('R$ ' + formatCurrency(drope_desconto_aplicado));
            $('.qtd').html(qty)
            $('.preco').html(formatCurrency(price))
        } else {
            console.log(valor_do_desconto)
            if (enable_sale == 1 && qty >= sale_qty) {
                total_sale = qty * sale_price;
                $('#total').html('De <strike>R$ ' + formatCurrency(total) + '</strike> por R$ ' + formatCurrency(total_sale));
                $('.total').html('De <strike>R$ ' + formatCurrency(total) + '</strike> por R$ ' + formatCurrency(total_sale));
                $('.qtd').html(qty)
                $('.preco').html(formatCurrency(price))
            } else {
                var desc = total - valor_do_desconto
                $('#total').html('R$ ' + formatCurrency(total));
                $('.total').html('R$ ' + formatCurrency(total));
                $('.qtd').html(qty)
                $('.preco').html(formatCurrency(price))
            }
        }
        //Fim desconto acumulativo
    }

    function qtyRaffle(qty, opt) {
        qty = parseInt(qty);
        let value = parseInt($(".qty").val());
        let qtyTotal = (value + qty);
        if (opt === true) {
            qtyTotal = (qtyTotal - value);
        }
        $(".qty").val(qtyTotal);
        calculatePrice(qtyTotal);
    }

    function add_cart() {
        let upsell = false
        if ($('#upsell').is(':checked')) {
            upsell = true;
        }
        let qty = $('.qty').val();

        $('#qty_cotas').text(qty);
        $.ajax({
            url: _base_url_ + "class/Main.php?action=add_to_card",
            method: "POST",
            data: {
                product_id: "<?= isset($id) ? $id : '' ?>",
                qty: qty,
                upsell: upsell
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert("[PP01] - An error occured.", 'error');

            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    //location.reload();
                } else if (!!resp.msg) {
                    alert(resp.msg, 'error');
                } else {
                    alert("[PP02] - An error occured.", 'error');
                }
            }
        })
    }
    $(document).ready(function() {
        $('.qty').on('keyup', function() {
            var value = parseInt($(this).val());
            var min = parseInt(<?= isset($min_purchase) ? $min_purchase : '' ?>);
            var max = parseInt(<?= isset($max_purchase) ? $max_purchase : '' ?>);
            if (value < min) {
                calculatePrice(min);
                //alert(\'A quantidade mínima de cotas é de: \' + min + \'\');
                $('.aviso-content').html('A quantidade mínima de cotas é de: ' + min + '');
                $('#aviso_sorteio').click();
                $(".qty").val(min);
            }
            if (value > max) {
                calculatePrice(max);
                //alert(\'A quantidade máxima de cotas é de: \' + max + \'\');
                $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
                $('#aviso_sorteio').click();
                $(".qty").val(max);
            }
        });
    });
    $(document).ready(function() {
        $('#consultMyNumbers').submit(function(e) {
            e.preventDefault()
            var tipo = "<?= $search_type ?>"

            $.ajax({
                url: _base_url_ + "class/Main.php?action=" + tipo,
                method: 'POST',
                type: 'POST',
                data: new FormData($(this)[0]),
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                error: err => {
                    console.log(err)
                    alert('An error occurred')
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.href = (resp.redirect)
                    } else {
                        alert('Nenhum registro de compra foi encontrado')
                        console.log(resp)
                    }
                }
            })
        })
    })
</script>
<script>
    function copyPix() {
        var copyText = document.getElementById("affiliate_url");

        copyText.select();
        copyText.setSelectionRange(0, 99999);

        document.execCommand("copy");
        navigator.clipboard.writeText(copyText.value);

        alert("Link copiado com sucesso");
    };
    $(document).ready(function() {

        var cotas_array = '<?php echo isset($cotas_premiadas_premios) ? $cotas_premiadas_premios : ''; ?>';
        var product_id = parseInt("<?php echo isset($id) ? $id : ''; ?>");
        var cotas_premiadas = "<?php echo isset($cotas_premiadas) ? $cotas_premiadas : ''; ?>";
        var $quantidade_auto_cota = "<?php echo isset($quantidade_auto_cota) ? $quantidade_auto_cota : ''; ?>";
        $.ajax({
            url: _base_url_ + "class/Main.php?action=load_cotas",

            method: 'POST',
            data: {
                product_id: product_id,
                cotas_premiadas: cotas_premiadas,
                cotas_array: cotas_array,
                quantidade_auto_cota: $quantidade_auto_cota
            },
            success: function(response) {
                var cotas = response.split('<div class="hr"></div>');
                var cotas_premiadas = cotas.slice(0, 3).join('<div class="hr"></div>');
                $('#cotas-container').html(cotas_premiadas);
                $('.cotas_modal').html(response);

            },
            error: function() {
                $('#cotas-container').html('<p>Erro ao carregar as cotas.</p>');
            }
        });

    });
    $(document).ready(function() {

        var cotas_array = '<?php echo isset($cotas_premiadas_premios_roleta) ? $cotas_premiadas_premios_roleta : ''; ?>';
        var product_id = parseInt("<?php echo isset($id) ? $id : ''; ?>");
        var cotas_premiadas = "<?php echo isset($cotas_premiadas_roleta) ? $cotas_premiadas_roleta : ''; ?>";
        var $quantidade_auto_cota = "<?php echo isset($quantidade_auto_cota) ? $quantidade_auto_cota : ''; ?>";
        $.ajax({
            url: _base_url_ + "class/Main.php?action=load_cotas_roleta",
            method: 'POST',
            data: {
                product_id: product_id,
                cotas_premiadas: cotas_premiadas,
                cotas_array: cotas_array,
                quantidade_auto_cota: $quantidade_auto_cota
            },
            success: function(response) {
                var cotas = response.split('<div class="hr"></div>');
                var cotas_premiadas = cotas.slice(0, 3).join('<div class="hr"></div>');
                $('#cotas-container_roleta').html(cotas_premiadas);

            },
            error: function() {
                $('#cotas-container_roleta').html('<p>Erro ao carregar os bilhetes.</p>');
            }
        });
        $('.btn_mais_roleta').click(function() {
            $('#cotas-container_roleta').toggleClass("mais");

            if ($('#cotas-container_roleta').hasClass("mais")) {
                $(this).html(`
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--mdi" sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6z"></path>
                                                </svg>
                                                Mostrar mais<span class="MuiTouchRipple-root css-w0pj6f"></span>
                                            `);
            } else {
                $(this).html(`
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--mdi" sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6l-6 6z"></path>
                                                </svg>
                                                
                                                Mostrar menos<span class="MuiTouchRipple-root css-w0pj6f"></span>
                                            `);
            }
        });
    });
    $(document).ready(function() {

        var cotas_array = '<?php echo isset($cotas_premiadas_premios_box) ? $cotas_premiadas_premios_box : ''; ?>';
        var product_id = parseInt("<?php echo isset($id) ? $id : ''; ?>");
        var cotas_premiadas = "<?php echo isset($cotas_premiadas_box) ? $cotas_premiadas_box : ''; ?>";
        var $quantidade_auto_cota = "<?php echo isset($quantidade_auto_cota) ? $quantidade_auto_cota : ''; ?>";
        $.ajax({
            url: _base_url_ + "class/Main.php?action=load_cotas_box",
            method: 'POST',
            data: {
                product_id: product_id,
                cotas_premiadas: cotas_premiadas,
                cotas_array: cotas_array,
                quantidade_auto_cota: $quantidade_auto_cota
            },
            success: function(response) {
                var cotas = response.split('<div class="hr"></div>');
                var cotas_premiadas = cotas.slice(0, 3).join('<div class="hr"></div>');
                $('#cotas-container_box').html(cotas_premiadas);

            },
            error: function() {
                $('#cotas-container_box').html('<p>Erro ao carregar os bilhetes.</p>');
            }
        });
        $('.btn_mais_box').click(function() {
            $('#cotas-container_box').toggleClass("mais");

            if ($('#cotas-container_box').hasClass("mais")) {
                $(this).html(`
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--mdi" sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6z"></path>
                                                </svg>
                                                Mostrar mais<span class="MuiTouchRipple-root css-w0pj6f"></span>
                                            `);
            } else {
                $(this).html(`
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--mdi" sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6l-6 6z"></path>
                                                </svg>
                                                
                                                Mostrar menos<span class="MuiTouchRipple-root css-w0pj6f"></span>
                                            `);
            }
        });
    });
    $(document).ready(function() {
        // Salva o elemento do header
        var header = $('.header-app-header.campanha .header-app-header-container');

        // Define a altura em que o scroll vai ser detectado
        var scrollTrigger = 50; // Altere para o valor que preferir (em pixels)

        // Adiciona um ouvinte de evento para o scroll
        $(window).on('scroll', function() {
            // Verifica a posição do scroll
            if ($(this).scrollTop() > scrollTrigger) {
                // Se o scroll estiver abaixo do valor de scrollTrigger, altera a cor de fundo
                header.css('background-color', '#00307a');
            } else {
                // Se o scroll estiver acima do valor de scrollTrigger, restaura a cor transparente
                header.css('background-color', 'transparent');
            }
        });
    });
</script>
<?php if ($quantidade_auto_cota == 1) {
?>
    <script>
        $(document).ready(function() {
            var raffle = parseInt("<?php echo isset($id) ? $id : ''; ?>");
            $.ajax({
                url: _base_url_ + "class/Main.php?action=search_raffle_smallest_and_largest_number",
                method: 'POST',
                data: {
                    raffle: raffle
                },
                success: function(response) {

                    var data = JSON.parse(response);
                    console.log(data)

                    if (data.status == 'success') {
                        $('#major-cota').html(data.major.cota);
                        $('#major-winner').html(data.major.name);
                        $('#major-date').html(data.major.date);

                        $('#minor-cota').html(data.minor.cota);
                        $('#minor-winner').html(data.minor.name);
                        $('#minor-date').html(data.minor.date);

                    }

                },
                error: function() {}
            });
        })
    </script>
<?php
} ?>
<?php if ($quantidade_auto_cota_diario == 1) {
?>
    <script>
        $(document).ready(function() {
            var raffle = parseInt("<?php echo isset($id) ? $id : ''; ?>");
            $.ajax({
                url: _base_url_ + "class/Main.php?action=search_raffle_smallest_and_largest_number_today",
                method: 'POST',
                data: {
                    raffle: raffle,
                    data_ini: '<?= $cota_diaria_ini ?>',
                    data_fim: '<?= $cota_diaria_fim ?>'
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data)
                    if (data.status == 'success') {
                        $('#major-cota_today').html(data.major.cota);
                        $('#major-winner_today').html(data.major.name);
                        $('#major-date_today').html(data.major.date);

                        $('#minor-cota_today').html(data.minor.cota);
                        $('#minor-winner_today').html(data.minor.name);
                        $('#minor-date_today').html(data.minor.date);

                    }

                },
                error: function() {}
            });
        })
    </script>
    <script>
        // Defina a data de fim - em formato de string (ex: '2025-02-02T12:00:00')
        var cota_diaria_fim = '<?= $cota_diaria_fim ?>';

        // Função para atualizar o contador
        function atualizarContador() {
            // Data atual
            var dataAtual = new Date();

            // Data de fim
            var dataFim = new Date(cota_diaria_fim);

            // Calculando a diferença em milissegundos
            var diferença = dataFim - dataAtual;

            if (diferença > 0) {
                // Calculando os dias, horas, minutos e segundos restantes
                var dias = Math.floor(diferença / (1000 * 60 * 60 * 24));
                var horas = Math.floor((diferença % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutos = Math.floor((diferença % (1000 * 60 * 60)) / (1000 * 60));
                var segundos = Math.floor((diferença % (1000 * 60)) / 1000);

                // Exibindo o contador no formato: "X dias, Y horas, Z minutos, W segundos"
                document.getElementById("contadorseg").innerHTML =
                    "<i class='bi bi-alarm me-2'></i>" + dias + " dias, " + horas + ":" + minutos + ":" + segundos;
            } else {
                // Caso o tempo tenha expirado
                document.getElementById("contadorseg").innerHTML = "O sorteio já foi finalizado!";
            }
        }

        // Atualizar o contador a cada segundo
        setInterval(atualizarContador, 1000);

        // Chamar a função uma vez ao carregar a página
        atualizarContador();
    </script>
<?php
}
if ($enable_ranking_definido == 1) { ?>
    <script>
        // Defina a data de fim - em formato de string (ex: '2025-02-02T12:00:00')
        var ranking_fim = '<?= $ranking_fim ?>';

        // Função para atualizar o contador
        function atualizarContadorRanking() {
            // Data atual
            var dataAtual = new Date();

            // Data de fim
            var dataFim = new Date(ranking_fim);

            // Calculando a diferença em milissegundos
            var diferença = dataFim - dataAtual;

            if (diferença > 0) {
                // Calculando os dias, horas, minutos e segundos restantes
                var dias = Math.floor(diferença / (1000 * 60 * 60 * 24));
                var horas = Math.floor((diferença % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutos = Math.floor((diferença % (1000 * 60 * 60)) / (1000 * 60));
                var segundos = Math.floor((diferença % (1000 * 60)) / 1000);

                // Exibindo o contador no formato: "X dias, Y horas, Z minutos, W segundos"
                document.getElementById("contadorsegranking").innerHTML =
                    "<i class='bi bi-alarm me-2'></i>" + dias + " dias, " + horas + ":" + minutos + ":" + segundos;
            } else {
                // Caso o tempo tenha expirado
                document.getElementById("contadorsegranking").innerHTML = "O sorteio já foi finalizado!";
            }
        }

        // Atualizar o contador a cada segundo
        setInterval(atualizarContadorRanking, 1000);

        // Chamar a função uma vez ao carregar a página
        atualizarContadorRanking();
    </script>
<?php }
?>