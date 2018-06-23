<?php 
	function get_my_info() {
		global $db;
		$my_id = $_SESSION['user_id'];
		$result = $db->query("SELECT * FROM users WHERE `id`=" . $my_id);
		return $result->fetch_assoc();
	}
	
	function get_comments($id) {
		global $db;
		$result = $db->query("SELECT * FROM commentaries where article='" . $id ."' ORDER BY id DESC;");
		return $result;
	}
	function get_article($id) {
		global $db;
		$result = $db->query("SELECT * FROM articles where id='" . $id ."';");
		return $result->fetch_assoc();
	}
	
	function add_comment($text, $article, $user) {
		global $db;
		$db->query("INSERT INTO commentaries(text, article, user) values('" . $text . "', '" . $article . "', '" . $user . "');");
		return true;
	}
	
	function get_articles() {
		global $db;
		$result = $db->query("SELECT * FROM articles;");
		return $result;
	}
	
	function get_user($id) {
		global $db;
		$result = $db->query("SELECT * FROM users where id='" . $id . "';");
		return $result->fetch_assoc();
	}
	
	function get_images($id) {
		global $db;
		$result = $db->query("SELECT image FROM recipe WHERE recipe.id_dishes=" . $id);
		return $result->fetch_assoc();
	}
	
	function reload_my() {
		global $my, $db;
		
		$my = get_my_info();
		
		if (empty($my['weight']) || empty($my['height']) || empty($my['age']) || empty($my['life_style'])  || empty($my['diet_type'])) {
			if ($_SERVER['REQUEST_URI'] == '/') 
				header("Location: /profile.php");
		} else {
		
		$min = 447.6 + (9.2 * $my['weight']) + (3.1 * $my['height']) - (4.3 * $my['age']);
		$daily = $min * $my['life_style'];
		switch ($my['diet_type']) {
			case 1:
				$result = $daily - 300;
				break;
			case 2: 
				$result = $daily;
				break;
			case 3:
				$result = $daily + 300;
				break;
		}
		$my['calories'] = $result;
		
		$bzu_b = $my['weight'];
		switch ($my['diet_type']) {
			case 1:
				$bzu_b = $bzu_b * 1.5;
				break;
			case 2: 
				$bzu_b = $bzu_b * 1.5;
				break;
			case 3:
				$bzu_b = $bzu_b * 2.5;
				break;
		}
		$my['bzu'] = $bzu_b;
		
		$bzu_z = $my['weight'] * 1;
		$my['bzu_z'] = $bzu_z;
		
		$bzu_y = $my['weight'] * 2;
		$my['bzu_y'] = $bzu_y;
		
		$query = "SELECT * FROM users_choices WHERE user_id=" . $my['id'] . " AND `date`=date(now()) ORDER by feeding_id DESC LIMIT 1";
		$res = $db->query($query);
		$res = $res->fetch_assoc();
		if (empty($res)) {
			$query = "SELECT * FROM feeding";
			$feedings = array();
			$res = $db->query($query);
			while ($row = $res->fetch_assoc()) {
				$feedings[] = $row;
			}
			$search = $feedings[0];
		} else {
			$search = $res['feeding_id'] + 1;
			$query = "SELECT * FROM feeding WHERE id=" . $search;
			$res = $db->query($query);
			$search = $res->fetch_assoc();
		}
			if (!empty($search)) {
				
				$query = "SELECT * FROM meals_to_feeding LEFT JOIN meals ON meals.id = meals_to_feeding.meal_id WHERE feeding=" . $search['id'];
				$res = $db->query($query);
				$rows = array();
				while ($row = $res->fetch_assoc()) {
					$result = $db->query("SELECT * FROM bzhu_dishes LEFT JOIN bzhu_d ON bzhu_d.id = bzhu_dishes.id_bju WHERE id_dishes=" . $row['meal_id']);
					while ($row2 = $result->fetch_assoc()) {
						$row['bzhu'][] = $row2;
					}
					$rows[] = $row;
				}
				
				$my['finished'] = false;
				$my['dishes'] = $rows;
				$my['feeding'] = $search;
			} else {
				$query = "SELECT * FROM feeding";
				$feedings = $db->query($query);
				$rows = array();
				while ($row = $feedings->fetch_assoc()) {
					$query = 'SELECT * FROM users_choices LEFT JOIN meals ON meals.id = users_choices.meal_id WHERE user_id=' . $my['id'] . ' AND feeding_id=' . $row['id'] . ' AND `date`=date(now())';
					$choices = $db->query($query);
					$calories = $my['calories'] *  $row['percentage'] /100;
					$query = 'SELECT Count(*) as count_rows FROM users_choices WHERE user_id=' . $my['id'] . ' AND feeding_id=' . $row['id'] . ' AND `date`=date(now())';
					$count = $db->query($query);
					$count = $count->fetch_assoc();
					$count = $count['count_rows'];
					$per_dish = $calories / $count;
					$dishes = array();
					while ($row2 = $choices->fetch_assoc()) {
						$query = "SELECT (weight/calories)*" . $per_dish . " as res FROM meals WHERE id=" . $row2['meal_id'];
						$row3 = $db->query($query);
						$row3 = $row3->fetch_assoc();
						$row2['gramms'] = $row3['res'];
						$dishes[] = $row2;
					}
					$row['dishes'] = $dishes;
					$row['calories'] = $calories;
					$rows[] = $row;
				}
				$my['dishes'] = $rows;
				$my['finished'] = true;
			}
		}
	}
	reload_my();
	
?>