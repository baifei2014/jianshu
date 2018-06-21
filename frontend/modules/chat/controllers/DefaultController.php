<?php

namespace frontend\modules\chat\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use frontend\helpers\Robot;
use frontend\helpers\SentMessage;

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
        return $this->render('bind', ['client_id' => $data['id']]);
    }
    public function actionSentmessage()
    {
        $data = Yii::$app->request->post();
        $user = User::find()->where(['id' => $data['id']])->one();
        $infor = [
            'uid' => $user['id'],
            'message' => $data['message'],
            'avatar' => $user['avatar'],
            'nickname' => $user['nickname'],
        ];
        SentMessage::sendToGroup(123456, $infor);
        if(self::ROBOT != false){
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
}
