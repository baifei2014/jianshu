<?php

namespace frontend\modules\chat\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
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
    public function actionIndex()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        return $this->render('index', ['user' => $user]);
    }
    public function actionBind()
    {
        $data = Yii::$app->request->post();
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';

        // 假设用户已经登录，用户uid和群组id在session中
        // $uid      = Yii::$app->user->identity->id;
        $group_id = 123456;
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
        $user = User::find()->where(['id' => $data['id']])->one();
        $info = [
            'uid' => $user['id'],
            'message' => $data['message'],
            'avatar' => $user['avatar'],
            'nickname' => $user['nickname'],
            'created_at' => time(),
        ];
        SentMessage::sendToGroup(123456, $info);

        $len = Yii::$app->redis->lpush('info', json_encode($info));
        if(Yii::$app->redis->llen('info') > 50) {
            Yii::$app->redis->ltrim('info', 0, 49);
        }

        return json_encode([
            'code' => 1,
            'msg' => $len
        ]);
        if(self::ROBOT){
            $infor = $message = Robot::robotReply($data['message'], $user['id']);
            SentMessage::sendToGroup(123456, $infor);
        }
    }
    public function actionRobot()
    {
        $message = Robot::getMessage('你好', 5);
        print_r($message);die();
        return $this->render('robot');
    }
    public function actionTest()
    {
        return $this->render('test');
    }
    public function actionGetMessage()
    {
        if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $page = $data['info_page'];

            $len = Yii::$app->redis->llen('info');

            if($page > $len || $len == 0) {
                return json_encode([
                    'code' => 0,
                    'msg' => '没有更多消息'
                ]);
            }

            $infos_json = Yii::$app->redis->lrange('info', $page, $page + 9);

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
        }
    }
}
