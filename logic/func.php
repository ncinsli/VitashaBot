<?php
require_once 'logic/RandDotOrg.php';
$RandDotOrg = new RandDotOrg();
// @ncinsli: нихрена ты конечно Виталя кодишь
class func
{
    public function reboot(){
        //exec ("/sbin/reboot");
        $stop = false;
        /**
         * pcntl_fork() - данная функция разветвляет текущий процесс
         */
        $pid = pcntl_fork();
        if ($pid == -1) {
            /**
             * Не получилось сделать форк процесса, о чем сообщим в консоль
             */
            die('Error fork process' . PHP_EOL);
        } else if ($pid) {
            /**
             * В эту ветку зайдет только родительский процесс, который мы убиваем и сообщаем об этом в консоль
             */
            die('Die parent process' . PHP_EOL);
        } else {
            /**
             * Бесконечный цикл
             */
            while(!$stop) {
                sleep(1);
                $stop = true;
                exec ("/sbin/reboot");
                
            }
        }
        /**
         * Установим дочерний процесс основным, это необходимо для создания процессов
         */
        posix_setsid();
        exit;
    }
    public function coin(){
        global $RandDotOrg;
        return $RandDotOrg->get_integers(1,1,2);
    }
    public function info(){
        $log = memory_get_usage();
        $log = ($log - $log%1024)/1024;
        return "Free - {$log}mb.";
    }
}
