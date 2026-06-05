<?php
$ondapay = $_settings->info('ondapay');
$ondapay_client_id = $_settings->info('ondapay_client_id');
$ondapay_client_secret = $_settings->info('ondapay_client_secret');
$ondapay_webhook_url = $_settings->info('ondapay_webhook_url') ? $_settings->info('ondapay_webhook_url') : base_url . 'webhook.php?notify=ondapay';

$pixup = $_settings->info('pixup');
$pixup_client_id = $_settings->info('pixup_client_id');
$pixup_client_secret = $_settings->info('pixup_client_secret');
$pixup_webhook_url = base_url . 'webhook.php?notify=pixup';

?>
<style>
    .active-tab {
        border-bottom: none !important;
    }

    .can-toggle {
        position: relative;
        margin-bottom: 20px;
    }

    .can-toggle *,
    .can-toggle *:before,
    .can-toggle *:after {
        box-sizing: border-box;
    }

    .can-toggle input[type=checkbox] {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before {
        content: attr(data-unchecked);
        left: 0;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        content: attr(data-checked);
    }

    .can-toggle label {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        position: relative;
        display: flex;
        align-items: center;
    }

    .can-toggle label .can-toggle__switch {
        position: relative;
    }

    .can-toggle label .can-toggle__switch:before {
        content: attr(data-checked);
        position: absolute;
        top: 0;
        text-transform: uppercase;
        text-align: center;
    }

    .can-toggle label .can-toggle__switch:after {
        content: attr(data-unchecked);
        position: absolute;
        z-index: 5;
        text-transform: uppercase;
        text-align: center;
        background: white;
        transform: translate3d(0, 0, 0);
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch {
        background-color: #777;
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
        color: #5e5e5e;
    }

    .can-toggle input[type=checkbox]:hover~label {
        color: #6a6a6a;
    }

    .can-toggle input[type=checkbox]:checked~label:hover {
        color: #55bc49;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch {
        background-color: #70c767;
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        color: #4fb743;
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch {
        background-color: #5fc054;
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
        color: #47a43d;
    }

    .can-toggle label .can-toggle__switch {
        transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
        background: #848484;
    }

    .can-toggle label .can-toggle__switch:before {
        color: rgba(255, 255, 255, 0.5);
    }

    .can-toggle label .can-toggle__switch:after {
        transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
        color: #777;
    }

    .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
        transform: translate3d(65px, 0, 0);
    }

    .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
    .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    .can-toggle label {
        font-size: 14px;
    }

    .can-toggle label .can-toggle__switch {
        height: 36px;
        flex: 0 0 134px;
        border-radius: 4px;
    }

    .can-toggle label .can-toggle__switch:before {
        left: 67px;
        font-size: 12px;
        line-height: 36px;
        width: 67px;
        padding: 0 12px;
    }

    .can-toggle label .can-toggle__switch:after {
        top: 2px;
        left: 2px;
        border-radius: 2px;
        width: 65px;
        line-height: 32px;
        font-size: 12px;
    }

    .can-toggle label .can-toggle__switch:hover:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    }

    @media all and (max-width: 40em) {
        #tabs {
            flex-wrap: wrap;
        }

        #tabs .mr-1 {
            margin-bottom: 15px;
        }
    }
</style>
<main class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Forma de Pagamentos</h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="flex">
            <ul class="flex" id="tabs">
               
                <li class="mr-1">
                    <a href="#tab1"
                        class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">OndaPay</a>
                </li>
                <li class="mr-1">
                    <a href="#tab2"
                        class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">PixUp</a>
                </li>


            </ul>
        </div>

        <form action="" id="gateway-form">
            <div class="mt-4">
                

                 <div id="tab1" class="tabcontent hidden text-gray-700 dark:text-gray-400">
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar OndaPay?</span>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" name="ondapay" id="ondapay"
                            <?= isset($ondapay) && $ondapay == 1 ? 'checked' : '' ?>>
                        <label for="ondapay">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>
                    <div class="ondapay" style="display: none;">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400"><strong>Client ID:</strong></span>
                            <input name="ondapay_client_id" id="ondapay_client_id"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="<?= $ondapay_client_id ?>" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
                            <input name="ondapay_client_secret" id="ondapay_client_secret"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="<?= $ondapay_client_secret ?>" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400"><strong>Webhook URL:</strong></span>
                            <input name="ondapay_webhook_url" id="ondapay_webhook_url"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="<?= $ondapay_webhook_url ?>" />
                        </label>
                    </div>
                </div>

                <div id="tab2" class="tabcontent hidden text-gray-700 dark:text-gray-400">
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Habilitar PixUp?</span>
                    </label>
                    <div class="can-toggle">
                        <input type="checkbox" name="pixup" id="pixup"
                            <?= isset($pixup) && $pixup == 1 ? 'checked' : '' ?>>
                        <label for="pixup">
                            <div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
                        </label>
                    </div>
                    <div class="pixup-fields" style="display: none;">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400"><strong>Client ID:</strong></span>
                            <input name="pixup_client_id" id="pixup_client_id"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="<?= htmlspecialchars($pixup_client_id ?? '') ?>" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
                            <input name="pixup_client_secret" id="pixup_client_secret"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="<?= htmlspecialchars($pixup_client_secret ?? '') ?>" />
                        </label>
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400"><strong>Webhook URL:</strong></span>
                            <input readonly
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 form-input"
                                value="<?= $pixup_webhook_url ?>" />
                        </label>
                    </div>
                </div>

            <input type="hidden" name="gateway" value="1">
            <div class="mt-6">
                <button type="submit"
                    class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let ondapay = $('#ondapay').prop('checked');

        if (ondapay) {
            $('.ondapay').show();
        } else {
            $('.ondapay').hide();
        }

        $('#ondapay').on('change', function() {
            if ($(this).prop('checked')) {
                $('.ondapay').show();
                $(this).val('1');
            } else {
                $('.ondapay').hide();
                $(this).val('2');
            }
        });

        let pixup = $('#pixup').prop('checked');

        if (pixup) {
            $('.pixup-fields').show();
        } else {
            $('.pixup-fields').hide();
        }

        $('#pixup').on('change', function() {
            if ($(this).prop('checked')) {
                $('.pixup-fields').show();
                $(this).val('1');
            } else {
                $('.pixup-fields').hide();
                $(this).val('2');
            }
        });
       
        




        $('#tabs').on('click', function() {
            console.log(pagstar)
        })
        const tabs = document.querySelectorAll('ul#tabs a');
        const tabContents = document.querySelectorAll('.tabcontent');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                tabs.forEach(item => item.classList.remove('active-tab'));
                tabContents.forEach(content => content.classList.add('hidden'));
                this.classList.add('active-tab');
                document.querySelector(this.getAttribute('href')).classList.remove('hidden');
            });
        });
        $('#gateway-form').submit(function(e) {

            e.preventDefault();

            ondapay = $('#ondapay').prop('checked');
            if (ondapay) {
                $('#ondapay').val('1');
            } else {
                $('#ondapay').val('2');
            }

            pixup = $('#pixup').prop('checked');
            if (pixup) {
                $('#pixup').val('1');
            } else {
                $('#pixup').val('2');
            }

            $.ajax({
                url: _base_url_ + 'class/System.php?action=update_system',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    var returnedData = JSON.parse(resp);
                    if (returnedData.status == 'success') {
                        alert('Configurações salvas com sucesso!');
                        location.reload();
                    } else {
                        alert('Ops');
                    }
                }
            })
        })
    });
</script>
