<?php

function getAllconfigs(){
    $allconfig = \App\Http\Model\Config::all();
    $allconfigArr = array();
    foreach ($allconfig as  $val){
        $allconfigArr["$val->name"]=$val->values;
    }
    return $allconfigArr;
}


