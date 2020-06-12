<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', __DIR__.'/php_errors.log');
$data = file_get_contents('php://input');
$data = json_decode($data, true);
require_once 'logic/index.php';
require_once 'logic/send.php';
$send = new send($data['message']['chat']['id']);
$logic = new logic();

if (!empty($data['message']['photo'])) {
	$photo = array_pop($data['message']['photo']);
	$res = $send->sendTelegram(
		'getFile', 
		array(
			'file_id' => $photo['file_id']
		)
	);
	
	$res = json_decode($res, true);
	if ($res['ok']) {
		$src = 'https://api.telegram.org/file/bot' . $send->token . '/' . $res['result']['file_path'];
		$one = time().basename($src);
		$dest = __DIR__ . '/photos/' . $one;
 
		if (copy($src, $dest)) {
		    $send->message('Фото сохраненно');
			$send->message('https://api.vitasha.tk/tg/latest/photos/' . $one);
		}
	}
	
	exit();	
}
 
// Прислали файл.
if (!empty($data['message']['document'])) {
	$res = $send->sendTelegram(
		'getFile', 
		array(
			'file_id' => $data['message']['document']['file_id']
		)
	);
	
	$res = json_decode($res, true);
	if ($res['ok']) {
		$src = 'https://api.telegram.org/file/bot' . $send->token . '/' . $res['result']['file_path'];
		$one = time() . '-' . $data['message']['document']['file_name'];
		$dest = __DIR__ . '/files/' . $one;
 
		if (copy($src, $dest)) {
			$send->message('Файл сохранён');
			$send->message(json_encode($data['message']['document']));
			$send->message('https://api.vitasha.tk/tg/latest/files/' . $one);
		}
	}
	
	exit();	
}
if($data['message']['text']{0} == "/"){
    $logic->new_command($send, $data['message']['text']);
}else{
    $logic->new_message($send, $data['message']['text']);
}