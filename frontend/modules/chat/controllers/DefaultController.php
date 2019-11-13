<?php

namespace frontend\modules\chat\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use common\models\Chatroom;
use frontend\helpers\Robot;
use frontend\helpers\SentMessage;
use frontend\helpers\gateway\gatewayclient\vendor\workerman\gatewayclient\Gateway;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    const ROBOT = false;
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    public function actionChatRooms()
    {
        $chatrooms = Chatroom::find()->where(['is_delete' => 0])->all();
        $result = [];
        foreach ($chatrooms as $chatroom) {
            $messageKey = $this->getMessageCacheKey($chatroom['id']);
            $lastMessage = Yii::$app->redis->lrange($messageKey, 0, 0);
            if (! empty($lastMessage)) {
                $message = json_decode(current($lastMessage), true);
                $content = $message['message'];
                if (date('Y-m-d H:i:s', $message['created_at']) > date('Y-m-d 0:0:0')) {
                    $time = date('H:i:s', $message['created_at']);
                } elseif (date('Y-m-d H:i:s', $message['created_at']) > date('Y-m-d 0:0:0', strtotime('-1 day'))) {
                    $time = '昨天';
                } else {
                    $time = date('m-d', $message['created_at']);
                }
            }
            $result[] = [
                'id' => $chatroom['id'],
                'room_name' => $chatroom['room_name'],
                'avatar' => $chatroom['avatar'],
                'content' => $content ?? '',
                'time' => $time ?? ''
            ];
        }

        return json_encode($result);
    }


    public function actionIndex()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        return $this->render('index', ['user' => $user]);
    }
    public function actionBind()
    {
        $data = Yii::$app->request->post();
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '47.98.130.177:1238';

        // 假设用户已经登录，用户uid和群组id在session中
        // $uid      = Yii::$app->user->identity->id;
        $group_id = $data['room_id'];
        $client_id = $data['id'];
        // $group_id = $_SESSION['group'];
        // client_id与uid绑定
        // Gateway::bindUid($client_id, $uid);
        // 加入某个群组（可调用多次加入多个群组）
        if(Gateway::joinGroup($client_id, $group_id)) {
            return json_encode([
                'code' => 1,
                'msg' => '连接成功'
            ]);
        }
    }
    public function actionSentmessage()
    {
        $data = Yii::$app->request->post();
        $roomId = $data['room_id'];
        $user = User::find()->where(['id' => $data['id']])->one();
        $info = [
            'uid' => $user['id'],
            'message' => $data['message'],
            'avatar' => $user['avatar'],
            'nickname' => $user['nickname'],
            'created_at' => time(),
        ];
        SentMessage::sendToGroup($roomId, $info);

        $redisMessageKey = $this->getMessageCacheKey($roomId);
        $len = Yii::$app->redis->lpush($redisMessageKey, json_encode($info));
        // if(Yii::$app->redis->llen($redisMessageKey) > 50) {
        //     Yii::$app->redis->ltrim($redisMessageKey, 0, 49);
        // }

        if(self::ROBOT){
            $infor = $message = Robot::robotReply($data['message'], $user['id']);
            Yii::$app->redis->lpush($redisMessageKey, json_encode($infor));
            SentMessage::sendToGroup($roomId, $infor);
        }

        return json_encode([
            'code' => 1,
            'msg' => $len
        ]);
    }

    private function getMessageCacheKey($value)
    {
        return 'message:' . $value;
    }

    public function actionRobot()
    {
        $message = Robot::getMessage('你好', 5);
        return $this->render('robot');
    }
    public function actionTest()
    {
        return $this->render('test');
    }
    public function actionGetMessage()
    {
        // if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $roomId = $data['room_id'];
            $redisMessageKey = $this->getMessageCacheKey($roomId);
            $page = $data['info_page'];

            $len = Yii::$app->redis->llen($redisMessageKey);

            if($page > $len || $len == 0) {
                return json_encode([
                    'code' => 0,
                    'msg' => '没有更多消息'
                ]);
            }

            $infos_json = Yii::$app->redis->lrange($redisMessageKey, $page, $page + 9);

            $infos = [];
            foreach ($infos_json as  $info) {
                $pend_info = json_decode($info);
                $infos[] = $pend_info;
            }

            if($page + 10 >= $len) {
                return json_encode([
                    'code' => -1,
                    'infos' => $infos
                ]);
            } else {
                return json_encode([
                    'code' => 1,
                    'infos' => $infos
                ]);
            }
        // }
    }
}
