<?php
// pages/my-numbers.php

// --------- Config do sistema ----------
$enable_hide_numbers = $_settings->info('enable_hide_numbers');
$enable_cpf          = $_settings->info('enable_cpf');

// Tipo de busca usado pelo AJAX
$search_type = ((int)$enable_cpf === 1) ? 'search_orders_by_cpf' : 'search_orders_by_phone';

// --------- Leitura de filtros vindos da sessão ----------
$phone = $_SESSION['phone'] ?? '';
$cpf   = $_SESSION['cpf']   ?? '';

// Sanitiza para consultas
$phone_digits = '';
$cpf_digits   = '';
if ($phone !== '') $phone_digits = preg_replace('/\D+/', '', (string)$phone);
if ($cpf   !== '') $cpf_digits   = preg_replace('/\D+/', '', (string)$cpf);

// --------- Localiza o cliente (Prepared Statements) ----------
$customerId = null;

if ((int)$enable_cpf !== 1) {
    if ($phone_digits !== '') {
        $stmt = $conn->prepare('SELECT id FROM customer_list WHERE phone = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('s', $phone_digits);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) $customerId = (int)$row['id'];
            $stmt->close();
        }
    }
} else {
    if ($cpf_digits !== '') {
        $stmt = $conn->prepare('SELECT id FROM customer_list WHERE cpf = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('s', $cpf_digits);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) $customerId = (int)$row['id'];
            $stmt->close();
        }
    }
}

// --------- Busca pedidos do cliente ----------
$orders     = null;
$has_orders = false;

if ($customerId) {
    $sql = 'SELECT 
                o.*,
                p.image_path,
                p.qty_numbers,
                p.type_of_draw,
                p.name AS product_name
            FROM `order_list` o
            INNER JOIN `product_list` p ON o.product_id = p.id
            WHERE o.customer_id = ?
            ORDER BY o.date_created DESC';
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $orders = $stmt->get_result();
        $has_orders = ($orders && $orders->num_rows > 0);
        $stmt->close();
    }
}

// Limpa filtros da sessão após usar
unset($_SESSION['phone'], $_SESSION['cpf']);
?>

