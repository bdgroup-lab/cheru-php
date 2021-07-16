<?php
require_once 'class-cheru.php';
$cheru=new Cheru();
//切噜语编码
var_dump($cheru->encode('会长，我挂树了！'));
//切噜语解码
var_dump($cheru->decode('切噜～♪切噼噼卟蹦咧噼哔噜咧噜巴噜蹦巴叮拉嘭噼叮拉噜巴啰铃卟巴噼巴咧噜卟噜'));

//使用其他编码进行切噜语编码
$cheru->set_charset('UTF-8');
var_dump($cheru->encode('🐸🔫'));
var_dump($cheru->decode('切噜～♪切切铃铃嘭切嘭啵噼切铃铃嘭哔嘭噼噜'));