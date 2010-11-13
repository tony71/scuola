<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="include/upload_foto.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
    <input type="hidden" name="matricola" value="<?php echo $_GET['matricola']; ?>" />
</form>