<div class="container app-main">
  <div class="mb-3">
    <div class="row justify-content-between w-100 align-items-center">
      <div class="col">
        <div class="app-title">
          <h1>🛒 Meus números</h1>
        </div>
      </div>
      <div class="col-auto text-end">
        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-buscar" class="btn btn-warning btn-sm">
          <i class="bi bi-search"></i> Buscar
        </button>
      </div>
    </div>
  </div>

  <!-- Modal Buscar Compras -->
  <!-- Importante: tabindex="-1" e SEM style="display:none" manual -->
  <form id="modal-buscar" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buscar compras</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <?php if ((int)$enable_cpf !== 1): ?>
            <div class="form-group mb-3">
              <label class="form-label">Informe seu telefone</label>
              <input onkeyup="formatarTEL(this);" maxlength="15" name="phone" required class="form-control" value="">
            </div>
          <?php else: ?>
            <div class="form-group mb-3">
              <label class="form-label">Informe seu CPF</label>
              <input name="cpf" class="form-control" id="cpf" value="" maxlength="14" minlength="14"
                     placeholder="000.000.000-00" oninput="formatarCPF(this.value)" required>
            </div>
          <?php endif; ?>
          <div class="text-end">
            <button type="submit" class="btn btn-warning">Buscar compras</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php if (!$has_orders): ?>
    <div class="alert alert-warning">
      <i class="bi bi-exclamation-triangle"></i> Clique em buscar para localizar suas compras
    </div>
  <?php endif; ?>

  <div>
    <?php if ($has_orders): ?>
      <?php while ($orderRow = $orders->fetch_assoc()): ?>
        <?php
          // Status e classes
          $status = (string)$orderRow['status']; // '1' = aguardando, '2' = pago, '3' = cancelado
          $class  = '';
          $border = '';
          $btn    = '';
          if ($status === '1') { $class = 'bg-warning'; $border = 'border-warning'; $btn = 'btn-warning'; }
          if ($status === '2') { $class = 'bg-success'; $border = 'border-success'; $btn = 'btn-success'; }
          if ($status === '3') { $class = 'bg-danger';  $border = 'border-danger';  $btn = 'btn-danger';  }

          $img          = validate_image($orderRow['image_path']);
          $productName  = $orderRow['product_name'];
          $dateCreated  = date('d-m-Y H:i', strtotime($orderRow['date_created']));
          $type_of_draw = (int)$orderRow['type_of_draw'];

          // Números do pedido
          $order_numbers = (string)$orderRow['order_numbers'];
          $nCollection   = array_filter(array_map('trim', explode(',', $order_numbers)), 'strlen');
          $qty_nums      = count($nCollection);

          // quantidade para o helper (fallback)
          $quantityParam = isset($orderRow['quantity'])
                            ? (int)$orderRow['quantity']
                            : (isset($orderRow['qty_numbers']) ? (int)$orderRow['qty_numbers'] : $qty_nums);
        ?>

        <div class="card app-card mb-2 pointer border-bottom border-2 <?php echo $border; ?>">
          <div class="card-body">
            <div class="row align-items-center row-gutter-sm">
              <div class="col-auto">
                <div class="position-relative rounded-pill overflow-hidden box-shadow-08" style="width:56px;height:56px;">
                  <div style="display:block;overflow:hidden;position:absolute;inset:0;box-sizing:border-box;margin:0;">
                    <img src="<?php echo $img; ?>" decoding="async" data-nimg="fill"
                         style="position:absolute;inset:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;">
                    <noscript></noscript>
                  </div>
                </div>
              </div>

              <div class="col ps-2">
                <div class="compra-title font-weight-500"><?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?></div>
                <small class="compra-data font-xss opacity-50 text-uppercase">
                  <i class="bi bi-calendar4-week"></i> <?php echo $dateCreated; ?>
                </small>

                <div class="compra-cotas font-xs mt-2">
                  <?php
                    if ($type_of_draw > 1) {
                      echo drope_format_luck_numbers_dashboard($order_numbers, (int)$orderRow['qty_numbers'], $class, $opt = true, $type_of_draw);
                    } elseif ($type_of_draw === 1 && (int)$enable_hide_numbers === 1 && ($status === '1' || $status === '3')) {
                      echo 'As cotas serão geradas após o pagamento.';
                    } else {
                      $tabId = 'drope-tab-' . (int)$orderRow['id'];
                      echo '<div class="drope-tab">';
                      echo '  <input id="'. $tabId .'" type="checkbox">';
                      echo '  <label for="'. $tabId .'">Ver números</label>';
                      echo '  <div class="drope-content">' .
                              drope_format_luck_numbers_dashboard($order_numbers, $quantityParam, false, $opt = true, $type_of_draw)
                           . '</div>';
                      echo '</div>';
                    }
                  ?>
                </div>
              </div>

              <div class="col-12 pt-2">
                <a href="/compra/<?php echo htmlspecialchars($orderRow['order_token'], ENT_QUOTES, 'UTF-8'); ?>">
                  <span class="btn <?php echo $btn; ?> btn-sm p-1 px-2 w-100 font-xss">
                    <?php
                      if     ($status === '1') echo 'Efetuar pagamento';
                      elseif ($status === '2') echo 'Visualizar compra';
                      else                     echo 'Compra cancelada';
                    ?>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>

      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

<!-- Toast (topo central) -->
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index:1080;">
  <div id="appToast" class="toast custom-toast" role="status" aria-live="polite" aria-atomic="true" data-bs-delay="3500">
    <div class="d-flex align-items-center">
      <div class="toast-icon me-2" aria-hidden="true"></div>
      <div class="toast-body" id="appToastBody">Mensagem</div>
      <button type="button" class="btn-close ms-3 me-1" data-bs-dismiss="toast" aria-label="Fechar"></button>
    </div>
  </div>
</div>

