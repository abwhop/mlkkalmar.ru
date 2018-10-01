<?php

require_once '../vendor/autoload.php';

//$loader = new Twig_Loader_Array(array(
//    'index' => 'Hello {{ name }}!',
//));


$loader = new Twig_Loader_Filesystem('./templates');

$twig = new Twig_Environment($loader);

echo $twig->render('index.html', array("a_variable"=>"ddd",'navigation' => array(
array("href"=>"/1","caption"=>"Первый пункт"),
array("href"=>"/2","caption"=>"Второй пункт")


)));

?>