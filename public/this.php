<?php
$url = trim($_REQUEST['url']);
$aiw = $_REQUEST['aiw'];
    if(!empty($url) && !empty($aiw)) {
        echo '<p><a href="'.$url.'">'.$url.'</a><br>';  
        echo '<p><a href="stream.php?url='.urlencode($url).'">stream</a><br>';
    } elseif (!empty($url)) {
        echo $url;   
    }
    else {
        echo '<a href="/">Back</a>';
    }
?>
<script>
<?php
    if(!empty($url) && !empty($aiw)) {
echo 'window.AppInventor.setWebViewString("'.urldecode($url).'");';
    }
?>
</script>
