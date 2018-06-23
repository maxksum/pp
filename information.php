<?php 
 include_once('db.php'); 
 session_start(); 
 include_once('my.php');
 if (!isset($_SESSION['user_id'])) {
	 header("Location: auth.php");
 } else {
	 include_once("my.php");
 }
 $articles = get_articles();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ваш помощник</title>	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link href="inform/normalize.css" rel="stylesheet" type="text/css">
	<link href="inform/style.css" rel="stylesheet" type="text/css" media="screen">
	<link rel="stylesheet" type="text/css" href="inform/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="inform/css/demo.css" />
	<link rel="stylesheet" type="text/css" href="inform/css/set1.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>	
</head>
<body class="flex-center-wrapper flex-column">


<div class="container">
			<div class="codrops-top clearfix">
			</div>
			<header class="codrops-header">
				<h1> <span>Узнай для себя много нового</span></h1>
				<nav class="codrops-demos">
				</nav>
			</header>
			<div class="content">
				<div class="grid">
					<?php foreach($articles as $article) { ?>
					<figure class="effect-sadie">
						<img src="<?php echo $article['img']; ?>" width="480" height="330" alt="img02"/>
						<figcaption>
							<h2><?php echo $article['title']; ?></h2>
							<p><?php echo $article['about']; ?></p>
							<a href="inf/article.php?id=<?php echo $article['id']; ?>">Подробнее</a>
						</figcaption>			
					</figure>
					<?php } ?>
					
				</div>
				
			</div>
			
		</div>
		<div id="nav-icon2">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>

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

<br><br><br><br><br><br>
		<script>
			// Только для демострации (данный код нужен для показа эффектов на мобильных устройствах)
			[].slice.call( document.querySelectorAll('a[href="#"') ).forEach( function(el) {
				el.addEventListener( 'click', function(ev) { ev.preventDefault(); } );
			} );
		</script>

<script src="inform/sliiide.js" type="text/javascript"></script>
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
	


