<?php
class GlobalVar {

    private static $smscode;


    /**
     * @throws Exception
     */
    public function init(){
        self::setSmscode(random_int(1000,9000));
    }

    /**
     * @return mixed
     */
    public function getSmscode()
    {
        return self::$smscode;
    }

    /**
     * @param mixed $smscode
     */
    public static function setSmscode($smscode): void
    {
        self::$smscode = $smscode;
    }


}