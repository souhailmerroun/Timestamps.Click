<?php

if(isset($_POST['submit']))
{
    $timestamps = $_POST['timestamps'];
    $video      = $_POST['video'];
    $lines      = explode("\n", $timestamps);
    $results    = [];

    foreach($lines as $line) {
        $regex = '/([^\s]+) ([^\s]+) (.*)/';
        preg_match($regex, $line, $parts, PREG_OFFSET_CAPTURE, 0);
        
        $start = $parts[1][0];
        $end   = $parts[2][0];
        $title = $parts[3][0];
        
        $temporary = "ffmpeg -ss $start -to $end -i '$video.mp4' '$title.mp4';";
        array_push($results, $temporary);
    }
}