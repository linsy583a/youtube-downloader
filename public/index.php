<?php
if(isset($_REQUEST['q'])) {
    $videoLink = trim($_REQUEST['q']);
} else {
    $videoLink = "https://www.youtube.com/watch?v=aqz-KE-bpKQ";   
}    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>youtube-downloader</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>


    <h3><a href="ytc.php?q=<?php echo urlencode($videoLink);?>">ytc</a></h3>
<video width="800" height="600" controls>
    <source src="" type="video/mp4"/>
    <em>Sorry, your browser doesn't support HTML5 video.</em>
</video>
 <form action="vinfo.php">
     <input type="submit" value="get">
    {<input type="checkbox" id="chk_all" name="detail">}      
    <input type="text" value="<?php echo $videoLink;?>" placeholder="https://www.youtube.com/watch?v=" size="80" id="txt_url" name="url">
    <input type="checkbox" id="chk_hd">HD 
    <input type="button" id="btn_fetch" value="Fetch">    
</form>
<a href="#" id="vlink"></a>
    
<p>
Source: <a href="https://github.com/Athlon1600/youtube-downloader">https://github.com/Athlon1600/youtube-downloader</a>
</p>

<script>
    $(function () {

        $("#btn_fetch").click(function () {
                $("#vlink").attr("href", "#");
                $("#vlink").text("");
            var url = $("#txt_url").val();
            var hdon = null;
            var oThis = $(this);
            oThis.attr('disabled', true);

            $.get('vinfo.php', {url: url}, function (data) {
                console.log(data);

                oThis.attr('disabled', false);

                var links = data['links'];
                var error = data['error'];

                if (error) {
                    alert('Error: ' + error);
                    return;
                }

                // first link with video
                var first = links[0];
                 if ($("#chk_hd").prop("checked")) {first=links[1];}

                if (typeof first === 'undefined') {
                    alert('No video found!');
                    return;
                }
                

                var stream_url = 'stream.php?url=' + encodeURIComponent(first);

                var video = $("video");
                video.attr('src', stream_url);
                video[0].load();
                $("#vlink").attr("href", first);
                
                var hdtext = 'SD';
                if ($("#chk_hd").prop("checked")) { hdtext='HD';}
                $("#vlink").text("Link "+hdtext);
                //window.AppInventor.setWebViewString( first );
            });

        });

    });
</script>

</body>
</html>
