<?php
$bases = array(
  array(
    "interesting_data" => array(
      "ids" => array("tabla","tablaXInst0","tablaXInst1","tablaXInst2","tablaXInst3","tablaXInst4"),
      "special_data" => array(
                              array(
                                  "simpleHtmlDom_ParentQuery" => "td.impar",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Nombre",
                                  "groupBy" => "Persona",
                                  "groupType" => "datosPersonales"
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst0 td.headerLeft",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Nombre",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco"
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst0 td[width='14%']",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Calificacion",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco"
                                ),
                                /*array(
                                  "simpleHtmlDom_ParentQuery" => "#divXInst0",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Tabla",
                                  "html" => true,
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco"
                                ),*/
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_mn-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                 "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_me-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_mn-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_me-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Previsiones_totales_mn-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Previsiones_totales_me-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Contingencias_mn-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst0 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Contingencias_me-pesos",
                                  "groupBy" => "Banco_1",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),

                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst1 td.headerLeft",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Nombre",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco"
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst1 td[width='14%']",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Calificacion",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco"
                                ),
                                /*array(
                                  "simpleHtmlDom_ParentQuery" => "#divXInst1",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Tabla",
                                  "html" => true,
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco"
                                ),*/
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_mn-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                 "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_me-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_mn-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_me-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Previsiones_totales_mn-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Previsiones_totales_me-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Contingencias_mn-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst1 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Contingencias_me-pesos",
                                  "groupBy" => "Banco_2",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),

                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst2 td.headerLeft",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Nombre",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco"
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst2 td[width='14%']",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Calificacion",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco"
                                ),
                                /*array(
                                  "simpleHtmlDom_ParentQuery" => "#divXInst2",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Tabla",
                                  "html" => true,
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco"
                                ),*/
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_mn-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                 "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_me-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_mn-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_me-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Previsiones_totales_mn-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Previsiones_totales_me-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Contingencias_mn-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst2 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Contingencias_me-pesos",
                                  "groupBy" => "Banco_3",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),

                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst3 td.headerLeft",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Nombre",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco"
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#tablaXInst3 td[width='14%']",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Calificacion",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco"
                                ),
                                /*array(
                                  "simpleHtmlDom_ParentQuery" => "#divXInst3",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => false,
                                  "simpleHtmlDom_ChildIndex" => false,
                                  "keyInsideArray" => "Tabla",
                                  "html" => true,
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco"
                                ),*/
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_mn-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                 "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 0,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_me-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_mn-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 1,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Vigente_No_Autoliquidable_me-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Previsiones_totales_mn-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 2,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Previsiones_totales_me-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 0,
                                  "keyInsideArray" => "Contingencias_mn-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                ),
                                array(
                                  "simpleHtmlDom_ParentQuery" => "#XInst3 tr",
                                  "simpleHtmlDom_ParentIndex" => 3,
                                  "simpleHtmlDom_ChildQuery" => "td.impar",
                                  "simpleHtmlDom_ChildIndex" => 1,
                                  "keyInsideArray" => "Contingencias_me-pesos",
                                  "groupBy" => "Banco_4",
                                  "groupType" => "datosBanco",
                                  "index" => 1
                                ),

                              ),
    ),
    "name" => "BCU",
    "response_charset" => "ISO-8859-1",
    "long_name" => "la Central de Riesgo Crediticio del Banco Central",
    "document_not_found_txt" => "El documento ingresado no se encuentra en la Central de Riesgos",
    "no_data_for_period_txt" => "No hay info. de la Central de Riesgos para este periodo",
    "limit_reached_txt" => "Usted excedio el TOPE de consultas diarias",
    "captcha_failed_txt" => "La palabra ingresada es incorrecta",
    "url" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/RequestFiltroServlet",
    "params" => array(
      "periodo" => "201801",
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
        array(
            "email"=>"tristesparasiempre@gmail.com",
            "password"=>"6674",
            "x"=>"87",
            "y"=>"10",
          ),
        array(
          "email"=>"lito@datauy.org",
          "password"=>"ds1FOMD1gmq7",
          "x"=>"87",
          "y"=>"10",
        ),
        array(
          'user' => 'testeanando@gmail.com',
          'pass'=> 'Sap3enHRVJ2x',
          "x"=>"87",
          "y"=>"10",
        ),
        array(
          'user' => 'testeanando1@gmail.com',
          'pass'=> 'QEdq3HjhONZE',
          "x"=>"87",
          "y"=>"10",
        ),
        array(
          'user' => 'testeanando2@gmail.com',
          'pass'=> 'BUCW09Djridj',
          "x"=>"87",
          "y"=>"10",
        ),
        array(
          'user' => 'testeanando3@gmail.com',
          'pass'=> 'DYJwR1JdBwuG',
          "x"=>"87",
          "y"=>"10",
        ),
      ),
      "url" => "http://consultadeuda.bcu.gub.uy/consultadeuda/servlet/RequestLoginServlet",
    )
  ),

);
 ?>
