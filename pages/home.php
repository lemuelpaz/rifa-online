<?php
require_once('./settings.php');

if (isset($_GET['utm_source']) || $_SESSION['ads']) {
	$_SESSION['ads'] = $_GET['utm_source'];
	page_view(2, 'home', $id ? $id : null, $user_id ? $user_id : null);
} else {
	page_view(1, 'home', $id ? $id : null, $user_id ? $user_id : null);
}

?>

<div class="container app-main">
	<div class="row">
		<div class="col-12">
			<div class="app-title mb-2 gap-2" style="align-items: flex-start;">
				<h1 style="font-size: 1.125rem;">⚡ Campanhas</h1>
				<div class="app-title-desc">Escolha sua sorte</div>
			</div>
		</div>
	</div>


	<?php
	$qry = $conn->query('SELECT * FROM `product_list` WHERE status_display <> \'4\' AND featured_draw = \'1\' ORDER BY RAND() LIMIT 1');
	while ($row = $qry->fetch_assoc()) { ?>
		<div class="col-12 mb-3" style="height: 500px;">
			<a href="/campanha/<?php echo $row['slug']; ?>" class="h-100 SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer custom-highlight-card">

				<div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
					<div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active" style="width:100%;height:420px">
								<div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
									<img alt="<?php echo $row['name']; ?>" src="<?php echo validate_image($row['image_path']); ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="object-fit:cover;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
									<noscript>
										<img alt="<?php echo $row['name']; ?>" src="<?php echo validate_image($row['image_path']); ?>" decoding="async" data-nimg="fill" style="object-fit:cover;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy" />
									</noscript>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="SorteioTpl_info__t1BZr custom-content-wrapper">
					<h1 class="SorteioTpl_title__3RLtu"><?php echo $row['name']; ?></h1>
					<p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px;"><?php echo (isset($row['subtitle']) ? $row['subtitle'] : ''); ?></p>
				</div>
				<div class="custom-badge-display">
					<?php if ($row['status_display'] == 1) { ?>
						<span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
					<?php } ?>
					<?php if ($row['status_display'] == 2) { ?>
						<span class="badge bg-danger blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
					<?php } ?>
					<?php if ($row['status_display'] == 3) { ?>
						<span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
					<?php } ?>
					<?php if ($row['status_display'] == 4) { ?>
						<span class="badge bg-dark text-white font-xsss">Concluído</span>
						<?php
						$date_of_draw = strtotime($row['date_of_draw']);
						$date_of_draw = date('d/m', $date_of_draw);
						?>
						<div class="SorteioTpl_dtSorteio__2mfSc custom-calendar-display">
							<i class="bi bi-calendar2-check"></i> <?php echo $date_of_draw; ?>
						</div>
					<?php } ?>
					<?php if ($row['status_display'] == 5) { ?>
						<span class="badge bg-dark font-xsss">Em breve!</span>
					<?php } ?>
					<?php if ($row['status_display'] == 6) { ?>
						<span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
					<?php } ?>
				</div>
			</a>


		</div>
	<?php } ?>

	<?php

	$qry = $conn->query('SELECT * FROM `product_list` WHERE featured_draw = \'0\' AND private_draw = \'0\' ORDER BY id DESC LIMIT 10');

	if (0 < $qry->num_rows) {
		while ($row = $qry->fetch_assoc()) {
	?>
			<div class="col-12 mb-3">
				<a href="/campanha/<?php echo $row['slug']; ?>" class="">
					<div class="SorteioTpl_sorteioTpl__2s2Wu pointer css-szgt2f">
						<div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
							<div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
								<img alt="1.500,00 com apenas 0,03 centavos" src="<?php echo validate_image($row['image_path']); ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
								<noscript>
									<img alt="1.500,00 com apenas 0,03 centavos" src="<?php echo validate_image($row['image_path']); ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy" />
								</noscript>
							</div>
						</div>
						<div class="SorteioTpl_info__t1BZr">
							<h1 class="SorteioTpl_title__3RLtu"><?php echo $row['name']; ?></h1>
							<p class="SorteioTpl_descricao__1b7iL css-g6ngok" style="margin-bottom:1px"><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></p>

							<?php if ($row['status_display'] == 1) { ?>
								<span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
							<?php } elseif ($row['status_display'] == 2) { ?>
								<span class="badge bg-danger blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
							<?php } elseif ($row['status_display'] == 3) { ?>
								<span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>
							<?php } elseif ($row['status_display'] == 4) { ?>
								<span class="badge bg-dark text-white font-xsss">Concluído</span>
								<div class="SorteioTpl_dtSorteio__2mfSc">
									<i class="bi bi-calendar2-check"></i> <?php echo date('d/m', strtotime($row['date_of_draw'])); ?>
								</div>
							<?php } elseif ($row['status_display'] == 5) { ?>
								<span class="badge bg-dark font-xsss">Em breve!</span>
							<?php } elseif ($row['status_display'] == 6) { ?>
								<span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>
							<?php } ?>
						</div>
					</div>
				</a>
			</div>
	<?php
		}
	}
	?>
	<div class="col-12">
		<div class="app-helpers mb-0">
			<div class="row">
				<div class="col col-contato-display">
					<div class="d-flex align-items-center w-0 justify-content-center font-xs bg-white bg-opacity-0 box-shadow-0 p-0 rounded-0">

						<?php
						if (CONTACT_TYPE == '1') {
							echo '<a href="/contato">';
						} else {
							echo '<a href="https://api.whatsapp.com/send/?phone=55' . $_settings->info('phone') . '">';
						}
						?>
						<div class="txt">
							<h3 class="mb-0 font-md"></h3>
							<p class="mb-0 font-xs"></p>
						</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php

	$sql = 'SELECT name AS product_name, draw_number, draw_winner, image_path, slug, date_of_draw FROM product_list WHERE draw_number <> \'\' ORDER BY date_of_draw DESC LIMIT 5';
	$products = $conn->query($sql);

	if (0 < $products->num_rows) {
	?>
		<div class="app-ganhadores mb-2">
			<div class="col-12">
				<div class="app-title mb-2 gap-2" style="align-items: flex-start;">
					<h1 style="font-size: 1.125rem;">🎉 Premiados</h1>
					<div class="app-title-desc">do sorteios</div>
				</div>
			</div>

			<div class="col-12">
				<div class="row">
					<?php
					while ($row = $products->fetch_assoc()) {
						$product_name = $row['product_name'];
						$draw_number = $row['draw_number'];
						$draw_name = $row['draw_winner'];
						$draw_number_arr = json_decode(json_encode($draw_number));
						$draw_winner_arr = json_decode(json_encode($draw_name));
						$draw_number = $draw_number_arr[0];
						$draw_name = $draw_winner_arr[0];
						$date_of_draw = strtotime($row['date_of_draw']);
						$date_of_draw = date('d/m/y', $date_of_draw);
						$image_path = validate_image($row['image_path']);

						if (!empty($draw_number_arr)) {
							$draw_number_arr = (isset($draw_number_arr) ? $draw_number_arr : '');

							if ($draw_number_arr) {
								$draw_winner_arr = json_decode($draw_winner_arr, true);
								$draw_number_arr = json_decode($draw_number_arr, true);
								$winners = [];

								foreach ($draw_winner_arr as $qty_index => $name) {
									foreach ($draw_number_arr as $amount_index => $number) {
										$query = $conn->query('SELECT CONCAT(firstname, \' \', lastname) as name, avatar FROM customer_list WHERE phone = \'' . $name . '\'');
										$rowCustomer = $query->fetch_assoc();

										if ($qty_index === $amount_index) {
											$winners[$qty_index] = [
												'name' => $rowCustomer['name'],
												'number' => $number,
												'product' => $product_name,
												'date' => $date_of_draw,
												'image' => ($rowCustomer['avatar'] ? validate_image($rowCustomer['avatar']) : BASE_URL . 'assets/img/avatar.png')
											];
										}
									}
								}
							}

							foreach ($winners as $winner) {
					?>
								<a href="/campanha/<?php echo $row['slug']; ?>">
									<div class="ganhadorItem_ganhadorContainer__1Sbxm mb-2">
										<div class="ganhadorItem_ganhadorFoto__324kH box-shadow-08">
											<div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
												<img alt="<?php echo $winner['product']; ?> ganhador do prêmio <?php echo $winner['product']; ?>" src="<?php echo $winner['image']; ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit: cover;">
												<noscript>
													<img alt="<?php echo $draw_name; ?> ganhador do prêmio <?php echo $winner['product']; ?>" src="<?php echo $winner['image']; ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%;object-fit: cover;" loading="lazy" />
												</noscript>
											</div>
										</div>
										<div class="undefined w-100">
											<h3 class="ganhadorItem_ganhadorNome__2j_J-" style="text-transform: uppercase;"><?php echo $winner['name']; ?></h3>
											<div class="ganhadorItem_ganhadorDescricao__Z4kO2">
												<p class="mb-0" style="text-transform:uppercase;"><b><?php echo $winner['product']; ?></b></p>
												<p class="mb-0">Número da sorte <b><?php echo $winner['number']; ?></b></p>
												<p class="mb-0">Data da premiação <b><?php echo $winner['date']; ?></b></p>
											</div>
										</div>
									</div>
								</a>
					<?php
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	<?php
	}

	// Perguntas frequentes
	?>
	<style>
		.pergunta-item {
			cursor: pointer;
		}
	</style>
	<?php if ($enable_password == 1): ?>
		<div class="mb-2">
			<div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
				<div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-4" aria-expanded="false" aria-controls="pergunta-4">
					<i class="bi bi-arrow-right me-2 incrivel-primariaLink"></i>
					<span>Esqueci minha senha, como faço?</span>
				</div>
				<div class="d-block">
					<div class="pergunta-item--resp mt-1 collapse" id="pergunta-4" data-bs-parent="#perguntas-box">
						<p class="mb-0">Você consegue recuperar sua senha indo no menu do site, depois em "Entrar" e logo a baixo tem "Esqueci minha senha".</p>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
</div>
</div>
<!-- Fim perguntas frequentes -->
<?php
