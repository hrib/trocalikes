<?php
session_start(); 
set_time_limit(100);
ini_set('max_execution_time', 100);

$Insta_username_antiblock = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw_antiblock = getenv('INSTA_PSW_LONDONFORHER');


$aleatorio = mt_rand(1, 5);
//$aleatorio = 4;
if($aleatorio <= 1){
$Insta_username = getenv('INSTA_USR_LONDONFORHER');
$Insta_passw = getenv('INSTA_PSW_LONDONFORHER');
//$originaluserid = 2071958799; //manda..  carro
$originaluserid = 2880433911; // Sylvia Edem Emechete ™ @sylviaemechete
}else if($aleatorio <= 2){
$Insta_username = getenv('INSTA_USR_2');
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 1443400890; // fashionzine
}else if($aleatorio <= 3){
$Insta_username = getenv('INSTA_USR_3');
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 43175003; // @louisewawrzynska  
}else if($aleatorio <= 4){
$Insta_username = getenv('INSTA_USR_4');
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 3426972852; // @sirmasterful  
//$originaluserid = 3674749893; // @1lifeforyou  
}else if($aleatorio <= 5){
$Insta_username = 'mattz.london';
$Insta_passw = getenv('INSTA_PSW_2');
$originaluserid = 22183904; // @matthewzorpas  
}


