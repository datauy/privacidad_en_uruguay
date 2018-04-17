<?php
$dni = $argv[1];//$_GET["cedula"];
$base_index = 0;//$_GET["base"];
$max_request = 10;//$_GET["max"];
include_once "../conf/bases.php";

searchByDNI($dni,$base_index,0,$max_request,$bases, 0);

function searchByDNI($dni,$base_index,$request_number,$max_request,$bases,$user_index){
  include_once '../lib/simple_html_dom/simple_html_dom.php';
  $captchedBases = array();
  $base = $bases[$base_index];
  $memcache = new Memcache;
  $memcache->connect('localhost', 11211) or die ("Could not connect");
  $userAvailable = false;
  $allUsersUnavailable = false;
  while ($userAvailable == false && $allUsersUnavailable == false) {
    $user_id_key = "base_".$base_index."user_".$user_index;
    $unavailable_user_id = $memcache->get($user_id_key);
    if($unavailable_user_id==false){
      //Esta disponible ese usuario
      $userAvailable = true;
    }else{
      //El usuario ya llegó al límite, pruebo con otro
      $user_index += 1;
      if($user_index == count($base["authentication"]["params"])){
        //Ya llegué al último usuario, salgo del loop y devuelvo que no hay usuarios disponibles.
        $allUsersUnavailable = true;
      }
    }
  }
  if($allUsersUnavailable==true){
    $output = array(
            "html" => "TODOS LOS USUARIOS DISPONIBLES PARA ESA BASE LLEGARON AL LIMITE",
            "requestSuccessfull" => true,
            "status" => "allUsersLimitReached",
            "countOfRequests" => $request_number
          );
    $memcache->set($dni, $output, 0, 900);
    return;
  }
  if(isset($base["forceCaptcha"])){
    $base = requestAndScrapBase($base,true,false,$base["preCaptchaURL"],$base["preCaptchaMethod"],"",$user_index);
    //REQUIERE CAPTCHA
    $captchaSource = null;
    foreach ($base["htmlElements"]["img"] as $imgKey => $imgArray){
      if (strpos($imgArray["src"], $base["captchaImgUrlWithoutParm"]) !== false) {
          $captchaSource = $imgArray["src"];
      }
    }
    if($captchaSource){
      $captchaURL = $base["captchaUrlPrefix"].$captchaSource;
      //Get path for concurrency
      $img_path = "/home/datauy/vigilanciaenuruguay/tempCaptchas/";
      $base["captchaImageUrl"] = grab_image($captchaURL,$img_path,$base);
      $captchaResolved = null;
      $captchaResolved = shell_exec('tesseract '.$base["captchaImageUrl"].' stdout -psm 7 -l eng');
      $captchaResolved = strtolower(clean($captchaResolved));
      print_r("CAPTCHA: ".$base["captchaImageUrl"].' --> '.$captchaResolved);
      $base["captchaResolvedValue"] = $captchaResolved;
      $base["params"][$base["captchaParamName"]] = $captchaResolved;
      if(isset($captchaResolved)){
        $base["requestObject"] = array( 'http' => array(
                              'method' => 'GET',
                              'content' => http_build_query($base["params"]),
                                )
                    );
        unset($base["forceCaptcha"]);
        array_push($captchedBases,$base);
        //print_r($base);
        $base["authenticationComplete"] = true;
        $base = requestAndScrapBase($base,false,true,null,null,$base["params"],$user_index);
        print "\nTermina CAPTCHA Request and Scrap\n";
      }
      print "\nTermina CAPTCHA Source\n";
    }
  }else{
    $base = requestAndScrapBase($base,true,true);
  }
  $formatedBaseOutput = formatOutput($base,$request_number);
  print "\n";
  print_r($formatedBaseOutput);
  print "\n\n";
  if($formatedBaseOutput["requestSuccessfull"]==true){
    if($formatedBaseOutput["status"]=="BaseLimitReached"){
      $memcache->set($user_id_key, "unavailable", 0, 4000);
      searchByDNI($dni,$base_index,$request_number,$max_request,$bases,$user_index);
    }else{
      $memcache->set($dni, $formatedBaseOutput, 0, 900);
    }
  }else{
    $request_number += 1;
    if($request_number<$max_request){
      searchByDNI($dni,$base_index,$request_number,$max_request,$bases,$user_index);
    }else{
      $memcache->set($dni, $formatedBaseOutput, 0, 900);
    }
  }
  //Borro el archivo con la cookie de este request
  if (file_exists($base["cookie_file"])){
    unlink($base["cookie_file"]);
  }
}

