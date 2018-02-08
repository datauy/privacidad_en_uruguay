<?php
$bases = array(
  array(
    "name" => "BCU",
    "url" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/RequestFiltroServlet",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "periodo" => "201612",
                                            "cboPaisDoc" => "UY",
                                            "cboTipoDoc" => "IDE",
                                            "nroDoc" => $dni,
                                            "j_captcha_response" => "", //HERE GOES THE CAPTCHA RESPONSE
                                            "x" => "57",
                                            "y" => "13",
                                            "ORIGEN" => "XDOC",
                                            "CALL" => "OUT",
                                          )
                                      ),
                                  ),
                      ),
    "captchaParamName" => "j_captcha_response",
    "authentication" => array(
                        'protocol' => "http",
                        'method' => 'POST',
                        'params' => array(
                                            "email"=>"tristesparasiempre@gmail.com",
                                            "password"=>"6674",
                                            "x"=>"87",
                                            "y"=>"10",
                                          ),
                        "url" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/RequestLoginServlet",
                      )
  ),

  array(
    "name" => "BPS - Fecha y lugar de cobro",
    "url" => "https://feclugcob.bps.gub.uy/FechaLugarCobro/ConsultaFechaLugarCobro.aspx",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'POST',
                        'content' => http_build_query(
                                      array(
                                        "__LASTFOCUS"=>"",
                                        "__EVENTTARGET"=>"",
                                        "__EVENTARGUMENT"=>"",
                                        "__VIEWSTATE"=>"",
                                        "__VIEWSTATEGENERATOR"=>"",
                                        "__EVENTVALIDATION"=>"",
                                        "txtCedula"=>$dni,
                                        "VerificacionTextBox"=>"",
                                        "bConsulta"=>"Consultar",
                                          )
                                      ),
                                  ),
                      ),
    "params" =>       array(
                        "__LASTFOCUS"=>"",
                        "__EVENTTARGET"=>"",
                        "__EVENTARGUMENT"=>"",
                        "__VIEWSTATE"=>"",
                        "__VIEWSTATEGENERATOR"=>"",
                        "__EVENTVALIDATION"=>"",
                        "txtCedula"=>$dni,
                        "VerificacionTextBox"=>"",
                        "bConsulta"=>"Consultar",
                      ),
    "forceCaptcha" => true,
    "preCaptchaURL" => "https://feclugcob.bps.gub.uy/FechaLugarCobro/ConsultaFechaLugarCobro.aspx",
    "preCaptchaHeaders" => array(
      "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
      "Accept-Encoding:gzip, deflate, sdch",
      "Accept-Language:es-419,es;q=0.8,en-GB;q=0.6,en;q=0.4,pt-BR;q=0.2,pt;q=0.2",
      "Cache-Control:no-cache",
      "Connection:keep-alive",
      "Cookie:rxVisitor=1484005971588KGQN6QG8E9PH7UTKI59AQJP0TCD070MR; ipsessiondefault=3E46E98C5FB8502AC1E4DD84D941898F; _ga=GA1.3.1978959641.1484005972; _gat_UA-19573811-1=1; dtPC=-; dtLatC=3; dtCookie=076A962AC5C3704C0883C04C5E243C60|UG9ydGFsSW5ub3ZhfDE; dtSa=true%7CS%7C-1%7CPage%3A%20fecha-y-lugar-de-cobro.html%7C-%7C1489692796411%7C492792505_672%7Chttp%3A%2F%2Fwww.bps.gub.uy%2F8771%2Ffecha-y-lugar-de-cobro.html%7CFecha%20y%20lugar%20de%20cobro%7C1489692797304",
      "Host:www.bps.gub.uy",
      "Pragma:no-cache",
      "Upgrade-Insecure-Requests:1",
      "User-Agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36"
    ),
    "preCaptchaMethod" => "GET",
    "preCaptchaParms" => "null",
    "captchaParamName" => "VerificacionTextBox",
    "captchaValidationParam" => "__EVENTVALIDATION",
    "captchaImgUrlWithoutParm" => "CaptchaImage.axd",
    "captchaUrlPrefix" => "https://feclugcob.bps.gub.uy/FechaLugarCobro/",

  ),

  /*array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - agronomia",
    "url" => "http://www2.bedelias.edu.uy/agronomia/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - agronomia",
    "url" => "http://www1.bedelias.edu.uy/agronomia/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - arquitectura",
    "url" => "http://www2.bedelias.edu.uy/arquitectura/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - arquitectura",
    "url" => "http://www1.bedelias.edu.uy/arquitectura/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - humanidades",
    "url" => "http://www2.bedelias.edu.uy/humanidades/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - humanidades",
    "url" => "http://www1.bedelias.edu.uy/humanidades/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - enba",
    "url" => "http://www2.bedelias.edu.uy/enba/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - enba",
    "url" => "http://www1.bedelias.edu.uy/enba/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
      "name" => "UdelaR (bedelías) - Inscripciones actuales - cenurnoroeste",
      "url" => "http://www2.bedelias.edu.uy/cenurnoroeste/muestra_ic.impr_ie",
      "requestObject" => array(
                        'http' => array(
                          'method' => 'GET',
                          'content' => http_build_query(
                                        array(
                                              "p_estci"=>$dni_number,
                                              "p_digverif"=>$dni_veryfier_digit,
                                            )
                                        ),
                                    ),
                        ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - cenurnoroeste",
    "url" => "http://www1.bedelias.edu.uy/cenurnoroeste/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - ciencias",
    "url" => "http://www2.bedelias.edu.uy/ciencias/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - ciencias",
    "url" => "http://www1.bedelias.edu.uy/ciencias/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - ccee",
    "url" => "http://www2.bedelias.edu.uy/ccee/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - ccee",
    "url" => "http://www1.bedelias.edu.uy/ccee/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - fcs",
    "url" => "http://www2.bedelias.edu.uy/fcs/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - fcs",
    "url" => "http://www1.bedelias.edu.uy/fcs/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - inte",
    "url" => "http://www2.bedelias.edu.uy/inte/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - inte",
    "url" => "http://www1.bedelias.edu.uy/inte/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Inscripciones actuales - psicologia",
    "url" => "http://www3.bedelias.edu.uy/psicologia/muestra_ic.impr_ie",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                          )
                                      ),
                                  ),
                      ),
  ),

  array(
    "name" => "UdelaR (bedelías) - Historial de inscripciones - psicologia",
    "url" => "http://www3.bedelias.edu.uy/psicologia/control_ic.impr_ic",
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "p_estci"=>$dni_number,
                                            "p_digverif"=>$dni_veryfier_digit,
                                            "p_control"=>"",
                                          )
                                      ),
                                  ),
                      ),
  ),*/
);
 ?>
