<?php 
 include_once('../db.php');
 session_start(); 
 include_once('../my.php');
 $article = array();
 if (isset($_GET['id'])) {
	$comments = get_comments($_GET['id']);
	$article = get_article($_GET['id']);
 }
 if (isset($_POST['addcomment']) and (isset($_GET['id']))) {
	$flag=add_comment($_POST['text'], $_GET['id'], $_SESSION['user_id']);
	header("Location: article.php?id=" . $_GET['id']);
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ваш помощник</title>	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/style1.css" />
</head>
<body>
				
    <a href="/information.php"><img src="img/last.png" style="margin-top: 20px;margin-left: 40px;" ></a>
	
	<h1 color = "#74777b" style="margin-left: 40px;margin-top: 50px; color: #74777b;"><?php echo $article['title']; ?></h1>
	<table>
	<tr>
	<td style="padding-left: 40px;padding-right: 30px;">
	<?php echo $article['text']; ?>
	</td>
	<td>
	<img src="<?php echo $article['img']; ?>" width="480" height="330" alt="img02" style="padding-right: 20px;"/>
	</td>
	</tr>
	</table>
<br><br>
<form method="post" >
	<textarea rows="5" cols="45" name="text" style="margin-left: 40px;"></textarea>
	<input type="hidden" name="addcomment" value="true">
	<button style="padding-left: 20px;padding-right: 20px;padding-top: 10px;padding-bottom: 10px;margin-top: 25px;" 
	type="submit" id="submit" name="submit" value="Отправить" 
	class="button button--ujarak button--border-medium button--round-s button--text-thick">Отправить</button>
	</form>
	<br><br><br>
	<table>
	<tr>
<?php
foreach($comments as $key=>$comment) { 
$user = get_user($comment['user']); ?> </td>
<td>
<div>
	<p style="margin-left: 40px;"><span><?php echo $user['name'] ?></span> написал(а): <?php echo $comment['text']; ?></p>
</td>
<tr>
<table>
	<hr>
</div>
<?php } ?>
</body>
</html>
	


