<?php
/*
 * Princess Connect! re:Dive Cheru converter
 *
 * Author: BDGroup
 * Website: https://www.bdgroup-lab.com
 * Version: 1.0
 */

class Cheru
{
    private array $cheru;
    private array $cheru_dec;
    private string $charset;

    public function __construct()
    {
        //定义切噜语的转换表
        $this->cheru = ['切', '卟', '叮', '咧', '哔', '唎', '啪', '啰', '啵', '嘭', '噜', '噼', '巴', '拉', '蹦', '铃'];
        $this->cheru_dec = ['切' => 0, '卟' => 1, '叮' => 2, '咧' => 3, '哔' => 4, '唎' => 5, '啪' => 6, '啰' => 7, '啵' => 8, '嘭' => 9, '噜' => 10, '噼' => 11, '巴' => 12, '拉' => 13, '蹦' => 14, '铃' => 15];
        //设置初始编码
        $this->charset = 'GBK';
    }

    /**
     * 设置切噜语编码，默认GBK
     * @param string $charset 字符编码
     */
    public function set_charset($charset = 'GBK')
    {
        $this->charset = strtoupper($charset);
    }

    /**
     * 切噜语编码，成功返回切噜语，失败返回false
     * @param string $text 待编码的内容
     * @return string|false
     */
    public function encode(string $text)
    {
        $return = '';
        //执行编码转换并转成16进制
        if ($this->charset != 'UTF-8') $text = iconv('UTF-8', 'GBK', $text);
        $text = bin2hex($text);
        $length = strlen($text) / 2;//字符串长度
        $text = str_split($text);//将字符串切割成数组
        for ($i = 0; $i < $length; $i++) {
            $pos = hexdec($text[$i * 2 + 1]);
            $return .= $this->cheru[$pos];
            $pos = hexdec($text[$i * 2]);
            $return .= $this->cheru[$pos];
        }
        if (strlen($return) > 0) return "切噜～♪切{$return}";
        else return false;
    }

    /**
     * 切噜语解码
     * @param string $cheruText 切噜语
     * @return string|false
     */
    public function decode(string $cheruText)
    {
        if (substr($cheruText, 0, 15) != '切噜～♪切') return false;
        $return = '';
        $hex = '';
        $cheruText = str_split($cheruText, 3);//切噜语一个字算三个字节
        for ($i = 5; $i < count($cheruText); $i++) {//去掉前几个固定字符后解码
            if (in_array($cheruText[$i], $this->cheru)) {
                $hex .= dechex($this->cheru_dec[$cheruText[$i]]);
                if (strlen($hex) == 2) {
                    $hex = strrev($hex);//反转hex
                    $return .= $hex;
                    $hex = '';
                }
            } else {
                $return = false;
                break;
            }
        }
        if ($return === false) return false;
        if (strlen($return) > 0) {
            $return = hex2bin($return);
            if ($this->charset != 'UTF-8') return iconv($this->charset, 'UTF-8', $return);
            else return $return;
        } else return false;
    }
}