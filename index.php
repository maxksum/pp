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
<link href="menu/normalize.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|Paytone+One|Gochi+Hand' rel='stylesheet' type='text/css'>
  <link href="menu/style.css" rel="stylesheet" type="text/css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<link rel="stylesheet" href="/jquery/jquery-ui.min.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<script src="scrollup.js" type="text/javascript"></script>
	<!-- <link rel="stylesheet" type="text/css" href="menu/demo2.css" /> -->	
	<link rel="stylesheet" type="text/css" href="css1/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css1/buttons.css" />
	
	<script src="/jquery-3.1.1.min.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
</head>
<body class="flex-center-wrapper1 flex-column"> 
<div id="scrollup">
	<img src="up.png" class="up" alt="Прокрутить вверх" />
</div>
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
<div id="nav-icon2">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>

  <h2 class="headline" style="
    margin-bottom: 11px;:">
                  <?php 
		if (!empty($my['calories'])) {
			echo '<span style="color: #74777b; margin-left:15px;">Ваша норма: ' . $my['calories'] . ' ккал</span>';		
		}
		?>  &nbsp/&nbsp  <?php 
		if (!empty($my['bzu'])) {
			echo '<span>Белки: ' . $my['bzu'] . ' гр.</span>';		
		}
		?> &nbsp/&nbsp  <?php 
		if (!empty($my['bzu'])) {
			echo '<span>Жиры: ' . $my['bzu_z'] . ' гр.</span>';		
		}
		?> &nbsp/&nbsp  <?php 
		if (!empty($my['bzu'])) {
			echo '<span>Углеводы: ' . $my['bzu_y'] . ' гр.</span>';		
		}
		?>
                </h2>


<br><br><br><br><br><br>

<div class="modal" style="display: none">
</div>

<br>

		<?php		
		
		if (!$my['finished']) {
		
		echo '<br><span style="color: #74777b; margin-left:15px; font-size: 25px;"> ' . $my['feeding']['ingestion'] . '</span><br>';		
		
		?>
		<div class="grid";>
		<form method="post" action="/">
		<button type="submit" id="submit" name="submit" class="button button--ujarak button--border-medium button--round-s button--text-thick" style="
    margin-left: 170px; width: 168px;">Выбрать</button>
	    <?php 
          foreach ($my['dishes'] as $key=>$dish) { 
		  $result = get_images($dish['id']);
          $temp = '';
          if (!empty($dish['bzhu'])) { 
          foreach ($dish['bzhu'] as $bzhu) { 
          $temp .= $bzhu['name'] . "=" . $bzhu['information'] . " | "; 
} 
} 
         echo '<label style="background: none; width: 240px; line-height: normal;">
			<img src = "' . $result["image"] . '" style="width: 480px; height: 330px;"><br>
           <input type="checkbox" name="meals[' . $key . ']" id="meals[' . $key . ']" value="' . $dish['meal_id'] . '">' . $dish['name'] . '(' . $dish['calories'] . ' ккал) ' . $temp . '</label><br><br><br>'; 
} 
         echo '<input type="hidden" name="feeding" value="' . $my['feeding']['id'] . '">'; 
         ?>
		
		
		</form>
		</div>
		<?php } else {
			echo '<br><span style="color: #74777b; margin-left:15px; font-size:30px;">Ваше питание на сегодня</span><br> <br>
			<table style="margin-left: 200px;">
			<tr>
			<td style="color: #74777b; margin-left:15px; font-size:30px;">
			Кликните на блюдо
			</td>
			<td>
			<img src="share.png" alt="Фотография 1" style="margin-left: 50px;">
			</td>
			</tr>
			</table>';	
			foreach ($my['dishes'] as $dish) {
				echo '<span style="color: white; margin-left: 15px; font-size:20px;">' . $dish['ingestion'] . '(нужно '. $dish['calories'] .' ккал): </span>  <br>';
				foreach ($dish['dishes'] as $dish2) {
					echo "<a style=\"text-decoration: none!important;color: rgba(181, 126, 181, 0.86);; margin-left: 15px; font-size:20px;\" href=\"\" onClick=\"showDialog(" . $dish2["id"] . "); return false;\"> - " . $dish2['name'] . " (" . round($dish2['gramms']) . " грамм)</a></br>";
				}
			}
		} ?>
		<br><br><br>
		<?php
			echo !empty($error)?$error:"";
		?>
		
		  <div class="sliding-menu flex-center-wrapper flex-column left-menu">
  <ul>
    <li>
      <a href="/" >ГЛАВНАЯ</a>
    </li>
    <li style="list-style: none; display: inline">
      <hr>
    </li>
    <li>
	      <a href="/profile.php">ПРОФИЛЬ</a>
      
    </li>
	    <li style="list-style: none; display: inline">
      <hr>
    </li>
	<li>
      <a href="/information.php">ПОЛЕЗНО</a>
    </li>
	
	    <li style="list-style: none; display: inline">
      <hr>
    </li>
	<?php
		if ($my['admin'] == 1) {
			?>
    <li>
      <a href="/admin/">АДМИН</a>
    </li>
	<li style="list-style: none; display: inline">
      <hr>
    </li>
	<?php
		}
		?>

	<li>
<a href="/index.php?action=logout">ВЫЙТИ</a>
    </li>
	    
  </ul><span class="sliiider-exit exit left-exit">&#215</span>
</div>
	
	<script src="menu/sliiide.js" type="text/javascript"></script>
<script type="text/javascript">
var $navIcon = $('#nav-icon2')
var menu = $('.left-menu').sliiide({place: 'left', exit_selector: '.left-exit', toggle: '#nav-icon2', no_scroll: true});
var notes = $('.note');
var toggles = $('.slider-toggle')
var clickHandler = function() {
  var $button = $(this);
  if ($button.hasClass('selected')) {return;}
  $navIcon.removeClass('flip animated');
  notes.fadeOut(700);
  var place = $button.attr('data-link').split('-')[0];
  var menuPlace = $button.attr('data-link');
  var note;
  menu.reset();
  $('.sliding-menu').not('.'+menuPlace).addClass('display-off');
  $button.addClass('selected');
  $('.slider-toggle').not($button).removeClass('selected');
  menu = $('.'+menuPlace).sliiide({place: place, exit_selector: '.'+place+'-exit', toggle: '#nav-icon2'});
  $navIcon.addClass('flip');
  $('.note[data-link="'+menuPlace+'"]').fadeIn(700).css('display','').removeClass('display-off');
  $('.'+menuPlace).removeClass('display-off');
}
toggles.on('click', clickHandler)
</script>
</body>
</html>
	


