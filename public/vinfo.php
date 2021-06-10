<?php

require('../vendor/autoload.php');

$url = isset($_GET['url']) ? $_GET['url'] : null;
$detail = isset($_GET['detail']) ? $_GET['detail'] : null;
function send_json($data)
{
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

if (!$url) {
    send_json([
        'error' => 'No URL provided!'
    ]);
}

$youtube = new \YouTube\YouTubeDownloader();

try {
    $links = $youtube->getDownloadLinks($url);
    $best = $links->getAllCombinedFormat();
    //$best = (!$hd) ? $links->getFirstCombinedFormat() : $links->getFirstCombinedFormat2();
    
    if ($best) {
            if (!$detail){
                $text = [];
                foreach ($best as $item) {
                    $text[] = $item->url;
                }
                send_json([
                    'links' => $text
                ]);
            } else {
                send_json($best);
            }
        } else {
        send_json(['error' => 'No links found']);      
    }

} catch (\YouTube\Exception\YouTubeException $e) {

    send_json([
        'error' => $e->getMessage()
    ]);
}
