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
    'template'=> 'Venha trocar likes gratuitamente para BOMBAR sua pagina no Facebook!'
);
//$sendnotification = $facebook->api('/USER_ID/notifications', 'post', $data);



$usuarios = array(1580952695552959, 1861967887462093, 1817264878594647, 1506911062686704, 822725224548484, 10206813550816289, 1869740359960179, 1460453394021295, 282726058864346, 1198054596988388, 1708407246123355, 1861316050788025, 991497887654243, 1818953811754608, 1878777095672416, 734170893416116, 781786731995164, 10150000997172700, 1508980999123609, 10154850458673533, 753170474860265, 299179057205437, 160249627842986, 251999068613285, 1420541791335941, 10155260668708476, 1806612282986782, 1843563459299178, 1213855432057468, 1341729132590626, 126500921252315, 1197616643700505, 625290704332521, 10213061814362559, 1669901229984245, 647536708772436, 1904999149763891, 843377309144539, 327802167638677, 1220964161346045, 1039281162882935, 1125147347589824, 1182256258570537, 153616501844624, 890954337708968, 756372927853900, 1939517142994443, 762933653893224, 1012791748857871, 457495921277488, 10207558009387382, 793270517497324, 192544831272121, 1206941666083783, 1403168923112224, 10212981657840242, 225809401268948, 859978020824852, 956918084451237, 1340495279404075, 10209751398926692, 480583822278983, 1922040611354025, 1710621648963112, 1760920733937193, 1542816382457163, 1413817805370733, 1280059372105568, 1682608185112803, 10209239845133526, 201640413696129, 241385836353840, 761513034010303, 1469703086423323, 1542556649152557, 1429332567147373);
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
