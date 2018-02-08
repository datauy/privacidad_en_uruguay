<?php
set_time_limit(0);
$f = fopen('/tmp/log.txt', 'w');
include_once 'search_data.php';
$i = 0;
while ( $i <= 10000 ){
  $verif = 0;
  $ci = rand(999999,4999999);
  $magic = array(2,9,8,7,6,3,4);
  $ci_arr = str_split($ci);
  foreach ($ci_arr as $key => $value) {
    $verif += ($value * $magic[$key])%10;
  }
  if ($verif && $verif != 0)
    $verif = 10 - $verif%10;
  $dni = $ci.$verif;
  //$dni = 43357684;
  include_once "../conf/bases.php";
  $data = json_decode(searchByDNI($dni,$bases));
  print "\n".$ci."-".$verif;
  //print_r($data);
  if ( $data['0']->requestSuccessfull == 1 ){
    print ',1';
  }
  else {
    print ",0";
  }
  print ",".$data[0]->status;
  sleep(1);
  $i++;
}
 ?>
