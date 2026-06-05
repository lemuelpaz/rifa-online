<?php

$raffle = isset($_GET['raffle']) ? $_GET['raffle'] : '';
$top = isset($_GET['top']) ? $_GET['top'] : '';
$raffleb = isset($_GET['raffleb']) ? $_GET['raffleb'] : '';
$rafflec = isset($_GET['rafflec']) ? $_GET['rafflec'] : '';
$raffled = isset($_GET['raffled']) ? $_GET['raffled'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '';
?>

<script>
    var _BASE_URL_ = '<?= BASE_URL ?>';
</script>

<style>
    @media (min-width: 1024px) {
        .lg\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    tr.text-gray-700.dark\:text-gray-400 {
        vertical-align: text-bottom;
    }

    .span-whats {
        width: 100%;
        justify-content: space-around;
        margin-top: 10px;
    }



    .span-whats>a {
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
        padding: 8px;
        gap: 3px;
        width: 45%;
        max-height: 38px;
        background-color: #0e9f6e;
    }

    .span-whats>button {
        justify-content: space-evenly;
        align-content: center;
        align-items: center;
        padding: 8px;
        gap: 3px;
        max-height: 38px;
        width: 45%;
    }

    #btn-whats>svg {
        width: 25px;
        height: 25px;
        max-width: 25px;
        min-width: 15px;
        max-height: 25px;
        min-height: 15px;
    }

    .winner-info span {
        display: block;
    }

    .btwp-new {
        background-color: #0e9f6e;
        display: inline-flex;
    }

    .flex-container {
        display: flex;

    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
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
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    .px-2 {
        padding-left: .25rem;
        padding-right: .25rem;
    }
</style>

<div id="overlay" style="display: none;">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>

</div>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">PageView</h2>

        <!--Busca Ganhador x Ranking -->
        <hr>
        <div class="py-3">
            <h3 class="flex">Visualizações
                <span style="margin-left: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                    </svg>
                </span>
            </h3>
            <?php
            $geral = $conn->query('SELECT * FROM page_view');
            $geralPixel = $conn->query('SELECT * FROM page_view WHERE origin = 2');
            // Consulta para as visualizações totais agrupadas por produto e origem
            $totalPageView = $conn->query('
				SELECT pl.name AS product_name, pv.origin, COUNT(*) AS total_views
				FROM page_view pv
				LEFT JOIN product_list pl ON NULLIF(pv.product_id, \'\')::integer = pl.id
				GROUP BY pl.name, pv.product_id, pv.origin
			');

            // Consulta para as visualizações Pixel agrupadas por produto
            $totalPageViewPixel = $conn->query('
				SELECT pl.name AS product_name, COUNT(*) AS total_pixel_views
				FROM page_view pv
				LEFT JOIN product_list pl ON pv.product_id = pl.id
				WHERE pv.origin = 2
				GROUP BY pv.product_id
			');

            ?>
            <div>

                <?php


                ?>
                <div>
                    <div>
                        <span>Total Visualizações Geral:</span> <b><?= $geral->num_rows ?></b>
                    </div>
                    <div>
                        <span>Total Visualizações Pixel:</span> <b><?= $geralPixel->num_rows ?></b>
                    </div>
                </div>
                <!-- Exibir os totais de visualizações por produto e origem -->
                <div>
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-green-100 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Pagina</th>
                                <th class="px-4 py-3">Normal</th>
                                <th class="px-4 py-3">Pixel</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <?php
                            // Agrupando os totais de visualizações por produto e origem
                            $views = [];
                            while ($totalPageView && $row = $totalPageView->fetch_assoc()) {
                                $product_name = (empty($row['product_name'])) ? 'Home' : htmlspecialchars($row['product_name']);
                                $origin = ($row['origin'] == 2) ? 'Pixel' : 'Normal';

                                // Adiciona a contagem de visualizações por produto e origem
                                if (!isset($views[$product_name])) {
                                    $views[$product_name] = ['Normal' => 0, 'Pixel' => 0];
                                }
                                $views[$product_name][$origin] += $row['total_views'];
                            }

                            // Exibindo os resultados
                            foreach ($views as $product_name => $totals) {
                                echo '<tr class="text-gray-700 dark:text-gray-400">';
                                echo '<td class="px-4 py-3">' . $product_name . '</td>';
                                echo '<td class="px-4 py-3">' . $totals['Normal'] . '</td>';
                                echo '<td class="px-4 py-3">' . $totals['Pixel'] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



</main>
<!-- fim Pageviws -->

<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    style="display: none;">
    <!-- Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        role="dialog" id="modal" style="display: none;">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
            <button
                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                aria-label="close" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <div class="">
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                Salvar ganhador?
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-400">
                Você realmente deseja salvar o ganhador no sorteio?
            </p><br>
            <div class="flex items-center bg-yellow rounded-lg mb-2 p-2">
                <div class="mr-3">
                    <i class="" style="font-size:34px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="white"
                            class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                    </i>
                </div>
                <div class="text-sm text-gray-700 dark:text-gray-400">
                    Após salvar o ganhador o sorteio será marcado como concluído.
                </div>
            </div>



        </div>
        <footer
            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
            <button @click="closeModal"
                class="close-modal w-full px-5 py-3 text-sm font-medium leading-5 text-white bg-red transition-colors duration-150 border border-transparent rounded-lg dark:text-white sm:px-4 sm:py-2 sm:w-auto active:bg-red focus:border-transparent active:text-white focus:outline-none focus:shadow-outline-red">
                Não
            </button>
            <button id="save_winner"
                class="delete_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Sim
            </button>
        </footer>
    </div>
</div>



















<script>
    function hideView() {
        var x = document.getElementById("hide-view");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    $(document).ready(function() {

        $('#get-ganhador').on('click', function() {
            $("#error").empty()

            if ($('#raffle').val() == '') {
                alert('Selecione uma campanha');
                return false;

            }
            if ($('#number').val() == '') {
                alert('Digite um número');
                return false;

            }

            $('#buscar-ganhador').submit();
        });
        $('#buscar-ganhador').submit(function(e) {
            e.preventDefault()
            $('.results-container').addClass('hidden')
            $('#overlay').css('display', 'block')
            $("#error").empty().css('display', 'none')


            $.ajax({
                url: _BASE_URL_ + "class/Main.php?action=search_raffle_winner",
                method: 'POST',
                type: 'POST',
                data: new FormData($(this)[0]),
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                error: err => {
                    console.log(err)


                },
                success: function(resp) {
                    if (resp.status == 'success' && resp.name) {
                        var whats_number = resp.phone.replace(/\D/g, '');
                        console.log(resp);
                        $('#pedido').html('<strong>Campanha:</strong> ' + resp
                            .product_name);
                        $('#name').html('<strong>Nome:</strong> ' + resp.name);
                        $('#date').html('<strong>Data da compra:</strong> ' + resp.date);
                        $('#number').html('<strong>Número/Bicho Sorteado:</strong> ' + resp.number);
                        $('#set-winner').attr('data-id', $('#raffle').val()).attr(
                            'data-number', resp.number).attr('data-winner', resp.phone);

                        $('#payment_status').html('<strong>Status:</strong> ' + resp
                            .payment_status);
                        $('#overlay').css('display', 'none')
                        $(".results-container").removeClass('hidden')
                        $("#btn-whats").attr('href',
                            'https://api.whatsapp.com/send?phone=55' + whats_number +
                            '&text=Olá, ' + resp.name +
                            ', você foi o ganhador da campanha ' + resp.product_name +
                            ' com o número ' + resp.number + '! Parabéns!');




                    } else {
                        $('#overlay').css('display', 'none')
                        $('#name').html('');
                        $('#phone').html('');
                        $('#date').html('');
                        $('#number').html('');
                        $('#payment_status').html('');
                        $("#error").html('Vencedor não encontrado, tente outro número').css(
                            'display', 'block');
                        $("#span-whats").addClass('hidden').removeClass('flex');
                        $('#winner_info').addClass('hidden')


                        console.log(resp)
                    }
                }
            })
        })

        $('#save_winner').on('click', function() {
            $('#overlay').css('display', 'block')
            var id = $('#set-winner').attr('data-id');
            var draw_number = $('#set-winner').attr('data-number');
            var draw_winner = $('#set-winner').attr('data-winner');



            $.ajax({
                url: _BASE_URL_ + "class/Main.php?action=save_raffle_winner",
                method: 'POST',
                type: 'POST',
                data: {
                    id: id,
                    draw_number: draw_number,
                    draw_winner: draw_winner
                },
                dataType: 'json',
                error: err => {
                    console.log(err)
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        $('#overlay').css('display', 'none')
                        $('.close-modal').click();
                        alert('Ganhador salvo com sucesso');

                    } else {
                        $('#overlay').css('display', 'none')
                        $('#error').html('Erro ao salvar ganhador').css('display', 'block');


                    }
                }
            })

        })

        $('#buscar-ganhador-menor-maior-cota').submit(function(e) {
            e.preventDefault();


            $('#overlay').fadeIn(300);
            $.ajax({
                url: _base_url_ +
                    "class/Main.php?action=search_raffle_smallest_and_largest_number",
                method: 'POST',
                type: 'POST',
                data: new FormData($(this)[0]),
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                error: function(err) {
                    console.log(err);
                    alert('An error occurred');
                },
                success: function(resp) {

                    if (Array.isArray(resp) && resp.length > 0) {
                        $('#name2, #phone2, #date2, #number2, #payment_status2, #whatsapp_msg2, #date_updated2')
                            .html('');
                        $('.result-container2').remove();

                        resp.forEach(function(result) {
                            // Cria uma div de contêiner para cada resultado
                            var container = $(
                                '<div class="result-container"></div>');

                            // Adiciona os elementos dentro do contêiner
                            container.append(
                                '<strong>Nome:</strong> <spam class="uppercase">' +
                                result.name + '</spam><br>');
                            container.append('<strong>Data da compra:</strong> ' +
                                result.date + '<br>');
                            container.append('<strong>Número/Bicho:</strong> ' +
                                result.number + '<br>');
                            container.append('<strong>Status:</strong> ' + result
                                .payment_status + '<br>');

                            if (result.payment_status == 'Pago') {
                                $('#setWinner').html('');
                                var phone = result.phone;
                                var msg_ganhador = result.msg_ganhador;
                                var phoned = phone.replace(/\D/g, '');
                                var date_updated = result.date_updated;
                                container.append(
                                    '<strong>Data do pagamento:</strong> ' +
                                    result.date_updated + '<br>');
                                container.append('');

                            }

                            container.append('<br><br>');

                            // Adiciona o contêiner ao local desejado na página
                            $('.results-container2').append(container);
                        });
                    } else if (resp.status == 'success') {
                        $('.result-container2').remove();
                        $('#name2, #phone2, #date2, #number2, #payment_status2, #whatsapp_msg2, #date_updated2')
                            .html('');
                        $('#name2').append(
                            '<strong>Nome:</strong> <spam class="uppercase">' + resp
                            .name + '</spam><br>');
                        $('#date2').append('<strong>Data da compra:</strong> ' + resp.date +
                            '<br>');
                        $('#number2').append('<strong>Número:</strong> ' + resp.number +
                            '<br>');
                        $('#payment_status2').append('<strong>Status:</strong> ' + resp
                            .payment_status + '<br>');

                        if (resp.payment_status == 'Pago') {
                            var phone = resp.phone;
                            var msg_ganhador = resp.msg_ganhador;
                            var phoned = phone.replace(/\D/g, '');
                            var date_updated = resp.date_updated;

                            $('#date_updated2').append(
                                '<strong>Data do pagamento:</strong> ' + resp
                                .date_updated + '<br>');
                            $('#whatsapp_msg2').html(
                                '<div class="flex-container mt-4"><a href="https://api.whatsapp.com/send?phone=55' +
                                phoned + '&text=' + msg_ganhador +
                                '" target="_blank"><div class="btwp-new mr-3 flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg focus:outline-none focus:shadow-outline-purple"><i class=" mr-2" style="font-size:18px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-whatsapp" viewBox="0 0 16 16"> <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" /></svg></i><span>Enviar mensagem</span></div></a></div>'
                            );
                            $('#setWinner').html('');
                        }
                        $('.winner2').html('');
                    } else {
                        $('#name2').html('');
                        $('#date2').html('');
                        $('#number2').html('');
                        $('#payment_status2').html('');
                        $('#date_updated2').html('');
                        $('#whatsapp_msg2').html('');
                        $('#setWinner').html('');
                        $('.winner2').html(
                            '<div class="rounded-lg p-4 mb-2 text-sm leading-tight text-orange-700 bg-orange-100 dark:text-white dark:bg-orange-600"> Nenhum ganhador encontrado!<br>O número ou bicho sorteado não foi comprado, portanto, não há ganhador neste sorteio.</div>'
                        );
                        console.log(resp);
                    }
                    $('#overlay').fadeOut(300);
                }
            });
        });

    })
</script>