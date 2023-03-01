<?php
include("lib/lib-bot.php");


$bot_token = "";     // replace with your bot's API token
$bot_username = ""; //don't use @ -> example: "guxfiz_bot"


$tokensk = '';  // replace with ur token of ChatGPT 'sk-########################'


// Create Bot object
$bot = new Bot($bot_token, $bot_username);

// Read raw data from the request body
$php_input = file_get_contents("php://input");

function GetStr($string, $start, $end){
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}

function GetInf($a, $b, $c){
  return trim(strip_tags(GetStr($a, $b, $c)));
}

function apichatgpt($url, $Headers, $prompt){

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $prompt);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $Headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  return curl_exec($curl); 

}

// Load update from data
$update = $bot->load_update($php_input);
$ezmessage = $update->message->text;

if ($update->message) {
    if ($update->message->text == "/start") {
        $bot->send_message($update->message->chat->id, "Hola, Bienvenido..  Mira esto!!");
        $bot->send_photo($update->message->chat->id, "https://dam.esquirelat.com/wp-content/uploads/2022/09/10-datos-curiosos-que-debes-saber-sobre-Mario-Bros-1024x576.jpg");
    }else if(strpos($ezmessage, "!e") === 0){

      $response = apichatgpt(
        'https://api.openai.com/v1/images/generations',
        array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$tokensk,
        ),
        json_encode(array(
          'prompt' => $ezmessage,
          'n' => 1,
          'size' => '1024x1024',
        ))
        );

      GetInf($response,  '"message": "', '",') == false ? '' : $bot->send_message($update->message->chat->id, 'Su solicitud fue rechazada como resultado de nuestro sistema de seguridad/Su aviso puede contener texto que no está permitido por nuestro sistema de seguridad.') ;

      $bot->send_photo($update->message->chat->id, GetInf($response,  '"url": "', '"'));

    }else if(strpos($ezmessage, "!a") === 0){

      $response = apichatgpt(
        'https://api.openai.com/v1/completions',
        array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$tokensk,
        ),
        json_encode(array(
          'model' => 'text-davinci-003',
          'prompt' => $ezmessage,
          'temperature' => 0.5,
        ))
        );

      $abcremove = array('\n', $ezmessage);
      $bot->send_message($update->message->chat->id, str_replace($abcremove, ''."\n".'', GetInf($response,  '"text":"', '",')));
      
    }else if(strpos($ezmessage, "!i") === 0){

      $response = apichatgpt(
        'https://api.openai.com/v1/edits',
        array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$tokensk,
        ),
        json_encode(array(
          'model' => 'code-davinci-edit-001',
          'input' => $ezmessage,
          'instruction' => 'responde cómo un profesor de la universidad',
        ))
        );
      

      $abcremove = array('\n', $ezmessage);

      $bot->send_message($update->message->chat->id, str_replace($abcremove, ''."\n".'', GetInf($response,  '"text":"', '",')));
      
    }else if($ezmessage == "!hack"){

        $bot->send_message($update->message->chat->id, "aea");
        
    }
/*
      $letraAleatoria = chr(rand(ord('a'), ord('z')));
      $numeroAleatorio = rand(1,100000);
*/
}





?>