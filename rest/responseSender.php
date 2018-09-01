<?php

    function SendResponse($type, $body)
        {
            switch($type)
            {
                case 0:
                    http_response_code(500);
                    $response = array('RESPONSE_CODE' => 501, 'RESPONSE_TYPE'=>'INTERNAL SERVER ERROR');
                    $response['BODY'] = $body; 
                    print json_encode($response);
                break;

                case 1:
                    http_response_code(200);
                    $response = array('RESPONSE_CODE' => 200, 'RESPONSE_TYPE'=>'OK');
                    $response['BODY'] = $body; 
                    print json_encode($response);
                break;
            }
        }
?>