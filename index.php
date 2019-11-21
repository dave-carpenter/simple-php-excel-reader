<?php
	session_start();
?>

<html>

<head>
	<title>read from file</title>
</head>

<body>

	<div style="border:2px solid black; display:inline-block; padding:5px;">
		<form action="upload.php" method="post" enctype="multipart/form-data">
		    Select file to upload:
				<br><br>
		    <input type="file" name="fileToUpload" id="fileToUpload">
				<br><br>
		    <button type="submit" value="upload" name="submit">Upload File</button>
		</form>

		<form action="upload.php" method="post">
			<button type="submit" value="recent" name="submit">Use Most Recent File</button>
		</form>

	</div>

</body>

</html>
