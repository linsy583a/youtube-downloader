<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
   <a href="ytc.php">YTC</a> | <a href="list.htm">list.htm</a><br>
<?php
       ini_set("display_errors",1);
              error_reporting(E_ALL);
// configuration
$url = 'list-edit.php';
$file = 'list.htm';
$al = file_get_contents($file);

  //  file_put_contents($file, serialize($al));
// check if form has been submitted

if (isset($_POST['list']))
{
    // save the text contents
    $content = $_POST['list'];
    $al = '<select name="q" id="q"><option value=""> </option> '."\r\n".$content.'</select>';
    file_put_contents($file, $al);
    //file_put_contents($title, $_POST['title']);
    // redirect to form again
    //header(sprintf('Location: %s', $url."?g=$g"));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url)."");
    exit();
}
?>
<?php
// read the textfile
$text = $al;
echo $text;
//$title_text = file_get_contents($title);
$text = explode('<option value=""> </option>',$text)[1];
$text = trim(explode('</sele',$text)[0]);
?>

<form action="" accept-charset="utf-8" method="post">
      <input type="submit" value="update">
<textarea id="list" name="list" rows="20" cols="80">
<?php echo $text ?>
  </textarea>
    
</form>



</body></html>
