<html>

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body><a href="/">home</a><br>
<?php
       ini_set("display_errors",1);
              error_reporting(E_ALL);
$file ="";
$text ="";
$pin_msg ="";

// configuration
$url = 'ed.php';

if (!empty($_REQUEST['file'])) {
    $file = $_REQUEST['file'];
  if (isset($_POST['cont'])) {
    if ($_REQUEST['pin']=='300') {

    // save the text contents
    file_put_contents($file, $_POST['cont']);
    // redirect to form again
    //header(sprintf('Location: %s', $url."?g=$g"));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url)."?file=$file");
    exit();
    } else {
      $pin_msg = "invalid pin, hint Bridletowne without 7";
      $text = $_POST['cont'];  
    }
  } else {
    if (file_exists($file)) {
      $text = file_get_contents($file); 
    } else {$pin_msg="no such file!";}
}}
?>

<form>
  <input type="text" name="file" value="<?php echo $file; ?>">
  <input type="submit" value="select">
</form>

<?php
// read the textfile
echo $pin_msg;
?>
<form action="" accept-charset="utf-8" method="post">
  Pin: <input type="text" name="pin" value="">
  File: <label name="file" id="file">
      <?php echo $file; ?></label><br>  
<textarea id="cont" name="cont" rows="30" cols="100">
<?php echo $text; ?>
</textarea><br>
<input type="submit" value="update">
</form>
</body></html>













