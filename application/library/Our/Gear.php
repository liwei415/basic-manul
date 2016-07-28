<?php
namespace Our;
/**
 * 公用工具类
 *
 * @author  James
 * @date    2012-02-06 15:00
 * @version $Id$
 */

class Gear {

    /**
     * Constructor
     *
     * @param   void
     * @return  void
     */
//     public function __construct()
//     {
//         //construct class
//     }

    /**
     * json encode
     *
     * @param   mixed       $obj
     * @return  string
     */
    /*
    public function arr2json($obj)
    {
        $json = json_encode($obj);
        $arr  = array();
        preg_match_all("/\\\u.{4}|.+/U", $json, $arr);
        $arr  = $arr[0];
        foreach($arr as $k => $v)
        {
            if ('\u' == substr($v,0,2))
            {
                //$arr[$k] = iconv('UCS-2', 'UTF-8', pack('H4', substr($v, -4)));
                $arr[$k] = mb_convert_encoding(pack('H4', substr($v, -4)), 'UTF-8', 'UCS-2');
            }
        }
        return join('', $arr);
    }
    */
    /**
     * 编码转化
     *
     * @param   $idcard string
     * @return  string
     */
    public function utf8_unicode($c,$pagecharacter="utf-8") {
        $code=strtolower(mb_detect_encoding($c, array('ASCII','GB2312','GBK','UTF-8')));

        if(($code=='gb2312' || $code=='utf-8' || $code=='euc-cn') && $code!=$pagecharacter)
            $c=iconv($code,$pagecharacter,$c);
        return $c;
    }
    //获取文件名,支持中文
    public function get_basename($filename){
        return preg_replace('/^.+[\\\\\\/]/', '', $filename);
    }

    /**
     * 身份证加星号
     *
     * @param   $idcard string
     * @return  string
     */
    public function idcardMakeStar($idcard)
    {
        $len = strlen($idcard);
        if($len<5)
        {
            return $idcard;
        }
        $last=substr($idcard,-4);
        return str_pad($last,$len,'*',STR_PAD_LEFT);
    }

    /**
     * 姓名加星号
     *
     * @param   $name string
     * @return  string
     */
    public function realnameMakeStar($name)
    {
        $len = GEAR::strLength($name);
        // echo $len;
        // var_dump($len);

        if($len<2)
        {
            return $name;
        }
        $last= GEAR::cut_str($name,1,-1);
        if($len == 0)
        {
            return str_pad('',3,'*',STR_PAD_LEFT );
        }
        // echo $first;
        $str_len = ($len-1);
        if($str_len > 2)
        {
            $str_len = 2;
        }
        return str_pad('',$str_len,'*',STR_PAD_LEFT ).$last;
    }
    /**
     * 手机号码加星号
     *
     * @param   $idcard string
     * @return  string
     */
    public function PhoneMakeStar($phone)
    {
        $len = strlen($phone);
        if($len<5)
        {
            return $phone;
        }
        $front=substr($phone,0,3);
        $fast=substr($phone,-3);
        $new_phone=$front."*****".$fast;

        return $new_phone;
    }
     /**
     * 姓名加星号
     *
     * @param   $name string
     * @return  string
     */
    public function corpNameMakeStar($name)
    {
        $len = GEAR::strLength($name);
        // echo $len;
        // var_dump($len);
        if($len<2)
        {
            return $name;
        }
        $first= GEAR::cut_str($name,2);
        $last= GEAR::cut_str($name,4,-1);
        // echo $first;

        return $first.str_pad('',($len-6),'*',STR_PAD_LEFT ).$last;
    }
    /**
     * 姓名加星号
     *
     * @param   $name string
     * @return  string
     */
    public function usernameMakeStar($name)
    {
        $len = GEAR::strLength($name);
        // echo $len;
        // var_dump($len);
        if($len<3)
        {
            $first= GEAR::cut_str($name,2);
            return $first."*";
        }
        $first = GEAR::cut_str($name,1);
        $last = GEAR::cut_str($name,1,-1);
        // echo $first;

        return $first.str_pad('',($len-2),'*',STR_PAD_LEFT ).$last;
    }

    /**
     * 姓名加星号
     *
     * @param   $name string
     * @return  string
     */
    public function cardCodeMakeStar($code)
    {
        $len = GEAR::strLength($code);
        $last = GEAR::cut_str($code,4,-4);
        return str_pad('',($len-4),'*',STR_PAD_LEFT ).$last;
    }
    
    
    /**
     * 加*号规则(最后1位的前4位)
     *
     * Alan
     */
    public function XxMakeStar($str)
    {
        $len = strlen($str);
        //  echo $len;
        // var_dump($len);
        if($len<5)
        {
            return "****".substr($str,-1);
        }
        $first = substr($str,0,-5);

        $last=substr($str,-1);

        return $first."****".$last;

    }


    /**
    * PHP获取字符串中英文混合长度
    * @param $str string 字符串
    * @param $$charset string 编码
    * @return 返回长度
    */
    public function strLength($str,$charset='utf-8')
    {
        if($charset=='utf-8')
        {
            $str = iconv('utf-8','GBK',$str);
        }
        $num = strlen($str);
        $cnNum = 0;
        for($i=0;$i<$num;$i++)
        {
            if(ord(substr($str,$i+1,1))>127)
            {
                $cnNum++;
                $i++;
            }
        }
        $enNum = $num-($cnNum*2);

        $number = $enNum+$cnNum;
        //var_dump($number);
        return $number;
    }
    /**
     * 获取字符串
     *
     * @param   string
     * @return  string
     */

