<?php
set_time_limit(0);
$f = fopen('/tmp/log.txt', 'w');
//include_once 'search_data.php';
$i = 0;
while ( $i <= 10000 ){
  if ( $i%2 == 0) {
    $server = 'http://vigilancia.development.datauy.org';
  }
  else {
    $server = 'http://vigilancia.management.datauy.org';
  }
  $verif = 0;
  $ci = rand(999999,4999999);
  $magic = array(2,9,8,7,6,3,4);
  $ci_arr = str_split($ci);
  foreach ($ci_arr as $key => $value) {
    $verif += ($value * $magic[$key])%10;
  }
  if ( $verif%10 != 0 )
    $verif = 10 - $verif%10;
  else {
    $verif = 0;
  }
  $dni = $ci.$verif;
  //$dni = 43357684;
//  include_once "../conf/bases.php";
//  $data = json_decode(searchByDNI($dni,$bases));
  $data = json_decode(file_get_contents($server.'/api/search_data_rr.php?base=0&max=3&cedula='.$dni));
  print "\n".$ci."-".$verif;
  //print_r($data);
  if ( is_object($data) ){
    if ( $data->requestSuccessfull == 1 ){
      print ',1';
    }
    else {
      print ",0";
    }
    print ",".$data->countOfRequests;
    print ",".$data->status;
  }
  else {
    print ",0,0,ErrorData";
  }
  print ",".$server;
  sleep(1);
  $i++;
}
 ?>
