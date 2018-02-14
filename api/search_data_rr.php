<?php
$dni = $_GET["cedula"];
$base_index = $_GET["base"];
$max_request = $_GET["max"];
include_once "../conf/bases.php";

searchByDNI($dni,$base_index,0,$max_request,$bases);

function searchByDNI($dni,$base_index,$request_number,$max_request,$bases){
  include_once '../lib/simple_html_dom/simple_html_dom.php';
  $captchedBases = array();
  $base = $bases[$base_index];
  if(isset($base["forceCaptcha"])){
    $base = requestAndScrapBase($base,true,false,$base["preCaptchaURL"],$base["preCaptchaMethod"],"");
    //REQUIERE CAPTCHA
    $captchaSource = null;
    foreach ($base["htmlElements"]["img"] as $imgKey => $imgArray){
      if (strpos($imgArray["src"], $base["captchaImgUrlWithoutParm"]) !== false) {
          $captchaSource = $imgArray["src"];
      }
    }
    if($captchaSource){
      $captchaURL = $base["captchaUrlPrefix"].$captchaSource;
      grab_image($captchaURL,"/home/datauy/vigilanciaenuruguay/tempCaptchas/captchaTemp.jpg",$base);
      $captchaResolved = null;
      $captchaResolved = shell_exec('/home/datauy/vigilanciaenuruguay/parseCaptcha.sh');
      $captchaResolved = strtolower(clean($captchaResolved));
      //print_r("CAPTCHA: ".$captchaResolved);
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
        $base = requestAndScrapBase($base,false,true,null,null,$base["params"]);
      }
    }
  }else{
    $base = requestAndScrapBase($base,true,true);
  }
  $formatedBaseOutput = formatOutput($base);
  $jsonOutput = json_encode($formatedBaseOutput);
  if($formatedBaseOutput["requestSuccessfull"]==true){
    print($jsonOutput);
  }else{
    $request_number += 1;
    if($request_number<$max_request){
      searchByDNI($dni,$base_index,$request_number,$max_request,$bases);
    }else{
      print($jsonOutput);
    }
  }

}

function requestAndScrapBase(&$base,$init=true,$close=true,$url=null,$method=null,$parms=null){
  $html = getRequestHTML($base,$init,$close,$url,$method,$parms);
  $htmlElements = array();
  $htmlElements = parse_html($html,$htmlElements,false);
  $base["htmlElements"] = $htmlElements;
  return $base;
}

function getRequestHTML(&$base,$init=true,$close=true,$url=null,$method=null,$parms=null){
  $html = null;
  $htmlString = null;
  if(isset($base["authenticationComplete"])){
    $htmlString = requestHTMLAuthenticationComplete($base,true,true);
    $html = str_get_html($htmlString);
  }else if(isset($base["authentication"])){
    $htmlString = requestHTMLWithAuthentication($base,$init,$close,$url,$method,$parms);
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

function grab_image($url,$saveto,&$base){
    if(isset($base["curlChannel"])){
      $ch = $base["curlChannel"];
      $ch = curl_init();
    }else{
      $ch = curl_init();
    }
    $cookie_file="/home/datauy/vigilanciaenuruguay/tempCookies/cookie.txt";
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
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}

function formatOutput($base){
  $output = "";
  $requestSuccessfull = false;
  $status = "RequestFail";
  $html = "<fieldset><p>Según ".$base["long_name"].": </p>";
  $html .= "<table><tbody>";
  //print_r($base["html_answer"]);
  if (strpos($base["html_answer"], $base["document_not_found_txt"]) !== false) {
    //Funcionó la consulta, no existe el documento en la base
    $requestSuccessfull = true;
    $html .= "<tr><td>".$base["document_not_found_txt"]."</td></tr>";
    $status = "DocumentNotFoundInBase";
  }else if (strpos($base["html_answer"], $base["limit_reached_txt"]) !== false) {
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
  $html .= "</tbody></table>";
  $html .= "</fieldset>";
  $output = array(
              "html" => $html,
              "requestSuccessfull" => $requestSuccessfull,
              "status" => $status
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
  $cookie_file = "/home/datauy/vigilanciaenuruguay/tempCookies/cookie.txt";
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

function requestHTMLWithAuthentication(&$base, $init = true, $close = true, $url=null,$method=null,$parms=null){
  $html = null;
  $cookie_file = "/home/datauy/vigilanciaenuruguay/tempCookies/cookie.txt";
  unlink($cookie_file);
  global $ch;
  if($init==true){
      $ch = curl_init();
  }
  if($base["authentication"]["method"]=='POST'){
    curl_setopt($ch, CURLOPT_URL, $base["authentication"]["url"] );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($base["authentication"]["params"]));
  }else{
    curl_setopt($ch, CURLOPT_URL, $base["authentication"]["url"]."?".http_build_query($base["authentication"]["params"]) );
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
    $CookieContent = file_get_contents("/home/datauy/vigilanciaenuruguay/tempCookies/cookie.txt");
    $cookieArray = explode("JSESSIONID",$CookieContent);
    $JSESSIONID = trim($cookieArray[1]);
    $base["JSESSIONID"]=$JSESSIONID;
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
  $cookie_file = "/home/datauy/vigilanciaenuruguay/tempCookies/cookie.txt";
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
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
  curl_setopt($ch, CURLOPT_REFERER, $request_url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  //$f = fopen('/tmp/log.txt', 'w'); // file to write request header for debug purpose
  //curl_setopt($ch, CURLOPT_STDERR, $f);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
  'Accept-Encoding:gzip, deflate, br',
  'Accept-Language:es-419,es;q=0.8,en-GB;q=0.6,en;q=0.4,pt-BR;q=0.2,pt;q=0.2',
  'Cache-Control:no-cache',
  'Connection:keep-alive',
  'Content-Type:application/x-www-form-urlencoded',
  'Origin:https://feclugcob.bps.gub.uy',
  'Pragma:no-cache',
  'Upgrade-Insecure-Requests:1'
));
  //curl_setopt($ch, CURLOPT_HEADER, false);

  $html = curl_exec($ch); //Hago el request con la misma cookie

  //print_r($html);

  if($close==true){
    curl_close($ch);
  }/*else{
    $base["curlChannel"] = $ch;
  }*/
  return $html;
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
