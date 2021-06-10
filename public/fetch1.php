<?php
function getTrueURL($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $data = curl_getinfo($ch);
    return $data["url"];
}

$url = trim($_REQUEST['url']);
$aiw = $_REQUEST['aiw'];
$videoLink = "https://alltb-tpl.herokuapp.com/download?url=".$url;

if(!empty($_REQUEST['sd'])) { $videoLink .= "&format=18"; }
$turl = getTrueURL($videoLink);

if(!empty($url) && !empty($aiw)) {
        echo '<p><a href="'.$turl.'">'.$turl.'</a>';
        echo '<p><a href="stream.php?url='.urlencode($turl).'">stream</a>';
} elseif (!empty($url)) {
        echo $turl;     
}
else {
echo '<a href="/"></a> | ';
echo '<a href="ytc.php">YTC</a>';
}
?>
<html>
<script>
    if(!empty($url) && !empty($aiw)) {
echo 'window.AppInventor.setWebViewString("'.$turl.'");';
    }
</script>
</html>
