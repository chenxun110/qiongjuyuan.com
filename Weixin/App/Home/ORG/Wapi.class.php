<?php
/**
  微信接口封装类
 */
class Wapi{

/**
 * 发送HTTP请求方法，目前只支持CURL发送请求
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function httpRequest($url, $params, $method = 'GET', $header = array(), $multi = false){
  $opts = array(
      CURLOPT_TIMEOUT        => 30,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_HTTPHEADER     => $header
  );

  /* 根据请求类型设置特定参数 */
  switch(strtoupper($method)){
    case 'GET':
      $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
      //Log::write(" get url  - > ". $url . '?' . http_build_query($params));
      break;
    case 'POST':
      //判断是否传输文件
      //$params = $multi ? $params : http_build_query($params);
      $opts[CURLOPT_URL] = $url;
      $opts[CURLOPT_POST] = 1;
      $opts[CURLOPT_POSTFIELDS] = $params;
      break;
    default:
      throw new Exception('不支持的请求方式！');
  }

  /* 初始化并执行curl请求 */
  $ch = curl_init();
  curl_setopt_array($ch, $opts);
  $data  = curl_exec($ch);
  $error = curl_error($ch);
  curl_close($ch);
  if($error) throw new Exception('请求发生错误：' . $error);
  return  $data;
}

/**
 * 获取天气查询方法
 * @param  string $cityName  城市+天气(北京天气)
 * @return array  $data   响应数据
 */
 public function getWeatherInfo($cityName){
	$cityName =trim(str_replace('天气', '', $cityName));
	$row=M('weather')->where(array('cityName'=>$cityName))->find();
    $cityCode=$row['cityCode'];
    if ($cityCode == ""){
        return "抱歉没有找到你要找的城市的天气！";
    }
    
    //获取实时天气
    $url = "http://www.weather.com.cn/data/sk/".$cityCode.".html";
    $output = $this->httpRequest($url);
    $weather = json_decode($output, true); 
    $info = $weather['weatherinfo'];

    $weatherArray = array();
    $weatherArray[] = array("Title"=>$info['city']."天气预报", "Description"=>"", "PicUrl"=>"", "Url" =>"");
    if ((int)$cityCode < 101340000){
        $result = "实况 温度：".$info['temp']."℃ 湿度：".$info['SD']." 风速：".$info['WD'].$info['WSE']."级";
        $weatherArray[] = array("Title"=>str_replace("%", "﹪", $result), "Description"=>"", "PicUrl"=>"", "Url" =>"");
    }

    //获取六日天气
    $url = "http://m.weather.com.cn/data/".$cityCode.".html";
    $output =  $this->httpRequest($url);
    $weather = json_decode($output, true); 
    $info = $weather['weatherinfo'];

    if (!empty($info['index_d'])){
        $weatherArray[] = array("Title" =>$info['index_d'], "Description" =>"", "PicUrl" =>"", "Url" =>"");
    }

    $weekArray = array("日","一","二","三","四","五","六");
    $maxlength = 3;
    for ($i = 1; $i <= $maxlength; $i++) {
        $offset = strtotime("+".($i-1)." day");
        $subTitle = date("m月d日",$offset)." 周".$weekArray[date('w',$offset)]." ".$info['temp'.$i]." ".$info['weather'.$i]." ".$info['wind'.$i];
        $weatherArray[] = array("Title" =>$subTitle, "Description" =>"", "PicUrl" =>"http://discuz.comli.com/weixin/weather/"."d".sprintf("%02u",$info['img'.(($i *2)-1)]).".jpg", "Url" =>"");
    }

    return $weatherArray;
}
 





}