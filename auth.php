<?php 
error_reporting(0); 
 include_once('db.php');
 session_start();
 
  if (isset($_SESSION['user_id'])) {
	 header("Location: /");
 }
 
 
 if (isset($_REQUEST['submit'])) {
	 $error = '';
	 if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
		 $error .= "Логин не введен <br>";
	 }
	 if (!isset($_REQUEST['password']) || empty($_REQUEST['password'])) {
		 $error .= "Пароль не введен";
	 }
	 
	if (!empty($error)) {
		echo $error;
	} else {
		$login = $_REQUEST['name'];
		$password = md5($_REQUEST['password']);
		
		$result = $db->query("SELECT * FROM users WHERE `login`='" . $login . "' and `password`='" . $password . "';");
		if ($db->affected_rows == 0) {
			$error .= '<span class="error">Неверные данные</span><br><br>';
		} else {
			$result = $result->fetch_assoc();
			$_SESSION['user_id'] = $result['id'];
			header("Location: /");
		}
	}
 }
  if (isset($_REQUEST['submit1'])) {
	 $error = '';
	 	 if (!isset($_REQUEST['name2']) || empty($_REQUEST['name2'])) {
		 $error .= "Имя не введено <br>";
	 }
	 if (!isset($_REQUEST['surename']) || empty($_REQUEST['surename'])) {
		 $error .= "Пароль не введен";
	 }
	 if (!isset($_REQUEST['name1']) || empty($_REQUEST['name1'])) {
		 $error .= "Логин не введен <br>";
	 }
	 if (!isset($_REQUEST['password1']) || empty($_REQUEST['password1'])) {
		 $error .= "Пароль не введен";
	 }
	
	 
	if (!empty($error)) {
		echo $error;
	} else {
		$login = $_REQUEST['name1'];
		$password = $_REQUEST['password1'];
		$name = $_REQUEST['name2'];
		$surename = $_REQUEST['surename'];
			$result = $db->query("SELECT * FROM users WHERE login='" . $login . "'");
			if ($db->affected_rows > 0) {
				$error = '<span class="error">Логин занят</span>';			
			} else {
				if (!$db->query("INSERT INTO users (name, surename, login, password, admin) VALUES ('" . $name . "', '" . $surename . "', '" . $login . "','" . md5($password) . "', 0);")) {
					die($db->error);
				}
				
				$_SESSION['user_id'] = $db->insert_id;
				header("Location: /");
			}
		}
		
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Авторизация</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/buttons.css" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">	
</head>
<body> 
<h1 id='qqq'> Брось себе вызов! </h1>
<p id='www'> 
    С этого дня это твой личный помощник   
<br>здорового образа жизни. 
<br>Тебя ждёт разнообразное питание с 
<br>подробными рецептами, которое
<br>поможет тебе стать лучше. 
<br>Программы подстраиваются под тебя.
<br>Ставь перед собой новые цели 
<br>и добивайся их.</p>
<section class="content">
	<div class="box bg-2">
	<button class="button1 button--ujarak1 button--border-medium1 button--round-s1 button--text-thick1"><a href="#openModal">ВОЙТИ</a></button>
	</div>				
			</section>
<div id="openModal" class="modalDialog">
	<div>
		<a href="#close" title="Закрыть" class="close">X</a>
<form id="form" name="form" action="" method="post"><div id='1'>
 <div class="form">  
        <div id="login">   
          <h1>Добро пожаловать</h1>
          
          <form action="/" method="post">
          
            <div class="field-wrap">
<label>
              Email<span class="req">*</span>
            </label>
            <input type="text" name="name" id="name"required autocomplete="off"/>
          </div>
		  <div class="field-wrap">
            <label>
              Пароль<span class="req">*</span>
            </label>
            <input type="password" name="password" id="password"required autocomplete="off"/>
          </div>
		  
          <p class="forgot"><a href="#">Забыли пароль?</a></p>
          <button class="button button-block" type="submit" id="submit" name="submit"/>Начать</button>
		
		<br><br><br><br>
		<?php
			echo !empty($error)?$error:"";
		?>
          
          </form>

        </div>
	
	</form>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
		</div>
</div>
</div>
<section class="content">
<div class="box bg-2">
	<button class="button1 button--ujarak1 button--border-medium1 button--round-s1 button--text-thick1"><a href="#openModal1">РЕГИСТРАЦИЯ</a></button>
				</div>				
			</section>

<div id="openModal1" class="modalDialog1">
	<div>
		<a href="#close" title="Закрыть" class="close">X</a>
		<form id="form" name="form" action="" method="post"><div id='1'>
 <div class="form">  
        	<div id="signup">   
          <h1>Бесплатная регистарция</h1>       
          <form action="/" method="post">
		  <div class="top-row">
            <div class="field-wrap">
              <label>
                Имя<span class="req">*</span>
              </label>
              <input type="text" name="name2" id="name2" required autocomplete="off" />
            </div>
        
            <div class="field-wrap">
              <label>
                Фамилия<span class="req">*</span>
              </label>
              <input type="text" name="surename" id="surename"required autocomplete="off"/>
            </div>
          </div>
          <div class="field-wrap">
            <label>
              Email<span class="req">*</span>
            </label>
            <input type="text" name="name1" id="name1"required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Пароль<span class="req">*</span>
            </label>
            <input type="password" name="password1" id="password1"required autocomplete="off"/>
          </div>
          
          <button type="submit" class="button button-block" name="submit1" id="submit1"/>Начать</button>
		
		<br><br><br><br>
		<?php
			echo !empty($error)?$error:"";
		?>
          
          </form>

        </div>
	
	</form>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
		</div>
</div>
</div>
</body>
</html>


