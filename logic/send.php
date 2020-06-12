<?php
class send
{
    public $user_id;
    public $token;
    function __construct($user_id) {$this->user_id = $user_id; $this->token = fgets(fopen(__DIR__."/token.txt", "r"), filesize(__DIR__."/token.txt")+1);} //token
    public function sendTelegram($method, $response){
        $ch = curl_init('https://api.telegram.org/bot' . $this->token . '/' . $method);  
    	curl_setopt($ch, CURLOPT_POST, 1);  
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_HEADER, false);
    	$res = curl_exec($ch);
    	curl_close($ch);
    	return $res;
    }
    public function message($text){
        $this->sendTelegram(
			'sendMessage', 
			array(
				'chat_id' => $this->user_id,
				'text' => $text
			)
		);
    }
    public function photo($photo){
        $this->sendTelegram(
			'sendPhoto', 
			array(
				'chat_id' => $this->user_id,
				'photo' => curl_file_create(__DIR__ . '../photos/' .  $photo)
			)
		);
    }
    public function document($file){
        $this->sendTelegram(
			'sendDocument', 
			array(
				'chat_id' => $this->user_id,
				'document' => curl_file_create(__DIR__ . '../files/' .  $file)
			)
		);
    }
}