function requestAndScrapBase(&$base,$init=true,$close=true,$url=null,$method=null,$parms=null,$user_index=0){
  $html = getRequestHTML($base,$init,$close,$url,$method,$parms,$user_index);
  $htmlElements = array();
  $htmlElements = parse_html($html,$htmlElements,false);
  $htmlElements = parse_specialElements($base,$html,$htmlElements,false);
  $base["htmlElements"] = $htmlElements;
  return $base;
}

function getRequestHTML(&$base,$init=true,$close=true,$url=null,$method=null,$parms=null,$user_index=0){
  $html = null;
  $htmlString = null;
  if(isset($base["authenticationComplete"])){
    $htmlString = requestHTMLAuthenticationComplete($base,true,true);
    if($base["response_charset"]=="ISO-8859-1"){
      $htmlString = utf8_encode($htmlString);
    }
    $html = str_get_html($htmlString);
  }else if(isset($base["authentication"])){
    $htmlString = requestHTMLWithAuthentication($base,$init,$close,$url,$method,$parms,$user_index);
    $html = str_get_html($htmlString);
  }else{
    //$html = requestHTMLWithoutAuthentication($base);
    $htmlString = requestHTMLWithoutAuthenticationCurl($base,$init,$close,$url,$method,$parms);
    $html = str_get_html($htmlString);
  }
  $base["html_answer"] = $htmlString;
  return $html;
}

function clean($string) {
  $string = str_replace(' ', '', $string); // Remove all spaces.
  $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  return $string;
}

function cleanStrangeChars($string){
  $string = str_replace('&nbsp;', ' ', $string);
  return $string;
}

function grab_image($url,$savetoPath,&$base){
    if(isset($base["curlChannel"])){
      $ch = $base["curlChannel"];
      $ch = curl_init();
    }else{
      $ch = curl_init();
    }
    $cookie_file = $base["cookie_file"];
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt ($ch, CURLOPT_REFERER, $url);
    //curl_setopt($ch, CURLOPT_STDERR, $f);
    $raw=curl_exec($ch);
    /*if(!isset($base["curlChannel"])){
      curl_close ($ch);
    }else{
      $ch = $base["curlChannel"];*/
      curl_close ($ch);
//    }
    // Hacer while por concurrencia
    $foundValidFileName = false;
    $filename="";
    while ($foundValidFileName!=true) {
     $filename = uniqid('captcha', true) . '.jpg';
     if (!file_exists($savetoPath . $filename)){
       $foundValidFileName = true;
     }
    }
    $fullFileURL = $savetoPath . $filename;
    $fp = fopen($fullFileURL,'x');
    fwrite($fp, $raw);
    fclose($fp);
    return $fullFileURL;
}

