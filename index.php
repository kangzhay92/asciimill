<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ASCII Mill - Image to Colorful ASCII Converter</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body style="background: #333; font-family: monospace;">
<?php
require_once "AsciiMill_Class.php";

if (!isset($_POST['sent']))
{
    ?>
	<br><br><br><br><br>
	<br><br><br><br><br>
	<br><br><br><br><br>
	<div style="padding: 20px 25px 30px;" class="container">
		<div style="max-width: 400px; margin: 0 auto 25px" class="panel panel-primary text-center">
			<div class="panel-heading">Convert Image To Colorful ASCII Art</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<input type="file" name="image">
					</div>
					<div class="form-group">
						<input type="submit" value="Convert!">
					</div>
					<input type="hidden" name="sent">
				</form>
			</div>
		</div>
	</div>
    <?php
	$footer = new AsciiMill();
    $footer = $footer->ShowFooter();
    echo $footer;
}
else
{
    $image = $_FILES['image'];
    $send = new AsciiMill();
    $send->StartProcess($image);
}
?>
</body>
</html>