    public function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
    {
        if($code == 'UTF-8')
        {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);
            if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
            return join('', array_slice($t_string[0], $start, $sublen));
        }
        else
        {
            $start = $start*2;
            $sublen = $sublen*2;
            $strlen = strlen($string);
            $tmpstr = '';
            for($i=0; $i< $strlen; $i++)
            {
                if($i>=$start && $i< ($start+$sublen))
                {
                    if(ord(substr($string, $i, 1))>129)
                    {
                        $tmpstr.= substr($string, $i, 2);
                    }
                    else
                    {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if(ord(substr($string, $i, 1))>129) $i++;
            }
            //if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
            return $tmpstr;
        }
    }

    /**
     * json encode
     *
     * @param   string      $str
     * @return  array
     */
    public function json2arr($str)
    {
        return json_decode($str, true);
    }

    /**
     * convert string to utf8
     *
     * @param   string      $str
     * @param   string      $from
     * @return  string
     */
    public function utf8($str, $from = 'GBK')
    {
        return mb_convert_encoding($str, 'UTF-8', $from);
    }

    /**
     * convert string to gbk
     *
     * @param   string      $str
     * @param   string      $from
     * @return  string
     */
    public function gbk($str, $from = 'UTF-8')
    {
        return mb_convert_encoding($str, 'GBK', $from);
    }

    /**
     * cut string by lenth
     *
     * @param   string      $str
     * @param   integer     $len
     * @return  string
     */
	public function strcut($str, $len)
	{
		if ($len < mb_strlen($str, 'UTF-8'))
		{
			$str = mb_substr($str, 0, $len, 'UTF-8') . '…';
		}
        return $str;
	}

    /**
     * parse & decode qq parameters
     *
     * @param   string      $str
     * @return  array
     */
	public function qq_decode($str)
    {
		$params = array();
		if (!empty($str))
        {
            $list = preg_split('/QQ/', $str, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($list as $item)
            {
                @list($name, $value) = preg_split('/Z/', $item, 2, PREG_SPLIT_NO_EMPTY);
                if (!empty($name))
                {
                    $name  = urldecode($name);
                    $value = urldecode($value);
                    if (!isset($params["{$name}"]))
                    {
                        $params["{$name}"] = $value;
                    }
                    elseif (is_array($params["{$name}"]))
                    {
                        $params["{$name}"][] = $value;
                    }
                    else
                    {
                        $params["{$name}"] = array($params["{$name}"], $value);
                    }
                }
            }
        }

        return $params;
	}

    /**
     * parse & encode qq parameters
     *
     * @param   array      $params
     * @return  string
     */
	public function qq_encode($params)
    {
		$str = '';
        ksort( $params );
        foreach ($params as $name => $value)
        {
            $name = urlencode($name);
            if (is_array($value))
            {
                ksort( $value );
                foreach ($value as $v)
                {
                    $str .= "QQ{$name}Z" . urlencode($v);
                }
            }
            else
            {
                $str .= "QQ{$name}Z" . urlencode($value);
            }
        }
        return $str;
	}

    /**
     * check string format and return true if it's mobile
     *
     * @param   string      $str
     * @return  boolean
     */
	public function is_mobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15\d{9}$|^16\d{9}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;

	}
    /**
     * check string format and return true if it's email
     *
     * @param   string      $str
     * @return  boolean
     */
	public function is_email($email)
	{
		$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	    if (strpos($email, '@') !== false && strpos($email, '.') !== false)
	    {
	        if (preg_match($chars, $email))
	        {
	            return true;
	        }
	        else
	        {
	            return false;
	        }
	    }
	    else
	    {
	        return false;
	    }
	}

	//写入文件
	public function php_write($file_name,$data,$method="a+")
	{
		$filenum=@fopen($file_name,$method);
		flock($filenum,LOCK_EX);
		$file_data=fwrite($filenum,$data);
		fclose($filenum);
		return $file_data;
	}

    //检查身份证号码
    public function isCreditNo($vStr)
    {
        $vCity = array(
            '11','12','13','14','15','21','22',
            '23','31','32','33','34','35','36',
            '37','41','42','43','44','45','46',
            '50','51','52','53','54','61','62',
            '63','64','65','71','81','82','91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

        if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18)
        {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
        if ($vLength == 18)
        {
            $vSum = 0;

            for ($i = 17 ; $i >= 0 ; $i--)
            {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
            }

            if($vSum % 11 != 1) return false;
        }

        return true;
    }

    //距离上一个还款日(15号)的天数
    public function  awayRepayDays(){
        $today = getdate();

        if ($today["mday"] > 15) {
            $days = $today["mday"] - 15;
        }else{
            $days = 15 + $today["mday"];
        }
        return $days;
    }

   	//获取两个日期的天数
    public function daysbetweendates($date1, $date2){
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        $days = ceil(abs($date1 - $date2)/86400);
        return $days;
    }
    
    //根据身份证算年龄
    public function getAgeByCard($u_card){
        $card_len = strlen($u_card);
        if ($card_len == 18) {
               $birth                   = substr($u_card, 6, 4) . "-" . substr($u_card, 10, 2) . "-" . substr($u_card, 12, 2);
               $age = ceil((time() - strtotime($birth)) / 86400 / 365);
        } elseif (card_len == 15) {
               $birth                   = substr('19' . $u_card, 6, 2) . "-" . substr($u_card, 8, 2) . "-" . substr($u_card, 10, 2);
               $age  = ceil((time() - strtotime($birth)) / 86400 / 365);
        }
        return $age;
    }

}