<?php

function returnFilesList($id, $module) {
	global $configuration;

	return sprintf('<iframe src="%s/modules/upload/upload_list.php?mdl=%s&i=%s">Your Browser do not support iframe method!</iframe>', $configuration["path-bo"], $module, $id);
}

function returnImgUploader($button, $id, $module, $width, $height) {
	global $configuration;

	return sprintf('<button type="button" onclick="popUp(\'%s/modules/upload/upload_script_img.php?mdl=%s&i=%s\',\'%s\',\'%s\'); return false;">' . $button . '</button>', $configuration["path-bo"], $module, $id, $width, $height);
}

function returnDocsUploader($button, $id, $module, $width, $height) {
	global $configuration;

	return sprintf('<button type="button" onclick="popUp(\'%s/modules/upload/upload_script_docs.php?mdl=%s&i=%s\',\'%s\',\'%s\'); return false;">' . $button . '</button>', $configuration["path-bo"], $module, $id, $width, $height);
}

function returnEditor($textareanema, $content = "<div><br/><div>") {
	return sprintf("<textarea name=\"%s\" id=\"%s\" style=\"width: 670px;\">%s</textarea>"
			. "<script type=\"text/javascript\">new nicEditor({fullPanel : true}).panelInstance('%s');</script>", $textareanema, $textareanema, $content, $textareanema);
}

function sendEmailTo($from, $to, $subject, $message, $attach = array()) {
	global $configuration;

	$fName = $configuration["site-name"];
	$lName = $configuration["site-slogan"];

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = "UTF-8";
	$mail->Host = $configuration["mail-smtp"]; // SMTP server example
	$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->Port = 25; // set the SMTP port for the GMAIL server
	$mail->SMTPSecure = $configuration["mail-secure"];
	$mail->Username = $configuration["mail-username"]; // SMTP account username example
	$mail->Password = $configuration["mail-password"];
	$mail->SetFrom($from, $fName . ' : ' . $lName);
	$mail->Subject = $subject;
	$mail->AddAddress($to, "User");
	$mail->MsgHTML($message);

	if (count($attach) > 0) {
		foreach ($attach as $file) {
			$mail->addAttachment($file[0],$file[1]);
		}
	}
	
	if (!$mail->Send()) {
		return false;
	} else {
		return true;
	}
}

function generateRandomString($length = 10) {
	// work 100%
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	// in beta testing
	$characters = '!#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_abcdefghijklmnopqrstuvwxyz{|}~';

	$randomString = '';

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}

	return $randomString;
}

function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

/* origin http://jesin.tk/how-to-use-php-to-minify-html-output/ */
function minifyPage($buffer) {
	$search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');

	$replace = array('>', '<', '\\1');

	if (preg_match("/\<html/i", $buffer) == 1 && preg_match("/\<\/html\>/i", $buffer) == 1) {
		$buffer = preg_replace($search, $replace, $buffer);
	}

	$buffer = preg_replace('/<!--(.|\s)*?-->/', '', $buffer);

	return $buffer;
}

function minifyHTML($buffer) {
	$search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');

	$replace = array('>', '<', '\\1');

	$buffer = preg_replace($search, $replace, $buffer);

	$buffer = preg_replace('/<!--(.|\s)*?-->/', '', $buffer);

	return $buffer;
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'x', $img = false, $atts = array()) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";

	if ($img) {
		$url = '<img src="' . $url . '"';
		foreach ($atts as $key => $val)
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}

	return $url;
}
