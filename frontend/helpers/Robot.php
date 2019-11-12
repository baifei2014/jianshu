<?php 
namespace frontend\helpers;
// -----------------------------------------------
// 使用聚合问答机器人API
// 问答机器人调用
// 在线接口文档: http://www.juhe.cn/docs/112
// -----------------------------------------------

class Robot
{
    const APPKEY = '4d181280d739ecd2cbe4b8722d901d9c';
    const URL = 'http://op.juhe.cn/robot/index';
    const ID = 0;
    const AVATAR = 'statics/images/avatar/robot.jpeg';
    const NICKNAME = '小艾';


    /** 
     * @param string $infor [用户发送的消息]
     * @param int $userid [发送消息用户的id]
     */
    public static function robotReply($info, $userid)
    {
        if(mb_strlen($info, 'utf-8') > 30){
            $info = mb_substr($info, 0, 30, 'utf-8');
        }
        $result = self::getMessage($info, $userid);
        if($result){
            if($result['error_code'] == 0){
                $message = $result['result']['text'];
            }else if($result['error_code'] == 211201){
                $message = '不要说数字好不好，我不喜欢数学';
            }else{
                $message = '我好像病了，要去休息了';
            }
        }else{
            $message = '我好像病了，要去休息了12';
        }
        $infor = [
            'uid' => self::ID,
            'message' => $message,
            'avatar' => self::AVATAR,
            'nickname' => self::NICKNAME,
        ];
        return $infor;
    }
    /** 
     * @param string $infor [用户发送的消息]
     * @param int $userid [发送消息用户的id]
     */
    public static function getMessage($info, $userid)
    {
        $params = [
            'key' => self::APPKEY,               // 申请的本接口专用api
            'info' => $info,                  // 要发给机器人的内容，不要超过30个字符
            // 'userid' => $userid,                 // 1~32位,此userid针对您自己的每一个用户，用于上下文关联
        ];
        $paramstring = http_build_query($params);
        $content = self::likecurl(self::URL, $paramstring);
        $result = json_decode($content, true);
        return $result;
    }
    /**
     * 请求接口返回内容
     * @param string $url [请求的url地址]
     * @param string $params [请求的参数]
     * @param int $ispost [是否采用POST形式]
     * @return string
     */
    public static function likeCurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = [];
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}