require_once('/app/Instagram/src/Instagram.php');
$i = new Instagram($Insta_username_antiblock, $Insta_passw_antiblock, $debug = false);
    try {
        $i->login();
    } catch (InstagramException $e) {
        echo $e->getMessage();
        exit();
    }
    
    try {
        $ret_originalfeed  = $i->getUserFeed($originaluserid);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

$i = new Instagram($Insta_username, $Insta_passw, $debug = false);
    try {
        $i->login();
    } catch (InstagramException $e) {
        echo $e->getMessage();
        exit();
    }

    try {
        $ret_myfeed = $i->getSelfUserFeed();
    } catch (Exception $e) {
        echo $e->getMessage();
    }



    $mypost = PegaPosts($ret_myfeed);

    $originalpost = PegaPosts($ret_originalfeed);
        $texto =  $originalpost[0]; 
        $texto = str_replace("@","#", $texto);
        $tipo = $originalpost[1];
        $media_url = $originalpost[2];
        $mediaId =  $originalpost[3];

    $chave = substr($mediaId, 10 , 4);
    $usedtags = substr_count($texto , '#');
    echo '<br><br> tags used on texto = ' . $usedtags;
    if($usedtags < 30){
        $texto = $texto . ' #' . $chave;
        $usedtags = $usedtags + 1;
    }else{
        $texto = $texto . ' !' . $chave;
    }
            
    //$mediaId = '1350642061510837027_1443400890';
    if($texto == $mypost[0]){exit;}


    //$string = 'max_id=17854332247077403';
    //$string = '';
    try {
        //$ret_mediacomments  = $i->getMediaComments($mediaId);
        //$ret_mediacomments = $i->getMediaCommentsPagination($mediaId, $string);
        $helper = ''; //$ret_mediacomments["next_max_id"];
        do {
            if (!is_null($helper)) {
                $ret_mediacomments = $i->getMediaCommentsPagination($mediaId, 'max_id=' . $helper);
                $helper = $ret_mediacomments["next_max_id"];
            } 
        } while (!is_null($helper));
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    //echo '<br><br> next page id = ' . $ret_mediacomments["next_max_id"] . '<br><br> ';
    var_dump($ret_mediacomments);

    $extratagsarray = array('#london', '#like', '#love', '#sky', '#life', '#party', '#men', '#girls', '#style', '#happy', '#fashion', '#attitude');
    shuffle($extratagsarray);
    
    $y = 0;
    while($y < count($extratagsarray)) {
        $extratags = $extratags . ' ' . $extratagsarray[$y];
        $y++;
    } 
    echo '<br><br> extra tags = ' . $extratags . ' | count = ' . count($extratagsarray) . '<br>';

    $TOPcomment = $ret_mediacomments["comments"][0]["text"] . ' ' . $ret_mediacomments["comments"][1]["text"] . ' ' . $ret_mediacomments["comments"][2]["text"] . ' ' . $extratags;
    preg_match_all("/(#\w+)/", $TOPcomment, $matches);
    //$meus_comments = $matches[0][0] . ' ' . $matches[0][1] . ' ' . $matches[0][2] . ' ' . $matches[0][3] . ' ' . $matches[0][4] . ' ' . $matches[0][5] . ' ' . $matches[0][6] . ' ' . $matches[0][7] . ' ' . $matches[0][8] . ' ' . $matches[0][9] . ' ' . $matches[0][10] . ' ' . $matches[0][11] . ' ' . $matches[0][12] . ' ' . $matches[0][13] . ' ' . $matches[0][14] . ' ' . $matches[0][15] . ' ' . $matches[0][16] . ' ' . $matches[0][17] . ' ' . $matches[0][18] . ' ' . $matches[0][19] . ' ' . $matches[0][20] ;



    $x = 0;
    while($x <= (29 - $usedtags)) {
        if(!is_null($matches[0][$x])){
            $meus_comments = $meus_comments . ' ' . $matches[0][$x];
        }
        $x++;
    } 
    
    //$meus_comments = $matches[0][0] . ' ' . $matches[0][1] . ' ' . $matches[0][2] . ' ' . $matches[0][3] . ' ' . $matches[0][4] . ' ' . $matches[0][5] . ' ' . $matches[0][6] . ' ' . $matches[0][7] . ' ' . $matches[0][8] . ' ' . $matches[0][9] . ' ' . $matches[0][10] ;
        
    echo '<br><br> Top comment = ' . $TOPcomment . '<br>';
    echo '<br><br> Meus comments = ' . $meus_comments . '<br>';

    if($tipo == 1){
      echo '<br>JPG<br>';
      $media = 'media' . mt_rand(1,999) * mt_rand(1,999) . '.jpg';
      file_put_contents($media, file_get_contents($media_url));
        
            try {
                $ret_upload = $i->uploadPhoto($media, $texto);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

      //require_once('/app/Instagram/uploadPhoto.php');
      //$ret_upload = Instagram_UploadPhoto($Insta_username, $Insta_passw, $media, $texto);
    }else{
      echo '<br>MP4<br>';
      $media = 'media' . mt_rand(1,999) * mt_rand(1,999) . '.mp4';
      file_put_contents($media, file_get_contents($media_url));
      $resizemedia = 'resize'.$media;
      shell_exec('/app/vendor/ffmpeg/ffmpeg -i '.$media.' -vf "scale=iw*min(640/iw\,620/ih):ih*min(640/iw\,620/ih),pad=640:620:(640-iw)/2:(620-ih)/2" '.$resizemedia);
      echo $resizemedia;
        
            try {
                $ret_upload = $i->uploadVideo($resizemedia, $texto);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
        
        
      //require_once('/app/Instagram/uploadVideo.php');
      //$ret_upload = Instagram_UploadVideo($Insta_username, $Insta_passw, $resizemedia, $texto);
    }
    echo '<br>retorno = ' . var_dump($ret_upload) . '<br>';
    $mediaId_posted = $ret_upload['media']['id'];
    echo '<br>mediaid = ' . $mediaId_posted . '<br>';
    
    if(!is_null($meus_comments)){
        try {
            $comenta = $i->comment($mediaId_posted, $meus_comments);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        //$comenta = $i->comment($mediaId_posted, $meus_comments);
        var_dump($comenta);
    }
 

function PegaPosts($feed){
    //$resjson = json_decode($feed);
    //var_dump($resjson);    
    echo '<br>';
    echo '<table border="1">';
    foreach($feed["items"] as $media){
        echo '<tr>';
        echo '<td>'. $media["caption"]["text"] .'</td>';
        echo '<td>'. $media["id"] .'</td>';
        echo '<td>'. $media["media_type"] .'</td>';
        if($media["media_type"]  == 1){
          $media_url = $media["image_versions2"]["candidates"][0]["url"];
        }else{
          $media_url = $media["video_versions"][0]["url"];
        }
        echo '<td>'. $media_url .'</td>';
        echo '<td><img src="'.$media_url.'"></td>';
        echo '</tr>';

        $media_text = $media["caption"]["text"];
        $media_tipo = $media["media_type"];
        $media_id = $media["id"];
        
        $mediadata = [$media_text, $media_tipo, $media_url, $media_id];
        break; //pega so TOP post
    }
    echo '</table>';
    return $mediadata;
}

require_once('ComentaByTag.php');

exit;



?>