function formatOutput($base,$request_number){
  $output = "";
  $requestSuccessfull = false;
  $status = "RequestFail";
  $special_data = array();
  $html = "<fieldset><p>Según ".$base["long_name"].": </p>";
  $html .= "<table><tbody>";
  //print_r($base["html_answer"]);
  if (strpos($base["html_answer"], $base["document_not_found_txt"]) !== false) {
    //Funcionó la consulta, no existe el documento en la base
    $requestSuccessfull = true;
    $html .= "<tr><td>".$base["document_not_found_txt"]."</td></tr>";
    $status = "DocumentNotFoundInBase";
  }else if (strpos($base["html_answer"], $base["no_data_for_period_txt"]) !== false) {
    //Funcionó la consulta, pero no existen datos para ese período
    $requestSuccessfull = true;
    $html .= "<tr><td>".$base["no_data_for_period_txt"]."</td></tr>";
    $status = "NoDataForSelectedPeriod";
  }else if (strpos($base["html_answer"], $base["limit_reached_txt"]) !== false) {
    //Hacer esto está diferente del original que pregunta por limit_reached_txt
    //Funcionó la consulta, pero el servidor nos bloqueó por límite de consultas
    $requestSuccessfull = true;
    $html .= "<tr><td>".$base["limit_reached_txt"]."</td></tr>";
    $status = "BaseLimitReached";
  }else if (strpos($base["html_answer"], $base["captcha_failed_txt"]) !== false) {
    //Falló el captcha
    $requestSuccessfull = false;
    $html .= "<tr><td>".$base["captcha_failed_txt"]."</td></tr>";
    $status = "CaptchaFailed";
  }
  foreach ($base["htmlElements"] as $tag => $tagItems){
    if($tag != "br" && $tag != "script" && $tag != "noscript" && $tag != "meta"){
      foreach ($tagItems as $item){
        if($tag=="special_data"){
          $special_item = $item["value"];
          if(isset($item["tipo"])){
            $special_item["tipo"] = $item["tipo"];
          }
          array_push($special_data,$special_item);
        }else{
          if ( isset($item["id"]) ){
            $id = $item["id"];
            $idsWanted = $base["interesting_data"]["ids"];
            if(in_array($id,$idsWanted)){
              $requestSuccessfull = true;
              $status = "DataRetrieved";
              if(isset($item["plaintext"])&&$item["plaintext"]!=""){
                $html .= "<tr><td>".$item["plaintext"]."</td></tr>";
              }
              if(isset($item["htmltext"])&&$item["htmltext"]!=""){
                  $html .= "<tr><td>".$item["htmltext"]."</td></tr>";
              }
              if($tag=="img"&&$item["src"]!=""){
                $html .= "<tr><td>".$item["src"]."</td></tr>";
              }
              if($tag=="hidden"){
                $html .= "<tr><td>".$item["value"]."</td></tr>";
              }
            }
          }
        }
      }
    }
  }
  $html .= "</tbody></table>";
  $html .= "</fieldset>";
  $output = array(
              //"html" => $html,
              "requestSuccessfull" => $requestSuccessfull,
              "status" => $status,
              "countOfRequests" => $request_number+1,
              "special_data" => $special_data
            );
  return $output;
}

function requestHTMLWithoutAuthentication(&$base){
  $html = null;
  if($base["requestObject"]["http"]["method"]=="GET"){
    $html = file_get_html($base["url"]."?".$base["requestObject"]["http"]["content"]);
  }else{
    $request = $base["requestObject"];
    $context = stream_context_create($request);
    $html = file_get_html($base["url"], false, $context);
  }
  return $html;
}

function requestHTMLAuthenticationComplete(&$base, $init = false, $close = true){
  $html = null;
  $cookie_file = $base["cookie_file"];
  $ch;
  if($init==true){
      $ch = curl_init();
  }else{
      $ch = $base["curlChannel"];
  }
  if($base["requestObject"]["http"]["method"]=="POST"){
    curl_setopt($ch, CURLOPT_URL, $base["url"] );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $base["requestObject"]["http"]["content"]);
  }else{
    curl_setopt($ch, CURLOPT_URL, $base["url"]."?".$base["requestObject"]["http"]["content"] );
    curl_setopt($ch, CURLOPT_POST, FALSE);
  }
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);

  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  //print_r("<br/> Consulta final: ".$base["url"]."?".$base["requestObject"]["http"]["content"]);
  //print_r("<br/> JSESSIONID: ".$base["JSESSIONID"]);
  $html = curl_exec($ch); //Hago el request con la misma cookie
  //print_r($html);

  if($close==true){
    curl_close($ch);
  }
  return $html;
}

