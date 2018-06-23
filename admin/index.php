<?php
include_once('../db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: /auth.php");
} else {
	include_once("../my.php");
}

if ($my['admin'] == 0) {
	header("Location: /");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ваш помощник</title>
	<link href="../menu/normalize.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|Paytone+One|Gochi+Hand' rel='stylesheet' type='text/css'>
  <link href="../menu/style.css" rel="stylesheet" type="text/css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
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

<?php
///error_reporting(0);
include_once("config.php");
include_once("DBClass.php");




$db = new DBClass(db_address, db_name, db_user, db_password);


if ($db->checkConnection()) {
	echo '<br><br><br><br><br><br>';
	
	
    echo '<form method="post" action="/admin/">';
    $tables = $db->getTables();
    echo 'Показать &nbsp;&nbsp;<select name="table">';
    foreach ($tables as $table) {
        echo '<option value="' . $table . '">' . $table . "</option>";
    }
    echo '</select>';
	echo '&nbsp&nbsp;<input type="submit" value="OK">';
    echo '<input type="hidden" name="action" value="show">';
    echo '</form><br />';
	echo "<br>";

    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        switch ($action) {
            case "show":
				$table = $_REQUEST['table'];
				if (!isset($_REQUEST['order_table'])) {
					$rows = $db->getTableData($table);
				} else {
					$rows = $db->getTableData($table, null, array("column" => $_REQUEST['order_table'], "type" => $_REQUEST['order']));
				}
				$columns = $db->getTableColumns($table);
			?>	
				<div id="block3" style="width: 40%">
            <table border="1" style="border-color: white; width: 100%">
		<?php	
		echo "<span>Таблица " . $table . "</span><br> <br>"; 
			
			
	
				echo "<tr>";
				foreach ($columns as $column) {
					echo "<td>" . $column . "</td>";
				}
				echo "<td></td>";
				echo "<td></td>";
				echo "</tr>";
				foreach($rows as $key=>$row) {
					echo "<tr>";					
					foreach ($row as $column) {
						echo "<td>" . $column . "</td>";
					}
					echo '<td><a href="/admin/index.php?action=delete&id='. $row[$columns[0]] . '&table=' . $table . '">Удалить</a>';
					echo '<td><a href="/admin/index.php?action=edit&id='. $row[$columns[0]] . '&table=' . $table . '">Редактировать</a>';
					echo "</tr>";
				}
				echo "</table><br><br>";
				echo '<form method="post" action="/admin/">';
				echo '<select name="order_table">';
				foreach ($columns as $column) {
					echo '<option value="' . $column . '">' . $column . '</option>';
				}
				echo "</select>&nbsp;&nbsp;";
				echo '<select name="order">';
				echo '<option value="ASC">ASC</option>';
				echo '<option value="DESC">DESC</option>';
				echo '</select>';
				echo '<input type="hidden" name="table" value="' . $table . '">' ;
				echo '<input type="hidden" name="action" value="show">&nbsp;&nbsp;	' ;
				echo '<input type="submit" value="OK">' ;
		
				echo '</form>';
				echo "<br>";
                
			
				echo '<form method="post" action="/admin/">';
				$count = 0;
																				?>
							<div id="block3" style="width: 40%">
							<?php
				foreach ($columns as $key=>$column) {
					if ($count > 0) { 
						echo '<label for="values[' . $count . ']">' . $column . '&nbsp;&nbsp;</label>';
						echo '<input type="text" id="values[' . $count . ']" name="values[' . $count . ']">'; 
						echo '<input type="hidden" name="columns[' . $count . ']" value="' . $column . '"><br><br>';
					}

					$count++;
				}
																?>
							<div id="block3" style="width: 40%">
							<?php
				echo '<input type="hidden" name="action" value="add">' ;
				echo '<input type="hidden" name="table" value="' . $table . '">' ;
				echo '<input type="submit" value="Добавить">' ;
				echo '</form>';
				break;
			case "edit":
																?>
							<div id="block3" style="width: 40%">
							<?php
				$table = $_REQUEST['table'];
				$id = $_REQUEST['id'];
				$columns = $db->getTableColumns($table);
				$row = $db->getTableData($table, array($columns[0] => $id), null, 1);
				echo '<form method="post" action="/admin/">';
				$count = 0;
				$row = $row[0];

				foreach ($columns as $key=>$column) {
					if ($count > 0) { 
						echo '<label for="values[' . $count . ']">' . $column . '&nbsp;&nbsp;</label>';
						echo "<br>";
						echo '<input type="text" id="values[' . $count . ']" name="values[' . $count . ']" value="' . $row[$column] . '">';
						echo "<br>";
						echo '<input type="hidden" name="columns[' . $count . ']" value="' . $column . '"><br>';
					} else {
						echo '<input type="hidden" name="search" value="' . $row[$column] . '">';
					}
					
					$count++;
				}
				?>
							<div id="block3" style="width: 40%">
							<?php
				echo '<input type="hidden" name="action" value="edit_row">' ;
				echo '<input type="hidden" name="table" value="' . $table . '">' ;
				echo '<input type="submit" value="Применить">' ;
				echo '</form>';
				break;
			case "edit_row": 
				$values = $_REQUEST['values'];
				$columns = $_REQUEST['columns'];
				$table = $_REQUEST['table'];
				
				$search = $_REQUEST['search'];
				
				$fields = array();
				foreach ($values as $key=>$value) {
					$fields[$columns[$key]] = $value;
				}
				
				$db->editRow($table, $search, $fields);
				
				header("Location: /admin/index.php?action=show&table=" . $table);
				
				break;
			case "add":
				$values = $_REQUEST['values'];
				$columns = $_REQUEST['columns'];
				$table = $_REQUEST['table'];
				
				$fields = array();
				foreach ($values as $key=>$value) {
					$fields[$columns[$key]] = $value;
				}
				$db->insertTableData($table, $fields);
				header("Location: /admin/index.php?action=show&table=" . $table);
				
				break;
			case "delete":
				$id = $_REQUEST['id'];
				$table = $_REQUEST['table'];
				$columns = $db->getTableColumns($table);
				$condition = array($columns[0] => $id);
				$db->deleteRow($table, $condition);
				header("Location: /admin/index.php?action=show&table=" . $table);
				break;
        }
    }


} else {
    echo $db->getLastError();
}


?>
<script src="../menu/sliiide.js" type="text/javascript"></script>
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