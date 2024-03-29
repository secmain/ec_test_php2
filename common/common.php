<?php
	
	require_once(dirname(__FILE__) . '/../vendor/autoload.php');

	function get_env($name) {
		$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
		$dotenv->load();
		return getenv($name);
	}

	function h($value) {
		return htmlspecialchars($value, ENT_QUOTES);
	}


	function sanitize($before) {
		$after = [];
		foreach ($before as $key => $value) {
			$after[$key] = h($value);
		}
		return $after;
	}

	function createCsrftoken() {
		$TOKEN_LENGTH = 16;
		$token_byte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
		return bin2hex($token_byte);
	}

	function pull_year() {
		$min = 2017;
		$max = 2019;
		print '<select name="year">';
		for ($i = $min; $i <= $max; $i++) {
			print '<option value="' . $i . '">' . $i . '</option>';
		}
		print '</select>';
	}

	function pull_month() {
		print '<select name="month">';
		for ($i = 1; $i <= 12; $i++) {
			$val = sprintf('%02s', $i);
			print '<option value="' . $i . '">' . $i . '</option>';
		}
		print '</select>';
	}

	function pull_day() {
		$max = 31;
		print '<select name="day">';
		for ($i = 1; $i <= $max; $i++) {
			$val = sprintf('%02s', $i);
			print '<option value="' . $i . '">' . $i . '</option>';
		}
		print '</select>';	
	}

	function make_bread($curent_file) {
		// 後でconfig化
		$project = '/ec_php/';
		$kaiin_dir = $project . 'kaiin/';
		$mypage_dir = $project . 'kaiin/';
		$product_dir = $project . 'product/';
		$order_dir = $project . 'order/';
		$contact_dir = $project . 'contact/';
		$mise_dir = $project . 'mise/';
		
		$path_list = [
			0 => [$project . 'kaiin_top.php' => ['name' => 'トップページ', 'parent' => ''],
				  // ショップ商品一覧
				  $mise_dir . 'mise_list.php' => ['name' => '商品一覧', 'parent' => $project . 'kaiin_top.php'],],
			1 => [$kaiin_dir . 'kaiin_list.php' => ['name' => '会員一覧', 'parent' => $project . 'kaiin_top.php'],
				  $mypage_dir . 'kaiin_edit_mypage.php' => ['name' => 'myページ', 'parent' => $project . 'kaiin_top.php'],
				  $product_dir . 'pro_list.php' => ['name' => '商品一覧', 'parent' => $project . 'kaiin_top.php'],
				  $order_dir . 'order_download.php' => ['name' => '注文書ダウンロード日付選択', 'parent' => $project . 'kaiin_top.php'],
				  // お問い合わせ
				  $contact_dir . 'contact.php' => ['name' => 'お問い合わせ', 'parent' => $project . 'kaiin_top.php'],
				  // カート
				  $mise_dir . 'mise_cartlook.php' => ['name' => 'カート', 'parent' => $mise_dir . 'mise_list.php'],
				  // 購入手続き
				  $mise_dir . 'mise_form.php' => ['name' => '購入手続き', 'parent' => $mise_dir . 'mise_list.php'],
				  // 商品詳細
				  $mise_dir . 'mise_product.php' => ['name' => '商品詳細', 'parent' => $mise_dir . 'mise_list.php'],
				  // myページ編集
				  $mise_dir . 'mise_edit_mypage.php' => ['name' => 'myページ編集', 'parent' => $mise_dir . 'mise_list.php'],
				 ],
			2 => [
				  // 会員追加
				  $kaiin_dir . 'kaiin_add.php' => ['name' => '会員追加', 'parent' => $kaiin_dir . 'kaiin_list.php'],
				  $kaiin_dir . 'kaiin_edit.php' => ['name' => '会員編集', 'parent' => $kaiin_dir . 'kaiin_list.php'],
				  $kaiin_dir . 'kaiin_disp.php' => ['name' => '会員参照', 'parent' => $kaiin_dir . 'kaiin_list.php'],
				  // 会員削除
				  $kaiin_dir . 'kaiin_delete.php' => ['name' => '会員削除', 'parent' => $kaiin_dir . 'kaiin_list.php'],
				  $mypage_dir . 'kaiin_edit_mypage_check.php' => ['name' => 'myページ編集確認', 'parent' => $mypage_dir . 'kaiin_edit_mypage.php'],
				  // パスワード変更
				  $mypage_dir . 'kaiin_password_change.php' => ['name' => 'pw変更', 'parent' => $mypage_dir . 'kaiin_edit_mypage.php'],
				  $product_dir . 'pro_add.php' => ['name' => '商品追加', 'parent' => $product_dir . 'pro_list.php'],
				  $product_dir . 'pro_edit.php' => ['name' => '商品編集', 'parent' => $product_dir . 'pro_list.php'],
				  $product_dir . 'pro_delete.php' => ['name' => '商品削除', 'parent' => $product_dir . 'pro_list.php'],
				  $product_dir . 'pro_disp.php' => ['name' => '商品参照', 'parent' => $product_dir . 'pro_list.php'],
				  $order_dir . 'order_download_done.php' => ['name' => '注文書ダウンロード', 'parent' => $order_dir . 'order_download.php'],
				  // お問い合わせ確認
				  $contact_dir . 'contact_check.php' => ['name' => 'お問い合わせ確認', 'parent' => $contact_dir . 'contact.php'],
				  // 購入手続き確認
				  $mise_dir . 'mise_form_check.php' => ['name' => '購入手続き確認', 'parent' => $mise_dir . 'mise_form.php'],
				  // myページ編集確認
				  $mise_dir . 'mise_edit_mypage_check.php' => ['name' => 'myページ編集確認', 'parent' => $mise_dir . 'mise_edit_mypage.php'],
				],
			3 => [
				  // 会員追加確認
				  $kaiin_dir . 'kaiin_add_check.php' => ['name' => '会員追加確認', 'parent' => $kaiin_dir . 'kaiin_add.php'],	
				  $kaiin_dir . 'kaiin_edit_check.php' => ['name' => '会員編集確認', 'parent' => $kaiin_dir . 'kaiin_edit.php'],
				  $kaiin_dir . 'kaiin_add_check.php' => ['name' => '会員追加確認', 'parent' => $kaiin_dir . 'kaiin_add.php'],
				  // 会員削除確認
				  $kaiin_dir . 'kaiin_delete_done.php' => ['name' => '会員削除完了', 'parent' => $kaiin_dir . 'kaiin_delete.php'],	
				  $mypage_dir . 'kaiin_edit_mypage_done.php' => ['name' => 'myページ編集完了', 'parent' => $mypage_dir . 'kaiin_edit_mypage_check.php'],
				  // パスワード変更確認
				  $mypage_dir . 'kaiin_password_change_check.php' => ['name' => 'pw変更確認', 'parent' => $mypage_dir . 'kaiin_password_change.php'],
				  $product_dir . 'pro_add_check.php' => ['name' => '商品追加確認', 'parent' => $product_dir . 'pro_add.php'],
				  $product_dir . 'pro_edit_check.php' => ['name' => '商品編集確認', 'parent' => $product_dir . 'pro_edit.php'],
				  $product_dir . 'pro_delete_done.php' => ['name' => '商品削除完了', 'parent' => $product_dir . 'pro_delete.php'],
				  // お問い合わせ完了
				  $contact_dir . 'contact_done.php' => ['name' => 'お問い合わせ完了', 'parent' => $contact_dir . 'contact_check.php'],
				  // 購入手続き完了
				  $mise_dir . 'mise_form_done.php' => ['name' => '購入手続き完了', 'parent' => $mise_dir . 'mise_form_check.php'],
				  // myページ編集完了
				  $mise_dir . 'mise_edit_mypage_done.php' => ['name' => 'myページ編集完了', 'parent' => $mise_dir . 'mise_edit_mypage_check.php'],
				],
			4 => [
				  // 会員追加完了
				  $kaiin_dir . 'kaiin_add_done.php' => ['name' => '会員追加完了', 'parent' => $kaiin_dir . 'kaiin_add_check.php'],
				  $kaiin_dir . 'kaiin_edit_done.php' => ['name' => '会員編集完了', 'parent' => $kaiin_dir . 'kaiin_edit_check.php'],
				  $product_dir . 'pro_edit_done.php' => ['name' => '商品編集完了', 'parent' => $product_dir . 'pro_edit_check.php'],
				  $product_dir . 'pro_add_done.php' => ['name' => '商品追加完了', 'parent' => $product_dir . 'pro_add_check.php'],
				  // パスワード変更完了
				  $mypage_dir . 'kaiin_password_change_done.php' => ['name' => 'pw変更完了', 'parent' => $mypage_dir . 'kaiin_password_change_check.php'],
				],
		];

		$breads = [];
		// $curent_file = $_SERVER['SCRIPT_PATH'];
		$point = 0;

		foreach ($path_list as $i => $list) {
			if (isset($list[$curent_file])) {
				$point = $i;
				break;
			}
		}

		$file = $curent_file;
		for ($i = $point; $i >= 0; $i--) {
			if (isset($path_list[$i][$file])) {
				$tmp_path = getDomainName() . $file;
				$tmp_name = $path_list[$i][$file]['name'];
				$breads[$i] = [$tmp_path, $tmp_name];
				$file = $path_list[$i][$file]['parent'];
			} else {
				break;
			}
		}

		return array_reverse($breads);
	}

	function getDomainName() {
		return (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"];
	}

	function getKanrikubun() {
		return [
			'0' => '0', // 一般
			'1' => '1'	// 管理者
		];
	}

	function getUpFileDir($kino) {
		switch ($kino) {
			case 'kaiin':
			case 'product':
			case 'mypage':
			case 'mise':
			case 'mise_mypage':
				return '../up_img/';			
			default:
				# code...
				break;
		}
	}

	function checkGamenDispField($msg, $classes = null) {
		$class = '';
		if ($classes && count($classes)) {
			$class = implode(' ', $classes);
		}
		return '<div class="field ' . $class . '">' . $msg . '</div>';
	}

	function checkGamenDispFieldError($msg, $classes = null) {
		$class = '';
		if ($classes && count($classes)) {
			$class = implode(' ', $classes);
		}
		return '<div class="field error ' . $class . '">' . $msg . '</div>';
	}

	function getUpFileTmpName($file_name) {
		return sprintf("%s_%s", time(), basename($file_name));
	}

	function clearCart() {
		if (isset($_COOKIE[session_name()]) == true) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		@session_destroy();
	}

	function passwordCheck($pass1, $pass2) {
		$ret = 'ok';
		if ($pass1 == '') {
			$ret = checkGamenDispFieldError('パスワードが入力されていません');
		} else if ($pass1 != $pass2) {
			$ret = checkGamenDispFieldError('パスワードが一致しません');
		}

		return $ret;
	}

	function isMemberLogin() {
		return isset($_SESSION['member']) && $_SESSION['member']['member_login'] == 1;
	}

?>