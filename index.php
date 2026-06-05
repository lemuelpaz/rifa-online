<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

session_start();


require_once 'settings.php';
require_once 'pages/inc/header.php';
require_once 'pages/inc/set-custom-style.php';

if ($_settings->chk_flashdata('success')) { ?>
	<script>
		$(function(){
			alert_toast("<?= $_settings->flashdata('success')?>",'success')
		})
	</script>
<?php }

echo "\r\n";
$page = (isset($_GET['p']) ? $_GET['p'] : 'pages/home');
if (!file_exists($page . '.php') && !is_dir($page)) {
	include '404.php';
}
else if (is_dir($page)) {
	include $page . '/index.php';
}
else {
	include $page . '.php';
}

echo "\r\n";
require_once 'pages/inc/footer.php';

?>