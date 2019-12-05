<?php

require_once('../common/common.php');
require_once('../config.conf');

class Product_db {
	
	private $db;

	function __construct() {
		$this->db = new PDO(DB_DSN, DB_USER, DB_PASSWD);	
		$this->db->query('set names utf8');
		// エラー出力画面のため
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}

	function get_categorys() {
		$sql = 'select id, text from pro_category';
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$ret = [];
		while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ret[] = $rec;
		}
		return $ret;
	}

	function get_category($id) {
		$sql = 'select id, text from pro_category where id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	function get_products($category = null) {
		// SQLインジェクション脆弱性のため
		$sql = 'select mp.*, mt.name kaiin_name from mst_product mp left join mst_tbl mt on mp.kaiin_code = mt.code';
		if ($category && intval($category)) {
			$sql .= ' where category = ' . $category;
		}
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$ret = [];
		while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ret[] = $rec;
		}
		return $ret;
	}

	function get_product($id) {
		$sql = 'select mp.*, mt.name kaiin_name from mst_product mp left join mst_tbl mt on mp.kaiin_code = mt.code where mp.code = ?';
		$data = [$id];
		$stmt = $this->db->prepare($sql);
		$stmt->execute($data);

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	function up_product($id, $params) {
		
		$columns = [
			'name',
			'price',
			'file_name',
			'file_path',
			'category',
		];
		$data = $this->sort_params($columns, $params);
		$data[] = $id;
		$sql = 'update mst_product set name=?, price=?, file_name=?, file_path=?, category=? where code=?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($data);		
	}

	private function sort_params($columns, $params) {
		$data = [];
		foreach ($columns as $col) {
			if (isset($params[$col])) {
				$data[] = $params[$col];
			} else {
				$data[] = null;
			}
		}
		return $data;
	}

	function add_product($params) {
		
		$columns = [
			'name',
			'price',
			'file_name',
			'file_path',
			'category',
			'kaiin_code'
		];
		$data = $this->sort_params($columns, $params);
		$sql = 'insert into mst_product(name, price, file_name, file_path, category, kaiin_code) values(?, ?, ?, ?, ?, ?)';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($data);
	}


	function delete_product($id) {
		$sql = 'delete from mst_product where code=?';
		$data = [$id];
		$stmt = $this->db->prepare($sql);
		
		return $stmt->execute($data);
	}

	function __destruct() {
		$this->db = null;
	}
}