<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\UserinforForm;
use frontend\helpers\Image;
use frontend\helpers\Test;
use common\models\Userinfor;
use frontend\models\UsersetForm;
use common\models\User;

/**
 * Default controller for the `user` module
 */
class SettingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['basic', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['basic'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $formdata = Yii::$app->request->post();
            $time = time();
            if($response = Image::crop($formdata['imgurl'], $time)){
                if(UserinforForm::saveAvatar($filename = '/statics/images/avatar/'.$time.'.jpg')){
                    return json_encode($response);
                }
            }
        }
    }
    public function actionQrcode()
    {
        if(Yii::$app->request->isAjax){
            $formdata = Yii::$app->request->post();
            $time = time();
            if($response = Image::qrCrop($formdata['imgurl'], $time)){
                if(UserinforForm::saveQrcode($filename = '/statics/images/qrcode/'.$time.'.jpg')){
                    return json_encode($response);
                }
            }
        }
    }
    public function actionDeleteqr()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if($data['id'] != Yii::$app->user->identity->id){
                $result = [
                    'status' => 'error',
                ];
                return json_encode($result);
            }
            $userinfor = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
            if(!$userinfor['qrcode']){
                $result = [
                    'status' => 'error',
                ];
                return json_encode($result);
            }
            if(file_exists($userinfor['qrcode'])){
                unlink($userinfor['qrcode']);
            }
            $userinfor->qrcode = '';
            if($userinfor->save()){
                $result = [
                    'status' => 'success',
                ];
                return json_encode($result);
            }
        }
    }
    public function actionBasic()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $userinfor = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $model = new UsersetForm;
        $userinformodel = new UserinforForm;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            // print_r(Yii::$app->request->post());die();
            if($model->saveNickname()){
                $model = new UsersetForm;
                $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
                $session = Yii::$app->session;
               // set a flash message named as "greeting"
               $session->setFlash('success', '保存成功');
            }
        }
        return $this->render('basic', ['model' => $model, 'userinfor' => $userinfor, 'userinformodel' => $userinformodel, 'user' => $user]);
    }
    public function actionNickname()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = UsersetForm::saveNickname($data['value']);
            return json_encode($result);
        }
    }
    public function actionSex()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = UserinforForm::saveSex($data['value']);
            return json_encode($result);
        }
    }
    public function actionWeb()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = UserinforForm::saveWeb($data['value']);
            return json_encode($result);
        }
    }
    public function actionSummary()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = UserinforForm::saveSummary($data['value']);
            return json_encode($result);
        }
    }
    public function actionProfile()
    {
        $model = new UserinforForm;
        return $this->render('profile', ['model' => $model]);
    }
    public function actionTest()
    {
        $result = UserinforForm::checkweb('http://');
        print_r($result);die();
    }
}