<style>
  /* Toast refinado + acessível */
  .custom-toast {
    background: rgba(20, 22, 28, 0.92);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,.35);
    backdrop-filter: blur(6px);
    min-width: 320px;
    max-width: 92vw;
    padding: .25rem .25rem;
  }
  .custom-toast .toast-body {
    font-weight: 500;
    letter-spacing: .2px;
  }
  .custom-toast.warning {
    background: linear-gradient(135deg, #ffd75b, #ffbb33);
    color: #1f1400;
    border-color: rgba(0,0,0,.05);
  }
  .custom-toast.success {
    background: linear-gradient(135deg, #71e08a, #38c172);
  }
  .custom-toast.danger {
    background: linear-gradient(135deg, #ff7a7a, #f44336);
  }
  .custom-toast.info {
    background: linear-gradient(135deg, #6bc1ff, #3fa9f5);
  }
  .custom-toast .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: .8;
  }
  .custom-toast.warning .btn-close { filter: none; opacity: .6; }
  .custom-toast .toast-icon {
    width: 10px; height: 10px; border-radius: 50%;
    background: #00d1b2;
  }
  .custom-toast.warning .toast-icon { background:#7a4a00; }
  .custom-toast.success .toast-icon { background:#0d5f2f; }
  .custom-toast.danger  .toast-icon { background:#6b1010; }
  .custom-toast.info    .toast-icon { background:#0b4f7a; }
</style>

<script>
  // helpers de máscara (só cria se não existir)
  if (typeof window.formatarTEL !== 'function') {
    window.formatarTEL = function (e) {
      var v = e.value.replace(/\D/g,'');
      v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
      v = v.replace(/(\d)(\d{4})$/, '$1-$2');
      e.value = v;
    }
  }
  if (typeof window.formatarCPF !== 'function') {
    window.formatarCPF = function (val) {
      var v = (val || '').toString().replace(/\D/g,'');
      v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      var el = document.getElementById('cpf'); if (el) el.value = v;
    }
  }

  // Toast elegante
  function showToast(msg, variant) {
    var toastEl   = document.getElementById('appToast');
    var toastBody = document.getElementById('appToastBody');

    toastBody.textContent = msg;

    // reseta e aplica variação visual
    toastEl.className = 'toast custom-toast';
    if (variant) toastEl.classList.add(variant);

    var t = bootstrap.Toast.getOrCreateInstance(toastEl);
    t.show();
  }

  // Abre modal (e toast opcional) se não houver pedidos
  window.addEventListener('load', function () {
    var temPedidos   = <?php echo $has_orders ? 'true' : 'false'; ?>;
    var houveEntrada = <?php echo ($phone_digits !== '' || $cpf_digits !== '') ? 'true' : 'false'; ?>;

    if (!temPedidos) {
      var modalEl = document.getElementById('modal-buscar');
      if (modalEl) {
        // Usa uma única instância e deixa Bootstrap gerenciar foco/ARIA
        var modal = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: true, keyboard: true, focus: true });

        // Evita o warning: se algum elemento dentro do modal ainda estiver focado
        // quando o ARIA for marcado como hidden, removemos o foco.
        modalEl.addEventListener('hide.bs.modal', function () {
          if (modalEl.contains(document.activeElement)) {
            document.activeElement.blur();
            // opcional: devolve foco pro body (ou para algum botão de abrir)
            setTimeout(function(){ document.body.focus(); }, 0);
          }
        });

        modal.show();
      }

      if (houveEntrada) {
        showToast('Você ainda não comprou nenhum número ou não encontramos compras.', 'warning');
      }
    }
  });

  // Submete a busca do modal (sem alert feio)
  (function () {
    var form = document.getElementById('modal-buscar');
    var actionTipo = <?php echo json_encode($search_type); ?>;

    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: _base_url_ + "class/Main.php?action=" + actionTipo,
        method: 'POST',
        type: 'POST',
        data: new FormData(form),
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        error: function (err) {
          console.log(err);
          showToast('Ocorreu um erro ao buscar. Tente novamente.', 'danger');
        },
        success: function (resp) {
          if (resp && resp.status === 'success') {
            location.href = resp.redirect;
          } else {
            showToast('Você ainda não comprou nenhum número ou não encontramos compras.', 'warning');
            console.log(resp);
          }
        }
      });
    });
  })();
</script>
