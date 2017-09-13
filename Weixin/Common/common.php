<?php 
function getCateName($cate_id){
 	$subject = M('article_cate')->where(array('id'=>$cate_id))->getField('subject');
 	if(empty($subject)){
       $subject = '全部分类';
 	}
 	return $subject;
 }
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
	if(function_exists("mb_substr"))
	$slice = mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		$slice = iconv_substr($str,$start,$length,$charset);
	}else{
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice.'...' : $slice;
}
function remotedata($url){
    $result = file_get_contents($url);
    if (empty($result)){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    return $result;
}
//获取accesstoken
function get_accesstoken($token=null){
    $public = M('wxuser')->field('AppId,Secret,id')->find();
    if(!empty($public)){
         $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$public['AppId']}&secret={$public['Secret']}";
         $json = json_decode(remotedata($url),true);
         return $json['access_token'];
    }else{
         return false;
    }
 } 
 function https_request($url, $data = null){
     $curl = curl_init();
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
     if (!empty($data)) {
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
     }
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
     $output = curl_exec($curl);
     curl_close($curl);
     return $output;
 }
 /*
$length  int 生成字符传的长度
$numeric  int  ,$numeric = 0 随机数则是 大小写字符+ 数字... $numeric = 1 则为纯数字
*/
function random($length, $numeric = 0)
{
    PHP_VERSION < '4.2.0' ? mt_srand(( double )microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed [mt_rand(0, $max)];
    }
    return $hash;
}
/**
     *-------------------------------------------
     * 生成随机字符串
     * @param int       $length  要生成的随机字符串长度
     * @param string    $type    随机码类型：0，数字+大小写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符----------------------------------------
     * @return string
     */
function randCode($length = 5, $type = 0) {
        $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
        if ($type == 0) {
            array_pop($arr);
            $string = implode("", $arr);
        } elseif ($type == "-1") {
            $string = implode("", $arr);
        } else {
            $string = $arr[$type];
        }
        $count = strlen($string) - 1;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $string[rand(0, $count)];
        }
        return $code;
    }
function getuserinfo(){
    $public = M('wxuser')->field('AppId,Secret,id')->find();
    $appid = $public['AppId'];
    $appsecret = $public['Secret'];
    $code = $_GET['code'];
    //第二步：通过code换取网页授权access_token
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
    $json_arr = json_decode(remotedata($url), true);
     //第三步：刷新access_token（如果需要）
     //第四步：拉取用户信息(需scope为 snsapi_userinfo)
    // $gurl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$json_arr['access_token']}&openid={$json_arr['openid']}&lang=zh_CN"; //传统方式
    $gurl = "https://api.weixin.qq.com/sns/userinfo?access_token={$json_arr['access_token']}&openid={$json_arr['openid']}&lang=zh_CN";
    $getuserinfo = json_decode(remotedata($gurl), true);
    if(!empty($getuserinfo['openid'])){
      $memberinfo = M('member')->where(array('openid'=>$getuserinfo['openid']))->find();
      if($memberinfo){
       $_SESSION['uid']   = $memberinfo['id'];
       $_SESSION['wxname'] = $memberinfo['wxname'];
       $_SESSION['headerpic'] = $memberinfo['headerpic'];
      }
    }
 } 
function getoken(){
 $public = M('wxuser')->field('token')->find();
 $_SESSION['token'] = $public['token'];
 return $_SESSION['token'];
}


function get_memberinfo($uid,$field){
    $member = M('member')->where(array('id'=>$uid))->find();
    return $member[$field];
}
function checkMobile($mobilephone)
{
    if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $mobilephone)) {
        return 1;
    } else {
        return 0;
    }
}
function get_title($source_table,$aim_id){
    $title = M($source_table)->where(array('id'=>$aim_id))->getField('title');
    return $title;
}
function str_cut($string, $length, $dot = '...', $charset = "utf-8")
{
    $strlen = strlen($string);
    if ($strlen <= $length) return $string;
    $string = str_replace(array(' ', '&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵', ' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
    $strcut = '';
    if (strtolower($charset) == 'utf-8') {
        $length = intval($length - strlen($dot) - $length / 3);
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
        $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
    } else {
        $dotlen = strlen($dot);
        $maxi = $length - $dotlen - 1;
        $current_str = '';
        $search_arr = array('&', ' ', '"', "'", '“', '”', '—', '<', '>', '·', '…', '∵');
        $replace_arr = array('&amp;', '&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;', ' ');
        $search_flip = array_flip($search_arr);
        for ($i = 0; $i < $maxi; $i++) {
            $current_str = ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
            if (in_array($current_str, $search_arr)) {
                $key = $search_flip[$current_str];
                $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
            }
            $strcut .= $current_str;
        }
    }
    return $strcut . $dot;
}
function get_wxid(){
   $wxid = M('wxuser')->getField('wxid');
    return $wxid?$wxid:false;
} 