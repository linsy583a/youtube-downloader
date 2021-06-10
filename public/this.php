<?php
$url = trim($_REQUEST['url']);
    if(!empty($url)) {
        echo '<p><a href="'.$url.'">'.$url.'</a><br>';  
        echo '<p><a href="stream.php?url='.urlencode($url).'">stream</a><br>';
    }
    else {
        echo '<a href="/">Back</a>';
    }
?>
<script>
<?php
    if(!empty($url)) {
echo 'window.AppInventor.setWebViewString("'.urldecode($url).'");';
    }
?>
</script>
