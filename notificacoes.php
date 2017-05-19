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
    'template'=> 'Seus creditos acabaram. Venha ganhar mais Likes!'
);
//$sendnotification = $facebook->api('/USER_ID/notifications', 'post', $data);

$usuarios = array(1506911062686704, 1708407246123355, 1878777095672416, 10154850458673533, 160249627842986);
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
