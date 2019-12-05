<?php
	session_start();
	session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>カート</title>
	<?php require_once('../common/html/mise_style.php'); ?>
	<link rel="stylesheet" href="../css/mise_cart.css">
</head>
<body>

<?php
	require_once('../common/html/mise_header.php');
	require_once('../common/html/mise_navi.php');
	require_once('../common/common.php');
	require_once('../class/Mise_db.php');
	
	$mise_db = new Mise_db();	
	
	$pro_img_dir = getUpFileDir('mise');

	$cart = [];
	if (isset($_SESSION['cart']) == true) {
		$cart = $_SESSION['cart'];
		$max = count($cart);	
	} else {
		$max = 0;
	}
	

	foreach ($cart as $code => $cnt) {
		$rec = $mise_db->get_shohin($code);
		
		$pro_name[] = $rec['name'];
		$pro_price[] = $rec['price'];
		$pro_file_name[] = $rec['file_name'];
		$pro_file_path[] = $rec['file_path'];
		$count[] = $cnt;
	}
	// var_dump($cart);
?>

	<div class="main">
		<div class="main-container">
			<h3 class="main-title">カートの中身</h3>
			
			<form action="count_change.php" method="post">
				<table class="form-table">
					<tr>
						<th>商品</th>
						<th>画像</th>
						<th>価格</th>
						<th>数量</th>
						<th>小計</th>
						<th>削除</th>
					</tr>

					<?php if ($max === 0) { ?>
					<tr>
						<td colspan="6" class="noshohin-msg">商品が入っていません。</td>
					</tr>
					<?php } ?>

					<?php for ($i = 0; $i < $max; $i++) { ?>	
						<tr>
							<td><?php print $pro_name[$i] ?></td>
							<td>
								<img src="<?php print $pro_img_dir . basename($pro_file_path[$i]); ?>" class="pro-img-file" onerror="this.src='../up_img/no-image.jpg'">
							</td>
							<td><?php print $pro_price[$i] . '円'; ?></td>
							<td><?php print '合計' . $pro_price[$i] * $count[$i] . '円'; ?></td>
							<td><input type="text" name="count_<?php print $i; ?>" value="<?php print $count[$i]; ?>"></td>
							<td><input type="checkbox" name="sakujo_<?php print $i; ?>"></td>
						</tr><br>
					<?php } ?>
				</table>
				<input type="hidden" name="max" value="<?php print $max; ?>">
				<input type="submit" value="数量変更" class="btn">
				<input type="button" onclick="location.href='mise_list.php'" value="商品一覧へ戻る" class="btn">
			<!--
				<input type="button" onclick="location.href='./clear_cart.php'" value="カートを空にする" class="btn">
				<input type="button" onclick="location.href='./mise_form.html'" value="ご購入手続きへ進む" class="btn">
			-->
			</form>
			<?php if (isset($_SESSION['member_login']) == true) { ?>
				<a href="mise_easy_check.php">会員簡単注文へ進む</a>
			<?php } ?>
		</div>
		<?php require_once('../common/html/mise_side.php'); ?>
	</div>
	<?php require_once('../common/html/footer.php'); ?>
</body>
</html>