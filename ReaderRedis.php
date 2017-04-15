<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/4/15
 * Time: 11:15
 */

class ReaderRedis {
    protected $redis='';
    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1',6379);
        $this->redis = $redis;
    }

    protected function check($key,$value){
        return $this->redis->sIsMember($key,$value);
    }

    public function add($key,$value)
    {
       if (!$this->check($key,$value[0])) {
           $this->redis->sAdd($key,$value[0]);
           $this->redis->zAdd(md5($key),substr(time(),2),json_encode($value));
           if($this->redis->zCard(md5($key))>=6){
               $this->redis->zRemRangeByRank(md5($key),0,-6);
           }
       }

    }

    public function getAllZ($key){
        return $this->redis->zRevRange(md5($key),0,-1);
    }


    public function __destruct()
    {
       $this->redis->close();
    }
}





