<?php
session_start(); 

require_once(dirname(__FILE__)."/src/Facebook/autoload.php");
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.9',
  ]);
  
  $accessToken = $app_id . '|' . $app_secret;

$data = array(
    'href'=> '?texto=123',
    'access_token'=> $accessToken,
    'template'=> 'Voce ganhou 10 creditos. Venha ganhar mais Likes na sua pagina e ativar seu creditos'
);
//$sendnotification = $facebook->api('/USER_ID/notifications', 'post', $data);



$usuarios = array(1580952695552959, 1220964161346045, 822725224548484, 1280059372105568, 10154850458673533, 1922040611354025, 1817264878594647, 299179057205437, 192544831272121, 457495921277488, 1125147347589824, 1708407246123355, 1213855432057468, 201640413696129, 1843563459299178, 1197616643700505, 1710621648963112, 1012791748857871, 1206941666083783, 1506911062686704, 1861967887462093, 160249627842986, 1413817805370733, 1878777095672416, 480583822278983, 1460453394021295, 10207558009387382, 10206813550816289);
foreach($usuarios as $item) {

    try {  
      //$response = $fb->post('/1580952695552959/notifications?access_token=' . $accessToken .' &href=?retorno=123&template=Voce precisa cadastrar sua pagina para comecar a ganhar likes!', $accessToken);
      $response = $fb->post('/'.$item.'/notifications', $data);

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
     // When Graph returns an error
     echo 'Graph returned an error: ' . $e->getMessage();
     //exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
     // When validation fails or other local issues
     echo 'Facebook SDK returned an error: ' . $e->getMessage();
     //exit;
    }
    $graphNode = $response->getGraphNode();
    echo $item. '<br>';
    print_r($graphNode );
    echo '<br><br><br>';
}

?>
