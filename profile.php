<?php 
 include_once('db.php'); 
 session_start(); 
 
 if (!isset($_SESSION['user_id'])) {
	 header("Location: auth.php");
 } else {
	 include_once("my.php");
 }
 
 if (isset($_REQUEST['submit'])) {
	$query = "UPDATE users SET ";
	$slices = array();
	if (isset($_REQUEST['height']) && !empty($_REQUEST['height'])) {
		$slices[] = "height=".$_REQUEST['height'];
	}
	if (isset($_REQUEST['weight']) && !empty($_REQUEST['weight'])) {
		$slices[] = "weight=".$_REQUEST['weight'];
	}
	if (isset($_REQUEST['age']) && !empty($_REQUEST['age'])) {
		$slices[] = "age=".$_REQUEST['age'];
	}
	if (isset($_REQUEST['life_style']) && !empty($_REQUEST['life_style'])) {
		$slices[] = "life_style=".$_REQUEST['life_style'];
	}
	if (isset($_REQUEST['diet_type']) && !empty($_REQUEST['diet_type'])) {
		$slices[] = "diet_type=".$_REQUEST['diet_type'];
	}
	$query .= implode(",", $slices) . " WHERE id=" . $my['id'];
	$db->query($query);
	reload_my();
	$message = '<span style="color: lightgreen; margin-left: 15px">Изменения сохранены</span>';
	
	if (empty($my['weight']) || empty($my['height']) || empty($my['age']) || empty($my['life_style'])  || empty($my['diet_type'])) {
		$error = '<span style="color: red; margin-left: 15px">Заполните свои данные</span>';
	}   
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ваш помощник</title>	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link href="menu/normalize.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="menu/normalize1.css" />
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="menu/demo1.css" />
		<link rel="stylesheet" type="text/css" href="menu/set1.css" />
  <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|Paytone+One|Gochi+Hand' rel='stylesheet' type='text/css'>
  <link href="menu/style.css" rel="stylesheet" type="text/css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

	
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
<div id="headline-wrapper">
<img src="menu/img/33.png" alt="альтернативный текст" style='width: 30%;'> 
  <h1 class="headline" >
  <?php echo $my['name'] . "  " . $my['surename']; ?>
                 
                </h1>

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
<form id="form" name="form" action="" method="post">
		<div class="container">
			<section class="content bgcolor-4">
							<span class="input input--akira">
			
					<input class="input__field input__field--akira" type="number" id="height" name="height" value="<?php echo $my['height']?>" required/>
					<label class="input__label input__label--akira" for="input-22">
						<span class="input__label-content input__label-content--akira">Рост</span>
					</label>
				</span>
				<span class="input input--akira">
		
					<input class="input__field input__field--akira" type="number" id="weight" name="weight" value="<?php echo $my['weight']?>" required/>
					<label class="input__label input__label--akira" for="input-23">
						<span class="input__label-content input__label-content--akira">Вес</span>
					</label>
				</span>
								<span class="input input--akira">
		
					<input class="input__field input__field--akira" type="number" id="age" name="age"value="<?php echo $my['age']?>" required/>
					<label class="input__label input__label--akira" for="input-24">
						<span class="input__label-content input__label-content--akira">Возраст</span>
					</label>
				</span> 
				
				<span class="input input--akira">
		
					<input class="input__field input__field--akira" type="submit" id="submit" name="submit" value="➜" required/>
					<?php
			echo !empty($error)?$error . "<br><br>":"";
		?>
					<label class="input__label input__label--akira" for="input-24">
						<span class="input__label-content input__label-content--akira">Подтвердить</span>
					</label>
				</span> 
				<span class="input input--akira">
		<select name="diet_type" class="input__field input__field--akira" id="input-24" />
					<option value="1" <?php echo $my['diet_type'] == 1 ? "selected":""; ?>>Похудение</option>
			        <option value="2" <?php echo $my['diet_type'] == 2 ? "selected":""; ?>>Поддержание</option>
			        <option value="3"<?php echo $my['diet_type'] == 3 ? "selected":""; ?>>Набор мышечной массы</option>
		</select>
					<label class="input__label input__label--akira" for="input-24" style="color:rgba(204, 96, 85, 0)";>
						<span class="input__label-content input__label-content--akira">Maiden Name</span>
					</label>
				</span>
				
				<span class="input input--akira">
		<select name="life_style" class="input__field input__field--akira" id="input-24" />
					<option value="1.2" <?php echo $my['life_style'] == 1.2 ? "selected":""; ?>>Сидячий</option>
			        <option value="1.375" <?php echo $my['life_style'] == 1.375 ? "selected":""; ?>>Физ-ра 3-4 р/н</option>
			        <option value="1.55" <?php echo $my['life_style'] == 1.55 ? "selected":""; ?>>Физ-ра 4-6 р/н</option>
			        <option value="1.725"<?php echo $my['life_style'] == 1.715 ? "selected":""; ?>>Активные занятия 6-7 р/н</option>
		</select>
					<label class="input__label input__label--akira" for="input-24" style="color:rgba(204, 96, 85, 0)";>
						<span class="input__label-content input__label-content--akira">Maiden Name</span>
					</label>
				</span>


			</section>
			
			
	</div>	
	</form>
			<script src="js/classie.js"></script>
		<script>
			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}

					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
			})();
		</script>


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
	


