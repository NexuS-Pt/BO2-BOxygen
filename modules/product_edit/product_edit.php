<div class="product-edit">
	<?php if($id !== null){ ?>
		<h1 class="pageTitle"><?= $language["mod-product-edit-title"]; ?></h1>
		<?php if (!isset($_POST["save"])) {
			$product = new product();
			$product->setId($id);
			$item = $product->returnOneProduct();
		?>
		<form action="" method="post">
			<div class="separator30"></div>
			<div>
				<span id="label">Referencia</span>
				<input type="text" name="reference" value="<?= $item["reference"] ?>" />
			</div>
			<div class="separator30"></div>
			<div <?php if (!$configuration["lang_1_state"]) {echo "style=\"display: none;\"";} ?>>
				<h2>Lingua 1</h2>
				<span id="label">Artigo</span>
				<input type="text" name="title_1" value="<?= $item["title_1"] ?>"/>
				<span id="label">Descrição</span>
				<?= returnEditor("content_1", $item["content_1"]); ?>
				<div class="separator30"></div>
			</div>
			<div <?php if (!$configuration["lang_2_state"]) {echo "style=\"display: none;\"";} ?>>
				<h2>Lingua 2</h2>
				<span id="label">Artigo</span>
				<input type="text" name="title_2" value="<?= $item["title_2"] ?>"/>
				<span id="label">Descrição</span>
				<?= returnEditor("content_2", $item["content_2"]); ?>
				<div class="separator30"></div>
			</div>
			<div <?php if (!$configuration["lang_3_state"]) {echo "style=\"display: none;\"";} ?>>
				<h2>Lingua 3</h2>
				<span id="label">Titulo</span>
				<input type="text" name="title_3" value="<?= $item["title_3"] ?>"/>
				<span id="label">Descrição</span>
				<?= returnEditor("content_3", $item["content_3"]); ?>
				<div class="separator30"></div>
			</div>
			<div <?php if (!$configuration["lang_4_state"]) {echo "style=\"display: none;\"";} ?>>
				<h2>Lingua 4</h2>
				<span id="label">Titulo</span>
				<input type="text" name="title_4" value="<?= $item["title_4"] ?>"/>
				<span id="label">Descrição</span>
				<?= returnEditor("content_4", $item["content_4"]); ?>
				<div class="separator30"></div>
			</div>
			<div <?php if (!$configuration["lang_5_state"]) {echo "style=\"display: none;\"";} ?>>
				<h2>Lingua 5</h2>
				<span id="label">Titulo</span>
				<input type="text" name="title_5" value="<?= $item["title_5"] ?>"/>
				<span id="label">Descrição</span>
				<?= returnEditor("content_5", $item["content_5"]); ?>
				<div class="separator30"></div>
			</div>
			<div <?php if (!$configuration["lang_6_state"]) {echo "style=\"display: none;\"";} ?>>
				<h2>Lingua 6</h2>
				<span id="label">Titulo</span>
				<input type="text" name="title_6" value="<?= $item["title_6"] ?>"/>
				<span id="label">Descrição</span>
				<?= returnEditor("content_6", $item["content_6"]); ?>
				<div class="separator30"></div>
			</div>

			<span id="label">Categoria</span>
			<select name="category">
				<option value="null">Selecione uma Categoria</option>
			<?php
				$category = new category();

				foreach($category->returnAllCategories() as $cat) {
					$selected = null;
					if ($cat["id"] === $item["category_id"]) {
						$selected = "selected=\"\"";
					}

					if ($cat["category_type"] === "products") {
						printf("<option value=\"%s\" %s>%s</option>", $cat["id"], $selected, $cat["name_1"]);
					}
				}
			?>
			</select>

			<div class="separator30"></div>

			<span id="label">Lista de ficheiros</span>
			<?= returnFilesList($item["id"],"product"); ?>

			<div class="separator30"></div>

			<?php
				print returnImgUploader("IMG Uploader",$item["id"],"product","290",350);
				print " ";
				print returnDocsUploader("DOCS Uploader",$item["id"],"product","290",350);
			?>

			<div class="separator30"></div>
			<div>
				<span id="label">Code</span>
				<textarea name="code"><?= $item["code"]; ?></textarea>
				<button id="code_spr" type="button">[spr]</button> <button id="code_slash" type="button">[/]</button>
				<div class="separator30"></div>
			</div>

			<div>
				<span id="label">Price</span>
				<input type="number" step="any" placeholder="ex.: 1.23" name="price" value="<?= $item["price"]; ?>" />
				<div class="separator30"></div>
			</div>

			<div>
				<span id="label">VAT</span>
				<input type="number" step="any" placeholder="ex.: 23.0" name="vat" value="<?= $item["vat"]; ?>" />
				<div class="separator30"></div>
			</div>

			<div>
				<span id="label">Discount</span>
				<input type="number" step="any" placeholder="ex.: 1.10" name="discount" value="<?= $item["discount"]; ?>"/>
				<div class="separator30"></div>
			</div>

			<div class="bottom-area">
				<input type="checkbox" <?php if ($item["service"]) { print "checked=\"yes\"";} ?> name="service" /> Serviço
				<br />
				<input type="checkbox" <?php if ($item["published"]) { print "checked=\"yes\"";} ?> name="published" /> Publicado
				<br />
				<input type="checkbox" <?php if ($item["onhome"]) { print "checked=\"yes\"";} ?>  name="onhome" /> Pagina Inicial
				<br />
				<button class="green" title="save" type="submit" name="save" class="green"><i class="fa fa-floppy-o"></i></button>
				<button class="red" title="cancel" type="reset" name="cancel" class="red"><i class="fa fa-times"></i></button>
			</div>
		</form>
		<?php

		} else {
			$product = new product();
			$product->setId($id);

			// convert to bool the service box
			if (isset($_POST["service"])) {
				$service = true;
			} else {
				$service = false;
			}
			// convert to bool the published box
			if (isset($_POST["published"])) {
				$published = true;
			} else {
				$published = false;
			}
			// convert to bool the onhome box
			if (isset($_POST["onhome"])) {
				$onhome = true;
			} else {
				$onhome = false;
			}

			$product->setContent(
				$_POST["title_1"], $_POST["content_1"],
				$_POST["title_2"], $_POST["content_2"],
				$_POST["title_3"], $_POST["content_3"],
				$_POST["title_4"], $_POST["content_4"],
				$_POST["title_5"], $_POST["content_5"],
				$_POST["title_6"], $_POST["content_6"],
				$_POST["code"]
			);

			$product->setReference($_POST["reference"]);
			$product->setPrice($_POST["price"]);
			$product->setVAT($_POST["vat"]);
			$product->setDiscount($_POST["discount"]);

			$product->setCategory($_POST["category"]);
			$product->setDateUpdate();
			$product->setService($service);
			$product->setPublished($published);
			$product->setonHome($onhome);

			if ($product->update()) {
				print $language["actions"]["success"];
			} else {
				print $language["actions"]["failure"];
			}
		}
	}else{
		print $language["actions"]["error"];
	}
	?>
</div>
