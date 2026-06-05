<?php
$bg_color      = $_settings->info('bg_color')      ?: '#ffffff';
$primary_color = $_settings->info('primary_color') ?: '#7e3af2';
$text_color    = $_settings->info('text_color')    ?: '#111827';
$card_color    = $_settings->info('card_color')    ?: '#ffffff';
?>

<style>
.design-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
.color-card  { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
.color-card h3 { font-size: .85rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; margin: 0 0 14px; }
.color-row   { display: flex; align-items: center; gap: 14px; }
.color-swatch{ width: 48px; height: 48px; border-radius: 10px; border: 2px solid #e5e7eb; cursor: pointer; flex-shrink: 0; }
.color-hex   { flex: 1; font-size: .95rem; font-weight: 500; color: #374151; border: 1px solid #e5e7eb; border-radius: 8px; padding: 8px 12px; font-family: monospace; }
.preview-box { border-radius: 12px; padding: 24px; margin-top: 24px; }
</style>

<main class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <i class="fa-duotone fa-palette mr-2"></i> Design do Site
    </h2>

    <form id="design-form">
        <div class="design-grid">

            <!-- Cor de Fundo -->
            <div class="color-card dark:bg-gray-800">
                <h3>Cor de Fundo</h3>
                <div class="color-row">
                    <input type="color" class="color-swatch" id="pick_bg_color"
                           value="<?= htmlspecialchars($bg_color) ?>"
                           oninput="syncHex(this,'hex_bg_color','bg_color')">
                    <input type="text" class="color-hex dark:bg-gray-700 dark:text-gray-300" id="hex_bg_color"
                           value="<?= htmlspecialchars($bg_color) ?>"
                           oninput="syncPicker(this,'pick_bg_color','bg_color')" maxlength="7">
                    <input type="hidden" name="bg_color" id="bg_color" value="<?= htmlspecialchars($bg_color) ?>">
                </div>
            </div>

            <!-- Cor Primária -->
            <div class="color-card dark:bg-gray-800">
                <h3>Cor Primária (botões, destaques)</h3>
                <div class="color-row">
                    <input type="color" class="color-swatch" id="pick_primary_color"
                           value="<?= htmlspecialchars($primary_color) ?>"
                           oninput="syncHex(this,'hex_primary_color','primary_color')">
                    <input type="text" class="color-hex dark:bg-gray-700 dark:text-gray-300" id="hex_primary_color"
                           value="<?= htmlspecialchars($primary_color) ?>"
                           oninput="syncPicker(this,'pick_primary_color','primary_color')" maxlength="7">
                    <input type="hidden" name="primary_color" id="primary_color" value="<?= htmlspecialchars($primary_color) ?>">
                </div>
            </div>

            <!-- Cor do Texto -->
            <div class="color-card dark:bg-gray-800">
                <h3>Cor do Texto</h3>
                <div class="color-row">
                    <input type="color" class="color-swatch" id="pick_text_color"
                           value="<?= htmlspecialchars($text_color) ?>"
                           oninput="syncHex(this,'hex_text_color','text_color')">
                    <input type="text" class="color-hex dark:bg-gray-700 dark:text-gray-300" id="hex_text_color"
                           value="<?= htmlspecialchars($text_color) ?>"
                           oninput="syncPicker(this,'pick_text_color','text_color')" maxlength="7">
                    <input type="hidden" name="text_color" id="text_color" value="<?= htmlspecialchars($text_color) ?>">
                </div>
            </div>

            <!-- Cor dos Cards -->
            <div class="color-card dark:bg-gray-800">
                <h3>Cor dos Cards/Seções</h3>
                <div class="color-row">
                    <input type="color" class="color-swatch" id="pick_card_color"
                           value="<?= htmlspecialchars($card_color) ?>"
                           oninput="syncHex(this,'hex_card_color','card_color')">
                    <input type="text" class="color-hex dark:bg-gray-700 dark:text-gray-300" id="hex_card_color"
                           value="<?= htmlspecialchars($card_color) ?>"
                           oninput="syncPicker(this,'pick_card_color','card_color')" maxlength="7">
                    <input type="hidden" name="card_color" id="card_color" value="<?= htmlspecialchars($card_color) ?>">
                </div>
            </div>

        </div>

        <!-- Preview em tempo real -->
        <div class="mt-6 color-card dark:bg-gray-800">
            <h3>Preview</h3>
            <div id="preview-box" class="preview-box" style="background:<?= htmlspecialchars($bg_color) ?>">
                <div style="max-width:320px;margin:0 auto;background:<?= htmlspecialchars($card_color) ?>;border-radius:10px;padding:20px;" id="preview-card">
                    <p style="color:<?= htmlspecialchars($text_color) ?>;font-weight:600;margin:0 0 12px;">Nome da Campanha</p>
                    <div style="height:8px;border-radius:6px;background:#e5e7eb;margin-bottom:14px;">
                        <div style="width:60%;height:100%;border-radius:6px;background:<?= htmlspecialchars($primary_color) ?>;" id="preview-bar"></div>
                    </div>
                    <button style="background:<?= htmlspecialchars($primary_color) ?>;color:#fff;border:none;border-radius:8px;padding:10px 24px;font-weight:600;cursor:pointer;width:100%;" id="preview-btn">
                        Participar
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="px-5 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none">
                Salvar Design
            </button>
            <button type="button" onclick="resetDesign()"
                class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                Restaurar padrão
            </button>
        </div>
    </form>
</main>

<script>
function syncHex(picker, hexId, hiddenId) {
    document.getElementById(hexId).value    = picker.value;
    document.getElementById(hiddenId).value = picker.value;
    updatePreview();
}
function syncPicker(hex, pickerId, hiddenId) {
    const val = hex.value;
    if (/^#[0-9a-fA-F]{6}$/.test(val)) {
        document.getElementById(pickerId).value  = val;
        document.getElementById(hiddenId).value  = val;
        updatePreview();
    }
}
function updatePreview() {
    const bg      = document.getElementById('bg_color').value;
    const primary = document.getElementById('primary_color').value;
    const text    = document.getElementById('text_color').value;
    const card    = document.getElementById('card_color').value;

    document.getElementById('preview-box').style.background  = bg;
    document.getElementById('preview-card').style.background = card;
    document.getElementById('preview-card').querySelector('p').style.color = text;
    document.getElementById('preview-bar').style.background  = primary;
    document.getElementById('preview-btn').style.background  = primary;
}
function resetDesign() {
    const defaults = { bg_color:'#ffffff', primary_color:'#7e3af2', text_color:'#111827', card_color:'#ffffff' };
    Object.entries(defaults).forEach(([k,v]) => {
        document.getElementById('pick_'+k).value = v;
        document.getElementById('hex_'+k).value  = v;
        document.getElementById(k).value         = v;
    });
    updatePreview();
}

$('#design-form').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: _base_url_ + 'class/System.php?action=update_system',
        data: new FormData(this),
        cache: false, contentType: false, processData: false,
        method: 'POST',
        success: function(resp) {
            try { resp = JSON.parse(resp); } catch(e) {}
            if (resp.status === 'success') {
                alert('Design salvo com sucesso!');
                location.reload();
            } else {
                alert('Erro ao salvar.');
            }
        }
    });
});
</script>