function requestHTMLWithAuthentication(&$base, $init = true, $close = true, $url=null,$method=null,$parms=null,$user_index=0){
  $html = null;
  $foundValidFileName = false;
  $filename="";
  while (!$foundValidFileName) {
   $filename = uniqid('cookie', true) . '.txt';
   if (!file_exists("/home/datauy/vigilanciaenuruguay/tempCookies/" . $filename)){
     $foundValidFileName = true;
   }
  }
  $cookie_file = "/home/datauy/vigilanciaenuruguay/tempCookies/".$filename;
  $base["cookie_file"] = $cookie_file;
  global $ch;
  if($init==true){
      $ch = curl_init();
  }
  if($base["authentication"]["method"]=='POST'){
    curl_setopt($ch, CURLOPT_URL, $base["authentication"]["url"] );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($base["authentication"]["params"][$user_index]));
  }else{
    curl_setopt($ch, CURLOPT_URL, $base["authentication"]["url"]."?".http_build_query($base["authentication"]["params"][$user_index]) );
    curl_setopt($ch, CURLOPT_POST, FALSE);
  }
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_COOKIE, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
  curl_setopt($ch, CURLOPT_COOKIESESSION, true);
  //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $login_response = curl_exec($ch );  //EJECUTO EL LOGIN y mantengo la cookie
  if($base["forceCaptcha"]==true){
    curl_close($ch);
    $base["curlChannel"] = $ch;
    /*$CookieContent = file_get_contents("/home/datauy/vigilanciaenuruguay/tempCookies/cookie.txt");
    $cookieArray = explode("JSESSIONID",$CookieContent);
    $JSESSIONID = trim($cookieArray[1]);
    $base["JSESSIONID"]=$JSESSIONID;*/
    return $login_response;
  }

  if($base["requestObject"]["http"]["method"]=="POST"){
    curl_setopt($ch, CURLOPT_URL, $base["url"] );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $base["requestObject"]["http"]["content"]);
  }else{
    curl_setopt($ch, CURLOPT_URL, $base["url"]."?".$base["requestObject"]["http"]["content"] );
    curl_setopt($ch, CURLOPT_POST, FALSE);
  }
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
  $html = curl_exec($ch); //Hago el request con la misma cookie
  //print_r($html);

  if($close==true){
    curl_close($ch);
  }/*else{
    $base["curlChannel"] = $ch;
  }*/
  return $html;
}

function requestHTMLWithoutAuthenticationCurl(&$base, $init = true, $close = true, $url = null,$method=null,$parms=null){
  $request_method = $base["requestObject"]["http"]["method"];
  if(isset($method)){
    $request_method = $method;
  }
  $request_url = $base["url"];
  if(isset($url)){
    $request_url = $url;
  }
  $content = $base["requestObject"]["http"]["content"];
  if(isset($parms)){
    $content = $parms;
  }
  //print_r($content);
  $html = null;
  $foundValidFileName = false;
  $filename="";
  while (!$foundValidFileName) {
   $filename = uniqid('cookie', true) . '.txt';
   if (!file_exists("/home/datauy/vigilanciaenuruguay/tempCookies/" . $filename)){
     $foundValidFileName = true;
   }
  }
  $cookie_file = "/home/datauy/vigilanciaenuruguay/tempCookies/".$filename;
  $base["cookie_file"] = $cookie_file;
  global $ch;
  if($init==true){
      $ch = curl_init();
  }
  if($request_method=="POST"){
    curl_setopt($ch, CURLOPT_URL, $request_url );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
  }else{
    curl_setopt($ch, CURLOPT_URL, $request_url."?".$content );
    curl_setopt($ch, CURLOPT_POST, FALSE);
  }
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
  curl_setopt($ch, CURLOPT_REFERER, $request_url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 1);

  $html = curl_exec($ch); //Hago el request con la misma cookie
  if($close==true){
    curl_close($ch);
  }
  return $html;
}

