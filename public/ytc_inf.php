<?php
require_once "class.youtube.php";
$yt  = new YouTubeDownloader();
$downloadLinks ='';
$error='';
$ytObj = new stdClass();
if(isset($_REQUEST['q'])) {
    $videoLink = trim($_REQUEST['q']);

    if(!empty($videoLink)) {
        $vid = $yt->getYouTubeCode($videoLink);
        if($vid) {
            $result = $yt->processVideo($vid);
            
            if($result) {
                //print_r($result);
                $info = $result['videos']['info'];
                $formats = $result['videos']['formats'];
                $adapativeFormats = $result['videos']['adapativeFormats'];

                

                $videoInfo = json_decode($info['player_response']);

                $title = $videoInfo->videoDetails->title;
                $thumbnail = $videoInfo->videoDetails->thumbnail->thumbnails{0}->url;
		$ytObj->title = $title;
		$ytObj->thumbnail = $thumbnail;
		$ytObj->ytUrl = $videoLink;
		$ytObj->formats = $formats;
		//$ytObj->info  = $info;

		


            }
            else {
                $error = "Something went wrong, try from heroku:<br>";
		$ytObj->error = "something wrong";
            }

        }
    }
    else {
        $ytObj->error = "Please enter a YouTube video URL";
    }
}
$ytJSON = json_encode($ytObj);
echo $ytJSON;
?>
