<html>
<head>

<style type="text/css">

#dest_dir {
	size: 80;
	width: 520px;
}
</style>
</head>
<body>

<form action="upload_file.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"/><br>
<label>dest_dir:</label><input name="dest_dir" id="dest_dir" value="<?php echo $_REQUEST["dir"]; ?>"/><br>
<input type="submit" name="submit" value="Submit"/><br>
</form>

</body>
</html> 