function parse_specialElements(&$base,$html,&$elements,$mustConvertStringToHtmlObject=false){
  if(!isset($elements)){
    $elements = array();
  }
  if($mustConvertStringToHtmlObject){
    $html = str_get_html($html);
  }
  if($html!=false){
    if(isset($base["interesting_data"]["special_data"])){
      if(!isset($elements["special_data"] )){
        $elements["special_data"] = array();
      }
      foreach ($base["interesting_data"]["special_data"] as $key => $value) {
        $element = null;
        if(isset($value["simpleHtmlDom_ParentQuery"])){
          $parentIndex = 0;
          if(isset($value["simpleHtmlDom_ParentIndex"])){
            $parentIndex = $value["simpleHtmlDom_ParentIndex"];
          }
          $parent = $html->find($value["simpleHtmlDom_ParentQuery"])[$parentIndex];
          //try {
            if($parent != null && isset($value["simpleHtmlDom_ChildQuery"]) && $value["simpleHtmlDom_ChildQuery"]!=false){
              $childQuery = $value["simpleHtmlDom_ChildQuery"];
              $childIndex = $value["simpleHtmlDom_ChildIndex"];
              $element = $parent->find($childQuery)[$childIndex];
            }else{
              $element = $parent;
            }
          /*} catch (Exception $e) {
              echo 'Caught exception: ',  $e->getMessage(), "\n";
          } */
        }
        if($element!=null && $element->plaintext!=null && $element->plaintext != ""){
          if(isset($value["groupBy"])){
            $groupName = $value["groupBy"];
            if(!isset($elements["special_data"][$groupName])){
              $elements["special_data"][$groupName] = array();
              $elements["special_data"][$groupName]["keyInsideArray"] = $value["groupBy"];
              $elements["special_data"][$groupName]["value"] = array();
              if(isset($value["groupType"])){
                $elements["special_data"][$groupName]["tipo"] = $value["groupType"];
              }
            }
            /*$item = array(
              $value["keyInsideArray"] => trim(cleanStrangeChars($element->plaintext))
            );
            if(isset($value["html"])&&$value["html"]==true){
              $item[$value["keyInsideArray"]] = trim(preg_replace('/\t+/', '', $element->innertext));
            }
            array_push($elements["special_data"][$groupName]["value"],$item);*/
            $elements["special_data"][$groupName]["value"][$value["keyInsideArray"]]=trim(cleanStrangeChars($element->plaintext));
            if(isset($value["html"])&&$value["html"]==true){
              $elements["special_data"][$groupName]["value"][$value["keyInsideArray"]] = trim(preg_replace('/\t+/', '', $element->innertext));
            }
          }else{
            $item = array(
              "tag" => "special_data",
              "keyInsideArray" => $value["keyInsideArray"],
              "value" => trim(cleanStrangeChars($element->plaintext))
            );
            if(isset($value["html"])&&$value["html"]==true){
              $item["value"] = trim(preg_replace('/\t+/', '', $element->innertext));
            }
            array_push($elements["special_data"],$item);
          }
        }
      }
    }
  }
  return $elements;
}

function parse_html($html,&$elements,$mustConvertStringToHtmlObject=false){
  if(!isset($elements)){
    $elements = array();
  }
  if($mustConvertStringToHtmlObject){
    $html = str_get_html($html);
  }
  // Fetch child of the current element (one by one)
  try {
    if($html!=false){
      foreach ($html->find('*') as $child) {
        if(!isset($elements[$child->tag] )){
          $elements[$child->tag] = array();
        }
        $item = parse_element($child);
        array_push($elements[$child->tag],$item);
        if(count($child->children()>0)){
          foreach ($child->children() as $subchild) {
            $elements = parse_html($subchild->outertext,$elements,true);
          }
        }

      }

      $elements["hidden"] = array();
      foreach ($html->find('input[type=hidden]') as $hidden) {
        $item = array();
        $item["value"] = $hidden->value;
        $item["name"] = $hidden->name;
        array_push($elements["hidden"],$item);
      }
    }
  } catch (Exception $e) {
      //echo 'Caught exception: ',  $e->getMessage(), "\n";
  }

  return $elements;
}

function parse_element($element){
  $item = array();
  $item["id"] = $element->id;
  if($element->tag=="img"){
    $item['src']=$element->src;
  }else if($element->tag=="p"){
    $item['plaintext']=$element->plaintext;
  }else if($element->tag=="iframe"){
    $item['src']=$element->src;
  }else if($element->tag=="a"){
    $item['href']=$element->href;
  }else if($element->tag=="td"){
    $item['plaintext']=$element->plaintext;
  }else if($element->tag=="body"){
    $item['plaintext']=$element->plaintext;
  }else if($element->tag=="table"){
    $item['htmltext']=$element->outertext;
    if($element->id=="tabla" || $element->id="tablaXInst0"){
      $item['INTERESTING_DATA'] = true;
    }
  }else {
    $item['plaintext']=$element->plaintext;
  }
  return $item;
}

?>
