<?php
$bases = array(
  array(
    "interesting_data" => array(
                            "ids" => array("tabla","tablaXInst0","tablaXInst1","tablaXInst2","tablaXInst3","tablaXInst4","tablaXInst5","tablaXInst6","tablaXInst7")
                          ),
    "name" => "BCU",
    "long_name" => "la Central de Riesgo Crediticio del Banco Central",
    "document_not_found_txt" => "EL DOCUMENTO INGRESADO NO SE ENCUENTRA EN LA CENTRAL DE RIESGOS",
    "limit_reached_txt" => "Usted excedio el TOPE de consultas diarias",
    "captcha_failed_txt" => "La palabra ingresada es incorrecta",
    "url" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/RequestFiltroServlet",
    "params" => array(
                  "periodo" => "201602",
                  "cboPaisDoc" => "UY",
                  "cboTipoDoc" => "IDE",
                  "nroDoc" => $dni,
                  "j_captcha_response" => "", //HERE GOES THE CAPTCHA RESPONSE
                  "x" => "57",
                  "y" => "13",
                  "ORIGEN" => "XDOC",
                  "CALL" => "OUT",
                ),
    "requestObject" => array(
                      'http' => array(
                        'method' => 'GET',
                        'content' => http_build_query(
                                      array(
                                            "periodo" => "201802",
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
    "forceCaptcha" => true,
    "preCaptchaURL" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/RequestLoginServlet",
    "preCaptchaMethod" => "GET",
    "preCaptchaParms" => "null",
    "captchaParamName" => "j_captcha_response",
    "captchaImgUrlWithoutParm" => "jcaptcha",
    "captchaUrlPrefix" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/",
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
  )
);
 ?>
