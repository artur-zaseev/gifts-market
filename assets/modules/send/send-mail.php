<?php

	// Получаем GET параметры
	$to = "az@icu-agency.ru, office@icu-agency.ru";
	$subject = "Письмо с сайта GIFTY.ONE";
	$user_name = ($_GET["user_name"]);
	$user_phone = ($_GET["user_phone"]);
	$user_mail = ($_GET["user_mail"]);
	$user_message = ($_GET["user_message"]);
	$message = '
	<html>
	    <head>
	        <title>'.$subject.'</title>
	    </head>
	    <body>
	      <h1 align="center" style="color: #595959;">'.$subject.'</h1>
				<table style="margin: 0 auto;">
					<tr>
						<td>
							<p style="color: #2B961F;">
								<b>Имя:</b> '.$user_name.'<br>
								<b>Телефон:</b> '.$user_phone.'<br>
								<b>E-mail:</b> '.$user_mail.'<br>
								<b>Сообщение:</b> '.$user_message.'
							</p>
						</td>
					</tr>
				</table>
	    </body>
	</html>';
	$headers  = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: gifty.one <gifty.one@yandex.ru>\r\n";
	$headers .= "Bcc: gifty.one@yandex.ru\r\n";
	mail($to, $subject, $message, $headers);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Отправка E-mail</title>
	<meta http-equiv="refresh" content="3; URL=/">
	<style>
		* {margin: 0; padding: 0;}
		html, body {height: 100vh;}
		body {display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffbd00; color: #FFF;}
	</style>
</head>
<body>
   	<h1>Ваше сообщение успешно отправлено!</h1>
   	<br>
   	<h2>В ближайшее время наш сотрудник свяжется с вами</h2>
   	<br>
   	<br>
		Через 3 секунды вы будете автоматически перенаправлены на главную страницу
</body>
</html>
