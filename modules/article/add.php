<div class="article-add">
	<h1 class="pageTitle"><?= $language["mod_article"]["add_title"]; ?></h1>
	<?php if (!isset($_POST["save"])) { ?>
	<form action="" method="post">
	<div class="sm-spacer30"></div>

	<div <?php if (!$configuration["lang_1_state"]) {print 'style="display: none;"';} ?>>
		<h2 class="sectionTitle"><?= $configuration["lang_1_name"]; ?></h2>
		<span id="label"><?= $language["form"]["label_title"]; ?></span>
		<input type="text" name="title_1"/>
		<span id="label"><?= $language["form"]["label_content"]; ?></span>
		<?= returnEditor("content_1"); ?>

		<div class="sm-spacer30"></div>
	</div>

	<div <?php if (!$configuration["lang_2_state"]) {print 'style="display: none;"';} ?>>
		<h2 class="sectionTitle"><?= $configuration["lang_2_name"]; ?></h2>
		<span id="label"><?= $language["form"]["label_title"]; ?></span>
		<input type="text" name="title_2"/>
		<span id="label"><?= $language["form"]["label_content"]; ?></span>
		<?= returnEditor("content_2"); ?>

		<div class="sm-spacer30"></div>
	</div>

	<div <?php if (!$configuration["lang_3_state"]) {print 'style="display: none;"';} ?>>
		<h2 class="sectionTitle"><?= $configuration["lang_3_name"]; ?></h2>
		<span id="label"><?= $language["form"]["label_title"]; ?></span>
		<input type="text" name="title_3"/>
		<span id="label"><?= $language["form"]["label_content"]; ?></span>
		<?= returnEditor("content_3"); ?>

		<div class="sm-spacer30"></div>
	</div>

	<div <?php if (!$configuration["lang_4_state"]) {print 'style="display: none;"';} ?>>
		<h2 class="sectionTitle"><?= $configuration["lang_4_name"]; ?></h2>
		<span id="label"><?= $language["form"]["label_title"]; ?></span>
		<input type="text" name="title_4"/>
		<span id="label"><?= $language["form"]["label_content"]; ?></span>
		<?= returnEditor("content_4"); ?>

		<div class="sm-spacer30"></div>
	</div>

	<div <?php if (!$configuration["lang_5_state"]) {print 'style="display: none;"';} ?>>
		<h2 class="sectionTitle"><?= $configuration["lang_5_name"]; ?></h2>
		<span id="label"><?= $language["form"]["label_title"]; ?></span>
		<input type="text" name="title_5"/>
		<span id="label"><?= $language["form"]["label_content"]; ?></span>
		<?= returnEditor("content_5"); ?>

		<div class="sm-spacer30"></div>
	</div>

	<div <?php if (!$configuration["lang_6_state"]) {print 'style="display: none;"';} ?>>
		<h2 class="sectionTitle"><?= $configuration["lang_6_name"]; ?></h2>
		<span id="label"><?= $language["form"]["label_title"]; ?></span>
		<input type="text" name="title_6"/>
		<span id="label"><?= $language["form"]["label_content"]; ?></span>
		<?= returnEditor("content_6"); ?>

		<div class="sm-spacer30"></div>
	</div>

	<div>
		<span id="label"><?= $language["form"]["label_date"]; ?></span>
		<input type="text" name="date" value="<?= date("Y-m-d H:i:s"); ?>"/>

		<div class="sm-spacer30"></div>
	</div>

	<div>
		<span id="label"><?= $language["form"]["label_order"]; ?></span>
		<input type="text" name="order"/>

		<div class="sm-spacer30"></div>
	</div>

	<span id="label"><?= $language["form"]["label_category"]; ?></span>
	<select name="category">
		<option value="null"><?= $language["form"]["label_category_sel"]; ?></option>
	<?php
		$category = new category();

		foreach($category->returnAllCategories() as $cat) {
			if ($cat["category_type"] == "articles") {
				printf("<option value=\"%s\">%s</option>", $cat["id"], $cat["name_1"]);
			}
		}
		unset($category);
	?>
	</select>

	<div class="sm-spacer30"></div>

	<div>
		<span id="label"><?= $language["form"]["label_code"]; ?></span>
		<textarea name="code"></textarea>
		<div class="sm-spacer30"></div>
	</div>

	<div class="bottom-area">
		<label><input type="checkbox" name="published" value="1"/> <?= $language["form"]["label_published"]; ?></label>
		</br>
		<label><input type="checkbox" name="onhome" value="1"/> <?= $language["form"]["label_on_home"]; ?></label>

		<div class="sm-spacer30"></div>

		<button class="green" title="save" type="submit" name="save" class="green"><i class="fa fa-floppy-o"></i></button>
		<button class="red" title="cancel" type="reset" name="cancel" class="red"><i class="fa fa-times"></i></button>
	</div>

	</form>
	<?php } else {

		if (isset($_POST["published"])) $_POST["published"] = true; else $_POST["published"] = false;
		if (isset($_POST["onhome"])) $_POST["onhome"] = true; else $_POST["onhome"] = false;

		$article = new article();
		$article->setContent(
			$_POST["title_1"], $_POST["content_1"],
			$_POST["title_2"], $_POST["content_2"],
			$_POST["title_3"], $_POST["content_3"],
			$_POST["title_4"], $_POST["content_4"],
			$_POST["title_5"], $_POST["content_5"],
			$_POST["title_6"], $_POST["content_6"],
			$_POST["code"]
		);
		$article->setUserId($account['name']);
		$article->setCategory($_POST['category']);
		$article->setDate($_POST['date']);
		$article->setDateUpdate($_POST['date']);
		$article->setPublished($_POST['published']);
		$article->setonHome($_POST['onhome']);
		$article->setOrdering($_POST['order']);

		if ($article->insert()) {
			print $language["actions"]["success"];

			$id = $mysqli->insert_id;
	?>
			<div class="sm-spacer30"></div>

			<span id="label"><?= $language["form"]["label_file_list"]; ?></span>
			<?= returnFilesList($id, "article"); ?>

			<div class="sm-spacer30"></div>

			<?php
				print returnImgUploader("IMG Uploader", $id, "article",290,350);
				print " ";
				print returnDocsUploader("DOCS Uploader", $id, "article",290,350);
			?>
	<?php
		} else {
			print $language["actions"]["failure"];
		}
	} ?>
</div>
