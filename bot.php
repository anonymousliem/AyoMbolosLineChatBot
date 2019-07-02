<?php
/*
CREATED BY ANONYMOUSLIEM
github.com/anonymousliem
instagram.com/anonymousliem
*/
require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$con = mysqli_connect("127.0.0.1", "my_user", "my_password", "my_db");

$channelAccessToken = 'channelAccessTokenAnda'; 
$channelSecret = 'channelSecretAnda'; 

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
 
$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId    = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp  = $client->parseEvents()[0]['timestamp'];
$type       = $client->parseEvents()[0]['type'];
$message    = $client->parseEvents()[0]['message'];
$messageid  = $client->parseEvents()[0]['message']['id'];
$profil = $client->profil($userId);
$profileName    = $profil->displayName;
$profileURL     = $profil->pictureUrl;
$profielStatus  = $profil->statusMessage;
$profil = $client->profil($userId);
 
$pesan_datang = explode(" ", $message['text']);
$menarik=$pesan_datang[2];
$dorong=$pesan_datang[1];

$commandke1 = $pesan_datang[1];
$commandke0 = $pesan_datang[0];
$commandke2 = $pesan_datang[2];
$commandke3 = $pesan_datang[3];
$commandke4 = $pesan_datang[4];

$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}
 
$wilson = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $wilson .= ' ';
        $wilson .= $pesan_datang[$i];
    }
}

if ($type == 'join') {  
    
    mysqli_query($con, "INSERT INTO anjay (groupId,userId) VALUES ('$groupId','$userId')");  
    $responses['replyToken']= $replyToken;
    $responses['messages']['0']['type'] = "text";
 $responses['messages']['0']['text'] = "Terima kasih telah mengundang saya ke grup ini :V";
 $result = json_encode($responses);
 $result_json = json_decode($result, TRUE);
 $client->replyMessage($result_json);
 
}

$cekuser = mysqli_query($con, "SELECT userid FROM user WHERE userid = '$userId'");
if($command == '/daftar'){
     if(mysqli_num_rows($cekuser) <> $userId){
         $responses['replyToken']= "$replyToken";
         $responses['messages'][0]['type'] = "text";
         $responses['messages'][0]['text'] = "data sudah ada, tidak perlu mendaftar lagi. Sekarang kamu bisa gunakan fitur yang ada di bot ini";
         $result = json_encode($responses);
         $result_json=json_decode($result,TRUE);
         $client->replyMessage($result_json); 
    }
     else{
            $simpandata = mysqli_query($con, "INSERT INTO user (userid,count,matkul)VALUES('$userId','0','zahuhuhoiodiwxznzppp')");
        if($simpandata){
            $responses['replyToken']= "$replyToken";
            $responses['messages'][0]['type'] = "text";
            $responses['messages'][0]['text'] = "data berhasil disimpan. Kamu sudah terdaftar. Kamu bisa gunakan fitur yang ada di bot ini :)";
            $result = json_encode($responses);
            $result_json=json_decode($result,TRUE);
            $client->replyMessage($result_json);    
     }
        else{
           $responses['replyToken']= "$replyToken";
           $responses['messages'][0]['type'] = "text";
           $responses['messages'][0]['text'] = "data gagal di simpan";
           $result = json_encode($responses);
           $result_json=json_decode($result,TRUE);
           $client->replyMessage($result_json); 
      }
    }
}

if($commandke0 == '/mbolos' && $wilson==true){
    $cekuser5 = mysqli_query($con, "SELECT userid FROM user WHERE userid='$userId' ");
         if (mysqli_num_rows($cekuser5)==0) {
             
         $responses['replyToken']= "$replyToken";
         $responses['messages'][0]['type'] = "text";
         $responses['messages'][0]['text'] = "kamu belum terdaftar. silahkan ketik /daftar untuk mendaptar";
         $result = json_encode($responses);
         $result_json=json_decode($result,TRUE);
         $client->replyMessage($result_json); 
       
    } else{
          $balas = array(
                    'replyToken' => $replyToken,
                    'messages' => array(

array (
  'type' => 'template',
  'altText' => 'this is a carousel template',
  'template' => 
  array (
    'type' => 'carousel',
    'actions' => 
    array (
    ),
    'columns' => 
    array (
     
      0 => 
      array (
        'thumbnailImageUrl' => 'https://pusatherbalku.com/wp-content/uploads/2019/07/yok.png',
        'title' => $commandke1. " " .$commandke2 . " " .$commandke3. " " .$commandke4,
        'text' => 'Yang bijak yah kalau mau bolos :)',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'message',
            'label' => 'BOLOS',
            'text' => '/bolos ' .$wilson,
          ),
          1 => 
          array (
            'type' => 'message',
            'label' => 'CEK JUMLAH BOLOS',
            'text' => '/jumlahbolos ' .$wilson,
          ),
           2 => 
          array (
            'type' => 'message',
            'label' => 'RESET',
            'text' => '/reset ' .$wilson,
          ),
        ),
      ),
      
    ),
  ),
)
            )
        );
     
}
    }
    
