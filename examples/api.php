<?php
//-- sample api
define('DUMMY_DATA_LENGTH', 3000);

try{
    $limit = 0+getParam('limit', true, '/\A[0-9]+\z/');
    $offset = 0+getParam('offset', true, '/\A[0-9]+\z/');
}catch(Exception $e){
    halt("Parameter error: ".$e->getMessage());
}

$data = genData($limit, $offset);
response_json($data);

//-- functions
function getParam($name, $require, $checkRegExp=null){
    if(isset($_REQUEST[$name])){
        $var = $_REQUEST[$name];
        if(!is_null($checkRegExp) && !preg_match($checkRegExp, $var)){
            throw new Exception('Invalid format param:'.$name);
        }else{
            return $var;
        }
    }elseif($require){
        throw new Exception('Param require:'.$name);
    }else{
        return null;
    }
}

function halt($message='halt'){
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    die($message);
}

function response_json($data){
    header('Content-Type: application/json; charset=utf-8');
    header('PragmaL: no-cache');
    header('Cache-Control: no-store');
    header('X-frame-options: DENY');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
}

function genData($limit=0, $offset=0){
    $return_array = array();
    for($i=0; $limit>$i; $i++){
        if($offset+$i>=DUMMY_DATA_LENGTH){
            return $return_array;
        }
        $return_array[] = array(
            'id'       => $offset+$i+1,
            'name'     => 'name'.genStr(4),
            'director' => 'name'.genStr(4),
            'actor'    => 'Actor'.genStr(4),
            'rating'   => '9.9',
            'year'     => '1999',
        );
    }
    return $return_array;
}

function genStr($length = 8) {
    $char_list = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $res = '';
    for($i=0; $length>$i; $i++){
        shuffle($char_list);
        $res .= $char_list[0];
    }
    return $res;
}