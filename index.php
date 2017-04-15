<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/4/15
 * Time: 14:11
 */
//这个页面目前还没有使用什么前台模板 显示比较粗糙。
require ('ReaderRedis.php');
$redis = new ReaderRedis();
$arr=['雪鹰领主','不朽凡人','一念永恒','玄界之门'];
foreach ($arr as $k=>$v){
    $tmpRes = $redis->getAllZ($v);
    foreach ($tmpRes as $tmpV){
        $result[$v][]= json_decode($tmpV,true);
    }
}


foreach ($result as $k=>$v){
    echo $k;
    echo "<br />";
    foreach ($v as $value) {
        echo "<a href='$value[1]' target='_blank'>$value[0]</a> 更新时间 $value[2]<br/>";
    }
}
