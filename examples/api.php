<?php
//sample api
$limit = 0+getParam('limit', '/\A[0-9]+\z/u');
$offset = 0+getParam('offset', '/\A[0-9]+\z/u');
//error_log($limit);
//error_log($offset);
$data = genData($limit, $offset);
//error_log(print_r($data,1));
response_json($data);

//------------
function getParam($name, $checkRegExp=null){
    if(isset($_REQUEST[$name])){
        $var = $_REQUEST[$name];
        if(!is_null($checkRegExp) && !preg_match($checkRegExp, $var)){
            throw new Exception('Invalid params');
        }else{
            return $var;
        }
    }else{
        return null;
    }
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
        if($offset+$i>1000){
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