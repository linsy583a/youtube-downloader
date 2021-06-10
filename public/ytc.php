<?php
require_once "class.youtube.php";
$yt  = new YouTubeDownloader();
$downloadLinks ='';
$error='';
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
            }
            else {
                $error = "Something went wrong, try from heroku:<br>";
            }

        }
    }
    else {
        $error = "Please enter a YouTube video URL";
    }
}
?>
<!doctype html>
<html lang="en" class="h-100">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Download YouTube video</title>
    <!-- Font-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .formSmall {
            width: 700px;
            margin: 20px auto 20px auto;
        }
    </style>

</head>
<?php
$text = file_get_contents('list.htm');
//class="form-control" 
?>
<body>
    <div class="container">
        
        
        <form method="get" action="" class="formSmall">
            <div class="row">
                <div class="col-lg-12">
                    
                    <h7 class="text-align"><a href="/">Home</a>: YT Video </h7>
                    - - - - - 
                    <a href="list-edit.php">edit</a>
                    <form action="">
            <?php echo $text ?>
            <button type="submit" class="btn btn-primary">select</button>
        </form>
        <form>

                </div>
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" size="48" name="q" placeholder="Paste link.. e.g. https://www.youtube.com/watch?v=OK_JCtrrv-c" 
                        <?php 
                           if(!empty($videoLink)) {
                               echo 'value="'.$videoLink.'"';
                           }
                        ?>
                        >
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Go!</button>
                      </span>
                         &nbsp;<input type="checkbox" id="showall" name="all" <?php if (isset($_REQUEST['all'])) {echo "checked";} ?>> <small>All Formats</small>
                    </div><!-- /input-group -->
                </div>
            </div><!-- .row -->
            
        </form>

        <?php if($error) :?>
            <div style="color:red;font-weight: bold;text-align: center"><?php print $error?></div>
            <div style="text-align: center">
        <?php 
            echo '<a href="http://yttpl.herokuapp.com/vinfo.php?url='.$videoLink.'">Fetch-YTTPL</a>';
            echo ' | <a href="http://alltb-tpl.herokuapp.com/info?url='.$videoLink.'">alltb-tpl.heroku</a>';
            echo ' | <a href="https://alltb-tpl.herokuapp.com/download?url='.$videoLink.'">Fetch-Heroku2-720p</a>';
            echo ' | <a href="https://alltb-tpl.herokuapp.com/download?format=18&url='.$videoLink.'">Fetch-Heroku2-360p</a>';  
        endif; ?> 
        </div>

        <?php if(!empty($formats)):?>
        <div class="row formSmall">
            <div class="col-lg-3">
                <img src="<?php print $thumbnail?>">
            </div>
            <div class="col-lg-9">
                <strong><?php print $title?></strong>
                <p><?php print "<a href=$videoLink>$videoLink</a>"?></p>
            </div>
        </div>

        <div class="card formSmall">
            <div class="card-header">
                <strong>Format </strong> 
                <small> [<a href="http://yttpl.herokuapp.com/vinfo.php?url=<?php print urlencode($videoLink)?>">yttpl</a>] 
                [<a href="https://alltb-tpl.herokuapp.com/info?url=<?php print urlencode($videoLink)?>">atbtpl</a>
                ]</small>
            </div>
            <div class="card-body">
                <table class="table ">

                    <?php foreach ($formats as $video) :?>
                        <tr>
                            <td><a href="<?php print $video['link']?>">View</a>
                             [<a href="this.php?url=<?php print urlencode($video['link'])?>">src</a>
                             | <a href="stream.php?url=<?php print urlencode($video['link'])?>">stream</a>]</td>
                            <td><?php print $video['quality']?></td>
                            <td>Full <?php print $video['type']?></td>
                            <td><a href="downloader.php?link=<?php print urlencode($video['link'])?>&title=<?php print urlencode($title)?>&type=<?php print urlencode($video['type'])?>">Download</a> </td>                            
                        </tr>
                    <?php endforeach;?>
                    <?php if(!empty($_REQUEST['all'])):?> 
                    <tr>

                     <td>single mode</td>   
                        
                    </tr>
                                       
                    <?php foreach ($adapativeFormats as $video) :?>
                        <tr>
                            <td><a href="<?php print $video['link']?>">View</a>
                             [<a href="y/this.php?url=<?php print urlencode($video['link'])?>">src</a>
                             | <a href="http://yttpl.herokuapp.com/stream.php?url=<?php print urlencode($video['link'])?>">stream</a>]</td>
                            <td><?php print $video['quality']?></td>
                            <td><?php print $video['type']?> only</td>
                            <td><a href="y/downloader.php?link=<?php print urlencode($video['link'])?>&title=<?php print urlencode($title)?>&type=<?php print urlencode($video['type'])?>">Download</a> </td>  
                        </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </table>
            </div>
        </div>
        <?php endif;?>
    </div>
</body>
</html>
