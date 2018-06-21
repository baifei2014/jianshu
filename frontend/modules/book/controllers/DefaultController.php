<?php

namespace frontend\modules\book\controllers;

use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ArticalsetForm;
use common\models\Articalset;
use frontend\models\ArticalForm;
use frontend\models\ArticaltagForm;
use yii\web\UploadedFile;
use frontend\helpers\Image;

/**
 * Default controller for the `book` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
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
        $model = new ArticalForm;
        $articalset = Articalset::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        if($model->load(Yii::$app->request->post())){
            // print_r(Yii::$app->request->post());die();
            $model->img = UploadedFile::getInstance($model, 'img');
            $time = time();
            $imagesrc = Yii::$app->basePath.'/web/statics/uploads/'.$time.'.'.$model->img->extension;
            // print_r($model->img);die();
            if($model->img && $model->img->saveAs($imagesrc)){
                $model->img = 'statics/uploads/'.$time.'.'.$model->img->extension;
                $model->created_at = $time;
                $model->updated_at = $time;
            }
            if($model->saveArtical() ){
                $model = new ArticalForm;
            }
            return $this->refresh();
        }
        return $this->renderPartial('index', ['model' => $model, 'articalset' => $articalset]);
    }
    public function actionArticalset()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            return ArticalsetForm::savearticalset($data['articalset']);
            // return '哈哈哈';
        }
    }
    public function actionTest()
    {
        $data = ArticalsetForm::savearticalset('python');
        echo empty($data);
    }
}
