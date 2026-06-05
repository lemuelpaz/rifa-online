<?php

$theme = $_settings->info('theme');

if ($theme == '2') { ?>
	<style>
		:root {
			--incrivel-bg: #0f121a;
			--incrivel-border: #d1d1d1;
			--incrivel-bgColor: #323232;
			--incrivel-bgLink: #212b36;
			--incrivel-bgLinkHover: var(--incrivel-primaria);
			--incrivel-rgba: 255, 255, 255;
			--incrivel-rgbaInvert: 255, 255, 255;
			--incrivel-formBg: #fff;
			--incrivel-formBgHover: #fff;
			--incrivel-formBgHoverColor: #fff;
			--incrivel-formBorder: #c9c9c9;
			--incrivel-formColor: #fff;
			--incrivel-cardBg: rgb(33, 43, 54);
			--incrivel-cardColor: #000;
			--incrivel-cardLink: #fff;
			--incrivel-modalBg: rgb(33, 43, 54);
			--incrivel-modalBorder: #eee;
			--incrivel-modalColor: #fff;
			--incrivel-primaria: #000000c2;
			--incrivel-primariaColor: #cfcfcf;
			--incrivel-primariaLink: #fff;
			--incrivel-primariaLinkHover: #000;
			--incrivel-primariaDarken: rgb(33, 43, 54);
			--incrivel-primariaDarkenColor: #323232;
			--incrivel-primariaDarkenLink: #fff;
			--incrivel-primariaDarkenLinkHover: #fff
		}
	</style>
<?php }
