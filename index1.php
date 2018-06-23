<?php
 include_once('db.php'); 
 session_start(); 
 if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
	 $action = $_REQUEST['action'];
	 switch ($action) {
		 case "logout":
			unset($_SESSION['user_id']);
		 break;
	 }
 }
 
 
 if (!isset($_SESSION['user_id'])) {
	 header("Location: auth.php");
 } else {
	 include_once("my.php");	 
 }
 
 if (isset($_REQUEST['submit'])) {
	 $feeding = $_REQUEST['feeding'];
	 $meals = $_REQUEST['meals'];
	 foreach ($meals as $meal) {
		$db->query("INSERT INTO users_choices (user_id, meal_id, feeding_id, date) VALUES (" . $my['id'] . ", " . $meal . ", " . $feeding . ", NOW());");
	 }			 
	 reload_my();
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ваш помощник</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="/jquery/jquery-ui.min.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<script src="/jquery-3.1.1.min.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
</head>
<body> 
<script type="text/javascript">
	function showDialog(id) {
		$.ajax({
			type: "POST",
			url: "/info.php",
			data: "id=" + id,
		}).done(function(data) {
			if (data == "no") {
				alert("Рецепта для этого блюда нет");
				return;
			}
			$('.modal').html(data);
			$( ".modal" ).dialog({
			modal: true,
			width: "90%",
			maxWidth: "768px"
		});
		});	
		
		return;
	}
</script>
<nav role='navigation'>
	<ul>
		<li><a href="/">На главную</a></li>
		<li><a href="/products.php">Продукты</a></li>
		<?php
		if ($my['admin'] == 1) {
			?>
			<li><a href = "/admin/">Администрирование</a></li>
			<?php
		}
		?>
		<li><a href="/profile.php">Мой профиль</a></li>
		<li><a href = "/index.php?action=logout">Выйти</a></li>
	</ul>
</nav>
<div class="modal" style="display: none">
</div>

<br>

	<div id="block1" style="width: 260px">
		<?php
		echo '<br><span style="color: #FFE0E6; margin-left:15px;">Ваша норма: ' . $my['calories'] . ' ккал</span><br>';		
		
		if (!$my['finished']) {
		
		echo '<br><span style="color: #FFE0E6; margin-left:15px;">Выбор блюд на: ' . $my['feeding']['ingestion'] . '</span><br>';		
		
		?>
		<form method="post" action="/">
		<?php 
			foreach ($my['dishes'] as $key=>$dish) {
				$temp = '';
				if (!empty($dish['bzhu'])) {
					foreach ($dish['bzhu'] as $bzhu) {
						$temp .= $bzhu['name'] . "=" . $bzhu['information'] . " | ";
					}
				}
				echo '<label style="background: none; width: 240px; line-height: normal;"><input type="checkbox" name="meals[' . $key . ']" id="meals[' . $key . ']" value="' . $dish['meal_id'] . '">' . $dish['name'] . '(' . $dish['calories'] . ' ккал) ' . $temp . '</label><br><br><br>';
			}
			echo '<input type="hidden" name="feeding" value="' . $my['feeding']['id'] . '">';
		?>
		<input type="submit" id="submit" name="submit" style="margin-left: 210px" value="➜"/>
		</form>
		<?php } else {
			echo '<br><span style="color: #FFE0E6; margin-left:15px;">Вы уже распланировали Ваше питание на сегодня</span><br> <br>';	
			foreach ($my['dishes'] as $dish) {
				echo '<span style="color: white; margin-left: 15px">' . $dish['ingestion'] . '(нужно '. $dish['calories'] .' ккал): </span><br>';
				foreach ($dish['dishes'] as $dish2) {
					echo "<a style=\"text-decoration: none!important;color: rgba(181, 126, 181, 0.86);; margin-left: 15px\" href=\"\" onClick=\"showDialog(" . $dish2["id"] . "); return false;\"> - " . $dish2['name'] . " (" . round($dish2['gramms']) . " грамм)</a></br>";
				}
			}
		} ?>
		<br><br><br>
		<?php
			echo !empty($error)?$error:"";
		?>
	</div>
</body>
</html>
	


