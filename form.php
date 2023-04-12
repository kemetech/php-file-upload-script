<?php
require('upload.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Form</title>
</head>
<body>

    <form action="upload.php" method="post" enctype="multipart/form-data" accept=".pdf,.doc,.docx,.odt">
        <label for="file">Select a file to upload</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="upload file" id="">
    </form>  
</body>
</html>
