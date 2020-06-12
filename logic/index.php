<?php
require_once 'logic/func.php';
$func = new func();
class logic
{
    public function new_message($send, $message){
        switch ($message) {
            default:
                $send->message($message);
        }
    }
    public function new_command($send, $message){
        global $func;
        switch ($message) {
            case '/start':
                $send->message("Hi! Do anything");
                break;
            case '/help':
                $send->message("THIS IS HELP");
                break;
            case '/gismeteoperm':
                $appid = '57c5def75a9d9dbc18fb0363276b807a'; //USE YOUR appid, it's free. JUST GO TO openweathermap.org
                $log1 = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=Perm&appid={$appid}&units=metric");
                $log = json_decode($log1, true);
                $log3 = $log['weather'][0]['description'];
                $log4 = $log['main']['temp'];
                $log5 = $log['main']['feels_like'];
                $log2 = "Gismeteo perm:\nIt's {$log3}, {$log4},\nbut feels like {$log5}";
                $send->message($log2);
                break;
            case '/reboot':
                $send->message("NO REPEAT THIS COMMAND, server is rebooting!");
                $func->reboot();
                break;
            case '/info':
                $send->message($func->info());
                break;
            case '/coin':
                $send->message("Монетка решила показать сторону ".$func->coin());
                break;
            default:
                $send->message("What???");
                break;
        }
    }
}