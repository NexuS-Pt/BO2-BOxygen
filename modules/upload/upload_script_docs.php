<?php
include "../../configuration.php";
include "../../connect.php";

$language = parse_ini_file(
	sprintf("../../languages/%s.ini", $configuration["language"]),
	true
);

header("Content-Type: text/html; charset=utf-8");
?>
<html>
	<head>
		<title>DOCS Uploader</title>
		<script type="text/javascript" src="<?= $configuration["path-bo"] ?>/site-assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?= $configuration["path-bo"] ?>/site-assets/js/script.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
		<style type="text/css">
			* {
				font-family: Sans-Serif;
			}

			label {
				display: block;
			}

			input {
				display: block;
				border: 1px solid lightGrey;
				width: 100%;
				height: 30px;
			}

			button {
				background: url("../../site-assets/images/bg-shade-light.png");
				border: 1px solid rgb(221, 221, 221);
				line-height: 25px;
				padding-left: 5px;
				padding-right: 5px;
			}

			blockquote {
				border: 1px solid lightGrey;
				padding: 5px;
				font-size: 13px;
				color: grey;
				margin: 0;
				display: inline-block;
			}

			img.thumb {
				max-width: 100%;
				max-height: 150px;
				margin: auto;
				display: block;
			}

			.spacer30 {
				height: 30px;
			}
		</style>
	</head>
	<body>
		<?php
		// SÓ ENTRA NO UPLOADER SE O COOKIE AINDA EXISTIR
		// O UTILIZADORE TERÁ DE TER CUIDADO COM O TEMPO DE SESSÃO
		if (isset($_GET["mdl"]) && isset($_GET["i"]) && !empty($_GET["mdl"]) && !empty($_GET["i"])) {
			$module = $mysqli->real_escape_string($_GET["mdl"]);
			$id = $mysqli->real_escape_string(intval($_GET["i"]));

			if (isset($_COOKIE[$configuration["cookie"]])) {
				if (!isset($_REQUEST["submit"])) {

					$query = sprintf(
						"SELECT * FROM %s_files_type WHERE upload_format = 'document'",
						$configuration["mysql-prefix"]
					);
					$source = $mysqli->query($query);
					while ($data = $source->fetch_assoc()) {
						if (!isset($allowedFormats)) {
							$allowedFormats = $data["extension"];
						} else {
							$allowedFormats .= " ".$data["extension"];
						}
					}

					print
							"<form method=\"post\" enctype=\"multipart/form-data\">".
							"<label>Description:</label>".
							"<input type=\"text\" name=\"description\" maxlength=\"255\" />".
							"<div class=\"spacer30\"></div>".
							"<label>Code:</label>".
							"<textarea name=\"code\"></textarea>".
							"<div class=\"spacer30\"></div>".
							"<label>File:</label>".
							"<input type=\"file\" name=\"file\" />".
							"<div class=\"spacer30\"></div>".
							"<button type=\"submit\" name=\"submit\" onclick=\"if ($('input[type=file]').val() != '' && $('input[name=alt_1]').val() != '') {return true;} else {alert('Preencha o campo ALT! Seleccione um Ficheiro!'); return false} return false;\">Submit</button>".
							"<blockquote>Alloowed Formats:".$allowedFormats."</blockquote>".
							"</form>";
				} else {
					$query = sprintf(
						"SELECT * FROM %s_files_type WHERE upload_format = 'document' AND type = '%s'",
						$configuration["mysql-prefix"], $_FILES["file"]["type"]
					);
					$source = $mysqli->query($query);

					if ($source->num_rows > 0) {
						$description = $mysqli->real_escape_string($_POST["description"]);
						$code = $mysqli->real_escape_string($_POST["code"]);
						$data = $source->fetch_assoc();
						$time = time();
						$fileName = $time.".".$data["extension"];
						$filePath = "../../../u-files/" . $fileName;

						$query = sprintf(
							"INSERT INTO %s_files (file, type, description, code, module, ordering, id_ass, user_id, date) VALUES ('%s', '%s', '%s', '%s', '%s', '0', '%s', '%s', '%s')",
							$configuration["mysql-prefix"], $fileName, "document", $description, $code, $module, $id, $userData["id"], date("Y-m-d H:i:s", $time)
						);

						if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
							if ($mysqli->query($query)) {
								print "<p>File saved with sucess!</p>";
								print "<button onclick=\"goTo('".$filePath."');\">Uploaded File (".$_FILES["file"]["name"].")</button>";
								print "<button onclick=\"goTo('".$_SERVER["REQUEST_URI"]."');\">Adicionar Mais</button>";
							} else {
								print "<p>Error Announce! The system can't save this entry on BD for unkown reason!</p>";
							}
						} else {
							print "<p>Error Announce! The system can't save this file for unkown reason!</p>";
						}
					} else {
						print "<p>Formato não conhecido pelo sistema!</p>";
					}
				}
			} else {
				print "<p>Please login first!</p>";
			}
		} else {
			print "<p>The module can\'t be initialized!</p>";
		}
		?>
	</body>
</html>
