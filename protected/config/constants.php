<?php
$params = include('params.php');
foreach($params as $key=>$value){
    if(!defined($key))
        define($key,$value);
} 
