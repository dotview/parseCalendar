<?php


function getwebcontent($url){
    $ch = curl_init();
    $timeout = 10;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
    $contents = trim(curl_exec($ch));
    curl_close($ch);
    return  $contents;
}

?>