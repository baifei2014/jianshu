<?php 
namespace frontend\helpers;
//加载GatewayClient。安装GatewayClient参见本页面底部介绍
// require_once '/your/path/GatewayClient/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use frontend\helpers\gateway\gatewayclient\vendor\workerman\gatewayclient\Gateway;
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
// Gateway::$registerAddress = '127.0.0.1:1238';
// $group_id = 123456;
// 向任意uid的网站页面发送数据
// Gateway::sendToUid($uid, $message);
// 向任意群组的网站页面发送数据
// Gateway::sendToGroup($group_id, json_encode(['uid' => $uid, 'message' => $message, 'avatar' => $avatar, 'nickname' => $nickname]));
class SentMessage
{
    const IPPORT = '47.98.130.177:1238';        // 设置GatewayWorker服务的Register服务ip和端口
    /**
     * @param int $group_id [群组的id]
     * @param array $infor [发送消息的内容]
     */
    public static function sendToGroup($group_id = 123456, $infor = [])
    {
        Gateway::$registerAddress = self::IPPORT;
        Gateway::sendToGroup($group_id, json_encode(['uid' => $infor['uid'], 'message' => $infor['message'], 'avatar' => $infor['avatar'], 'nickname' => $infor['nickname']]));
    }
}
