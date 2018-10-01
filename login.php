<?php

// Создаем массив с данными которые хотим отправить json ответом
$data = array(
    'status' => "fail",
);

//Переводим масив в JSON

if(isset($_GET['username']) && isset($_GET['userpass']) && $_GET['username'] != "" && $_GET['userpass'] != ""){
    if($_GET['username'] == "chekanov@ets-cargo.ru" && $_GET['userpass'] == "4aWjcX01"){
    $data['status'] = "success";
    $data['token'] = time();
   	$data['privet'] = "Здравствуйте, Дмитрий Викторович!";
    }

}


$json_data=json_encode($data);

// Выставляем кодировку и тип контента
header("Content-type: application/json; charset=utf-8");

//JSONP - делаем JSONP объект
echo $_GET['callback'] . ' (' . $json_data . ');';


?>