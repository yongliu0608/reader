<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/4/15
 * Time: 09:15
 * 这个页面可以使用定时任务 定时采集，也可以放在小说查看页的构造器前面，每次使用前，先抓一遍，或者使用js异步请求，后台刷新数据，前台暂缓2秒打开
 * 这样每次都是最新数据
 */

require ('ReaderRedis.php');
class Read {

    static function getUpdate($url=''){
        $result = fopen($url,'r');
        while(!feof($result)){
            $tmp =  iconv("gbk","utf-8",fgets($result));
           if(strpos($tmp,'最新章节：')){

                preg_match('/((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+/',$tmp,$matches);
                $return[] = substr(trim(strip_tags($tmp)),15);
                $return[] = substr($matches[0],0,-1);
                $return[] = date('Y-m-d H:i:s');
               return $return;
            }
        }
    }
}
$arr[]=['name'=>'雪鹰领主','url'=>'http://www.boluoxs.com/biquge/0/420/'];
$arr[]=['name'=>'一念永恒','url'=>'http://www.boluoxs.com/biquge/6/6851/'];
$arr[]=['name'=>'玄界之门','url'=>'http://www.boluoxs.com/biquge/2/2301/'];
$arr[]=['name'=>'不朽凡人','url'=>'http://www.boluoxs.com/biquge/9/9430/'];
$redis = new ReaderRedis();


foreach ($arr as $v){
    $res = Read::getUpdate($v['url']);
    $redis->add($v['name'],$res);
}