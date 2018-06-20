<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;
use common\models\User;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'hyii2\avatar\CropAction',
                'config'=>[
                    'bigImageWidth' => '200',     //大图默认宽度
                    'bigImageHeight' => '200',    //大图默认高度
                    'middleImageWidth'=> '100',   //中图默认宽度
                    'middleImageHeight'=> '100',  //中图图默认高度
                    'smallImageWidth' => '50',    //小图默认宽度
                    'smallImageHeight' => '50',   //小图默认高度
                    //头像上传目录（注：目录前不能加"/"）
                    'uploadPath' => 'uploads/avatar',
                ]
            ]
        ]; 
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = User::find()->where(['id' => 1])->one();
        return $this->render('index',['user' => $user]);
    }
}
