<?php

/**
 * @author Silsh
 * @copyright 2014
 */
$msg=(error_reporting(E_ALL ^ E_NOTICE))?"Режим отладки включен":"Режим отладки НЕ включен!";
echo out($msg,"h2");
function out($msg,$teg="br"){
    return "<$teg class=\"debugger\">$msg</$teg>";
}
function querytoarray($query){
//    echo "!!!!!!!!!!";
//    echo $query;
    $result=preg_match('/select\s+(.+)\s+from\s+(.+)\s+where\s+(.+)\s+.*/i',$query,$matches);
    $out=out("Дебаггер в работе!","p");
    if($result){
        $result=Array();
        $fields=explode(", ",$matches[1]);
        $i=0;
//        print_r($matches);
        foreach($fields as $field){
            $result[0][$field]=$i++;
        }
        $fields=explode(" and ",$matches[3]);
        foreach($fields as $field){
            $r=preg_match('/([^!]+)!?=(.+)/i',$field,$m);
            if($r){
                $result[0][$m[1]]="";
            } 
        }
        $result['rows']=1;
    }else{
        $out+=out("Ошибка!");
        print_r($result);
    }
    $result[0]['importopt']="1,2,3,0";
    $result[0]['id']=1;
    $result[0]['name']="Тест";
    $result['out']=$out;
    return $result;
}
function queryresult($query,$field){
    static $call;
    if(!isset($call)){
        $call=0;
    }
    $result=preg_match('/select\s+(.+)\s+from\s+(.+)\s+where\s+(.+)/i',$query,$matches);
    if($result){
        if("menu"==$matches[2]){
            switch($matches[1]){
                case "id":
                    return "1".++$call;
                    break;
                case "wmotmenuid":
                    return "2".++$call;
                    break;
                case "name":
                    return "TestCat".++$call;
                    break;
            }
        }else{
            return $matches[2];
        }
    }else{
        
    }
/*    if($field="id"){
        return $matches[2];
    }else{
        return false;
    }*/
}
?>