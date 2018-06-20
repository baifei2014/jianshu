<?php
//加载GatewayClient。安装GatewayClient参见本页面底部介绍
// require_once '/your/path/GatewayClient/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use frontend\helpers\gateway\gatewayclient\vendor\workerman\gatewayclient\Gateway;
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
Gateway::$registerAddress = '127.0.0.1:1238';

// 假设用户已经登录，用户uid和群组id在session中
// $uid      = Yii::$app->user->identity->id;
$group_id = 123456;
// $group_id = $_SESSION['group'];
// client_id与uid绑定
// Gateway::bindUid($client_id, $uid);
// 加入某个群组（可调用多次加入多个群组）
Gateway::joinGroup($client_id, $group_id);
