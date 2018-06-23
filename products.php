<?php
include_once('db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
} else {
    include_once("my.php");
}

$products = $db->query("SELECT p.name, p.calories, g.gi, kg.name as gi_name FROM product as p LEFT JOIN `gi` as g ON g.id=p.gi LEFT JOIN kind_gi as kg ON kg.id = g.id_kind");

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
    <script src="/jquery-3.1.1.min.js"></script>
    <script src="/jquery/jquery-ui.min.js"></script>
</head>

<body class="flex-center-wrapper flex-column">
<div id="nav-icon2">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>

  <h1>
    Sliiide
    <!-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> -->
  </h1>

  <h2>
    The Easiest Way to Create a Sliding Nav Menu
  </h2>
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
      <a href="/products.php">ПРОДУКТЫ</a>
    </li>
	
	    <li style="list-style: none; display: inline">
      <hr>
    </li>
	<li>
<a href="/index.php?action=logout">ВЫЙТИ</a>
    </li>
	    
  </ul><span class="sliiider-exit exit left-exit">&#215</span>
</div>

<br><br><br><br><br><br>
<span style="color: black">Привет, <a href="/profile.php"><?php echo $my['name']; ?></a></span><br>


<br>

<div id="block1" style="width: 40%">
    <table border="1" style="border-color: white; width: 100%">
        <tr><td>Продукт</td><td>Калории</td><td>ГИ</td><td>Показатель ГИ</td></tr>
    <?php
        while ($product = $products->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $product['name'] . "</td>" . "<td>" . $product['calories'] . "</td>" . "<td>" . $product['gi_name'] . "</td>" . "<td>" . $product['gi'] . "</td>";
            echo "</tr>";
        }
    ?>
    </table>
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
