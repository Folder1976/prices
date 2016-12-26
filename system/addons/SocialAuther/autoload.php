<?php

spl_autoload_register('autoload');

function autoload($class)
{
    //echo '<br>'.str_replace('SocialAuther/', '', str_replace('\\', '/', $class) . '.php');
    if(strpos($class, 'Config') !== false){
       // require_once DIR_SYSTEM.'addons'.str_replace('/SocialAuther/', '', str_replace('\\', '/', $class) . '.php');
    }
}