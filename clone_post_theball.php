<?php
session_start();
require_once 'src/Facebook/autoload.php';

$mypageid = 'TheBallisonthetable';
$myalbumid = '1509106142644949';
//$pageOriginal = 'mblivre';
$pageOriginal = 'FuteDaDepressao,LibertadoresDaDepressao,RIPfutebolclube,humoresportivonaarea';


$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
$db = new PDO($dsn);
$query = "SELECT id1, id2, id3, id4 FROM dados WHERE id1 = 'theball'";
$result = $db->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$result->closeCursor();

$app_id = $row["id2"];
$app_secret = $row["id3"];
$page_access_token = $row["id4"];

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
//&date_format=U
//$response = $fb->get('/' . $pageOriginal . '?fields=posts{message,link,full_picture,created_time}');
$response = $fb->get('/?ids='. $pageOriginal .'&fields=name,posts.limit(5){message,link,full_picture,created_time}');
$graphNode = $response->getGraphNode();

//echo var_dump($response);
//echo var_dump($graphNode);
//echo var_dump($graphNode['vempraruabrasil.org']);
//echo var_dump($graphNode['mblivre']);
echo '<table border="1" style="font-family:arial; font-size:7px;">';
foreach ($graphNode as $pagina) {
    //foreach ($graphNode['posts'] as $key => $value) {
    foreach ($pagina['posts'] as $key => $value) {
      echo '<tr>';
      echo '<td>' . $key . ':' . $pagina['name'] . '</td>';
      echo '<td>' . $value['message'] . '</td>';
      echo '<td>' . $value['link'] . '</td>';
      echo '<td>' . $value['full_picture'] . '</td>';
      echo '<td>';
      echo '<td>' . var_dump($value['created_time']) . '</td>'; //precisa disso pra funcionar
      $created_timeSTR = $value['created_time']->date;
      $created_time = strtotime($created_timeSTR);  //unix
      echo '<td>' . $key . ':' . $created_timeSTR . '</td>';
      //echo '<br>time' . $key . ':' . $created_time . '<br>';
      $tempo = time();
      $diffunix = $tempo - $created_time;
      echo '<td> diff tempo:' . $diffunix . '</td>';
      if($diffunix < 3600){
        PostClone($fb, $myalbumid, $mypageid, $page_access_token, $value['message'], $value['link'], $value['full_picture']);
      }else{
        echo '<td></td>';
        echo '<td></td>';
        //echo '<td></td>';
        //echo '<td></td>';
      }
      echo '</tr>';
    }
}
echo '</table>';

?>