if ($commandke0 == '/bolos' && $wilson==true){
$cekuser5 = mysqli_query($con, "SELECT userid FROM user WHERE userid='$userId' ");
 if (mysqli_num_rows($cekuser5)==0) {
       $responses['replyToken']= "$replyToken";
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "kamu belum terdaptar. silahkan ketik /daftar untuk mendaftar";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
    
}
else{
mysqli_query($con, "INSERT INTO user (matkul,count,userid) VALUES ('$wilson','1','$userId')");

 $tampildata = mysqli_query($con, "select count(count) from user WHERE userid='$userId' AND matkul='$wilson' GROUP BY userid='$userId'");
 $responses['replyToken']= "$replyToken";
 $hasil = array();
        while($row=mysqli_fetch_row($tampildata)){
            array_push($hasil,$row[0]);
        }
       $hasil = implode ("\n ", $hasil);
        if($hasil == 1 || $hasil == 2){
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "Berhasil. Kamu telah bolos matkul $wilson sebanyak $hasil";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
        }
        if($hasil ==3 ){
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "Berhasil. HATI HATI. KAMU TELAH BOLOS SEBANYAK 3 KALI";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
        }
        if($hasil >= 4 ){
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "Berhasil. Kamu telah bolos sebanyak $hasil kali. dan kamu tidak bisa ikut uas AWOKWOWKOK";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
        }
    }
}

if ($commandke0 == '/reset' && $wilson==true){
$cekuser5 = mysqli_query($con, "SELECT userid FROM user WHERE userid='$userId' ");
 if (mysqli_num_rows($cekuser5)==0) {
       $responses['replyToken']= "$replyToken";
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "kamu belum terdaptar. silahkan ketik /daftar untuk mendaftar";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
    
}
else{
//mysqli_query($con, "INSERT INTO user (matkul,count,userid) VALUES ('$wilson','1','$userId')");

 $tampildata9 = mysqli_query($con, "DELETE FROM user WHERE userid='$userId' AND matkul='$wilson'");
 $responses['replyToken']= "$replyToken";
 $hasil9 = array();
        while($row=mysqli_fetch_row($tampildata9)){
            array_push($hasil9,$row[0]);
        }
       $hasil9 = implode ("\n ", $hasil9);
        if($hasil9 == 0){
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "Berhasil direset. Kamu telah bolos matkul $wilson sebanyak 0";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
        }
    }
}

if(strtolower($command) == "/jumlahbolos"){
    $cekuser5 = mysqli_query($con, "SELECT userid FROM user WHERE userid='$userId' ");
 if (mysqli_num_rows($cekuser5)==0){
         $responses['replyToken']= "$replyToken";
      $responses['messages'][0]['type'] = "text";
      $responses['messages'][0]['text'] = "kamu belum terdaptar. silahkan ketik /daftar untuk mendaftar";
      $result = json_encode($responses);
      $result_json=json_decode($result,TRUE);
      $client->replyMessage($result_json);
 }
 else{ $tampildata2 = mysqli_query($con, "select count(count) from user WHERE userid='$userId' AND matkul='$wilson' GROUP BY userid='$userId' ");
        $hasil2 = array();
        while($row=mysqli_fetch_row($tampildata2)){
            array_push($hasil2,$row[0]);
        }
       $hasil2 = implode ("\n ", $hasil2);
               if($hasil2 == 0){
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'kamu telah bolos pelajaran ' .$wilson .' sebanyak 0' 
                    
                )
            )
        ); 
    }
        if($hasil2 == 1 || $hasil2 == 2){
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'kamu telah bolos pelajaran ' .$wilson .' sebanyak ' . $hasil2
                    
                )
            )
        ); 
    }
    if($hasil2 == 3 ){
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Hati hati. Kamu telah bolos pelajaran ' .$wilson .' sebanyak ' . $hasil2 .' kali'
                    
                )
            )
        ); 
    }
    if($hasil2 >=4){
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'kamu telah bolos pelajaran '.$wilson .' sebanyak ' .$hasil2.' kali. Mampus gak bisa uas awowokwokwowk'
                    
                )
            )
        ); 
    }}

 }

if(strtolower($command) == "/cekuserid"){
        
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $userId
                )
            )
        ); 
    }   


if (isset($balas)) {
    $result = json_encode($balas);
    file_put_contents('./balasan.json', $result);
    $client->replyMessage($balas); 
}


?>
