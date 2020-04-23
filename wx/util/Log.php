<?php


class Log
{
    private $case;
    private $date;
    private $postion;
    private $msg;
    private $log;

    const WARM = "Warm";
    const ERROR = "Error";
    const Logger = "Logger";
    const DefaultIt = "Default";


    /**
     * Log constructor.
     * @param $case
     * @param $state
     * @param $msg
     */
    public function __construct($case, $msg){
        $this->case = $this->caseit($case);
        $this->date = $this->now();
        $this->postion = $this->position();
        $this->msg = json_encode($msg);
        $this->log = $this->date." ".$this->case." ".$this->position()." ".$this->msg."\n";
    }

    public function writeDownLog(){
        error_log($this->log,3,"log/system.log");
    }

    private function caseit($case){
        switch ($case){
            case Warm:
                return self::WARM;
                break;
            case Error:
                return self::ERROR;
                break;
            case Logger:
                return self::Logger;
                break;
            default:
                return self::DefaultIt;
        }
    }

    private function now(){
        return date("Y-m-d H:i:s");
    }

    private function position(){
        $debugLog = "";
        $array = debug_backtrace();
        $array = array_splice($array,1);
        foreach ($array as $row) {
            $debugLog .= ($row['file'] . ':' . $row['line'] . 'Link,Active: ' . $row['function'])."\n\t";
        }
        return $debugLog;
    }


}