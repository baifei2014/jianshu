<?php

namespace frontend\modules\nb\controllers;

use yii;
use yii\web\Controller;
use common\models\Articalset;
use common\models\Artical;
use common\models\Articalinfor;
use common\models\User;
use common\models\Focus;
use frontend\models\FocusForm;
use frontend\models\SetinforForm;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `nb` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {
        $articalset = Articalset::find()->with('auther', 'artical')->where(['id' => $id])->one();
        if(!$articalset){
            throw new NotFoundHttpException('您要找的页面不存在');
            
        }
        $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $id, 'type' => 'set'])->one();
        $setinfor = SetinforForm::getSetinfor($id);
        return $this->render('index', ['articalset' => $articalset, 'isfocus' => $isfocus, 'setinfor' => $setinfor]);
    }
    public function actionFnb()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = FocusForm::Focus($data['sid'], 'set');
            return json_encode($result);
        }
    }
    public function actionAdded($id)
    {
        if(Yii::$app->request->isAjax){
            $articals = Artical::find()->with('user')->where(['set_id' => $id])->orderBy('id desc')->all();
            return $this->renderPartial('added', ['articals' => $articals]);
        }
    }
    public function actionComment($id)
    {
        if(Yii::$app->request->isAjax){
            $articals = Articalinfor::find()->asArray()->with('artical')->where(['set_id' => $id])->orderBy('comment desc')->all();
            foreach ($articals as $key => $value) {
                $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                $articals[$key]['user'] = $user;
            }
            return $this->renderPartial('comment', ['articals' => $articals]);
        }
    }
    public function actionSeq($id)
    {
        if(Yii::$app->request->isAjax){
            $articals = Articalinfor::find()->asArray()->with('artical')->where(['set_id' => $id])->orderBy('like desc')->all();
            foreach ($articals as $key => $value) {
                $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                $articals[$key]['user'] = $user;
            }
            return $this->renderPartial('seq', ['articals' => $articals]);
        }
    }
}
