<?php
session_start(); 

    $hashtagString = str_replace("","#", $matches[0][0]);
    echo '<br><br> hashtag = ' . $hashtagString . '<br><br>';
    try {
        $ret_tags = $i->getHashtagFeed($hashtagString, $maxid = null);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    var_dump($ret_tags);




?>
