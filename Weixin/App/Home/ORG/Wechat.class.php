<?php
include_once "wxBizMsgCrypt.php";
class Wechat{
    public  $data = array();
    public  $encrypt_type;
    private $token;
    private $appId;
    private $encodingAesKey;
    public function __construct($token,$encodingAesKey,$appId){
        $this->token = $token; //token值
        $this->encodingAesKey = $encodingAesKey;//消息加密密钥
        $this->appId = $appId;//公众号Appid
        $this->auth() || exit;
        if ($_GET['echostr']) {
            echo ($_GET['echostr']);exit;
        } else {
              $xmlstr = file_get_contents("php://input");
              //加密
              if(isset($_GET['encrypt_type']) && ($_GET['encrypt_type'] == 'aes')){
                $this->encrypt_type = $_GET['encrypt_type'];
                $xmlstr = $this->DecryptMsg($xmlstr);
              }
              $xml = new SimpleXMLElement($xmlstr);
             foreach($xml as $key => $value) {
                $this->data[$key] = strval($value);
             }                   
        }
    }
    //解密消息
    public function DecryptMsg($from_xml){
        $pc = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->appId);
        $encryptMsg = '';
        $timeStamp  = $_GET['timestamp'];
        $msg_sign  = $_GET['msg_signature'];
        $nonce = $_GET["nonce"];
        $msg='';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        if ($errCode == 0) {
             return $msg;
        } else {
             return $errCode;
        }
    }
    //加密消息
    public function EncryptMsg($text){
        $timeStamp = time();
        $nonce = randCode(5,0);
        $pc = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->appId);
        $encryptMsg = '';
        $errCode = $pc->encryptMsg($text, $timeStamp, $nonce, $encryptMsg);
        if ($errCode == 0) {
            return $encryptMsg;
        } else {
            return $errCode;
        }
    }
    //接收信息
    public function request(){
        return $this->data;
    }
    //回复消息
    public function response($content, $type = 'text', $flag = 0){
       if (!isset($content) || empty($content)) {
            return 'success';
        }
        $this->data = array(
            'ToUserName' => $this->data['FromUserName'],
            'FromUserName' => $this->data['ToUserName'],
            'CreateTime' => time(),
            'MsgType' => $type
        );
        $this->$type($content);
        $this->data['FuncFlag'] = $flag;
        $xml                    = new SimpleXMLElement('<xml></xml>');
        $this->data2xml($xml, $this->data);
        $result = $xml->asXML();
        //加密
        if($this->encrypt_type == 'aes'){
         $result = $this->EncryptMsg($xml->asXML());
        }
         exit($result);
       
    }
    //消息转发到客服
    private function transfer_customer_service($content){
         //指定客服
        if(!empty($content)){
            $TransInfo['KfAccount'] = $content;
            $this->data['TransInfo'] = $TransInfo; 
        }
    }
    //回复文本消息
    private function text($content){
        $this->data['Content'] = $content;
    }
    //回复图片消息
    private function image($content){
        $image['MediaId'] = $content;
        $this->data['Image'] = $image;
    }
    //回复语音消息
    private function voice($content){
        $voice['MediaId'] = $content;
        $this->data['Voice'] = $voice;
    }
    //回复视频消息
    private function video($content){
        list($video['MediaId'], $video['Title'], $video['Description']) = $content;
        $this->data['Video'] = $video;
    }
    //回复音乐消息
    private function music($content){
        list($music['Title'], $music['Description'], $music['MusicUrl'], $music['HQMusicUrl']) = $content;
        $this->data['Music'] = $music;
    }
    //回复图文消息
    private function news($news){
        $articles = array();
        foreach ($news as $key => $value) {
            list($articles[$key]['Title'], $articles[$key]['Description'], $articles[$key]['PicUrl'], $articles[$key]['Url']) = $value;
            if ($key >= 9) {
                break;
            }
        }
        $this->data['ArticleCount'] = count($articles);
        $this->data['Articles']     = $articles;
    }
    private function data2xml($xml, $data, $item = 'item'){
        foreach ($data as $key => $value) {
            is_numeric($key) && $key = $item;
            if (is_array($value) || is_object($value)) {
                $child = $xml->addChild($key);
                $this->data2xml($child, $value, $item);
            } else {
                if (is_numeric($value)) {
                    $child = $xml->addChild($key, $value);
                } else {
                    $child = $xml->addChild($key);
                    $node  = dom_import_simplexml($child);
                    $node->appendChild($node->ownerDocument->createCDATASection($value));
                }
            }
        }
    }
    //自定验证
    public function auth(){
        $data = array($_GET['timestamp'],$_GET['nonce'],$this->token);
        $sign = $_GET['signature'];
        sort($data, SORT_STRING);
        $signature = sha1(implode($data));
        return $signature === $sign;
    }
}