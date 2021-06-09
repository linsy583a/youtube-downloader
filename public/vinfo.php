<?php

require('../vendor/autoload.php');

$url = isset($_GET['url']) ? $_GET['url'] : null;
$hd = isset($_GET['hd']) ? $_GET['hd'] : null;
$allFormats = isset($_GET['all']) ? $_GET['all'] : null;
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
    if (!$allFormats) {
    $best = (!$hd) ? $links->getFirstCombinedFormat() : $links->getFirstCombinedFormat2();
    
    if ($best) {
        send_json([
            'links' => [$best->url]
        ]);
        
    } else {
        send_json(['error' => 'No links found']);
    } } else {
        $best = $links->getAllCombinedFormat();
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
        
        
    }

} catch (\YouTube\Exception\YouTubeException $e) {

    send_json([
        'error' => $e->getMessage()
    ]);
}
