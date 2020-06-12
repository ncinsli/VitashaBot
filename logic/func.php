<?php
require_once 'logic/RandDotOrg.php';
$RandDotOrg = new RandDotOrg();

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
        $log = system('cat /proc/cpuinfo');
        //$log .= system('cat /proc/meminfo');
        //$log .= system('free');
        //$log .= $load = sys_getloadavg();
        //foreach($load as $k => $v) {
        //    $log .= $k.' ---> '.$v;
        //}
        return $log;
    }
}