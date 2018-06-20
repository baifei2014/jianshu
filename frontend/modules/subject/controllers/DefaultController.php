<?php

namespace frontend\modules\subject\controllers;

use yii;
use yii\web\Controller;
use frontend\models\SubjectsForm;
use common\models\Subjects;
use yii\web\UploadedFile;
use frontend\helpers\Image;
use frontend\models\FocusForm;
use common\models\Focus;
use common\models\Artical;
use common\models\Includes;
use frontend\models\IncludesForm;
use frontend\models\ArticalForm;
use common\models\Articalinfor;
use common\models\User;
use frontend\models\SubinforForm;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `subject` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionNew()
    {
        $model = new SubjectsForm;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->file = UploadedFile::getInstance($model, 'file');
            $extension = $model->file->extension;
            if($extension != 'jpg' && $extension != 'png' && $extension != 'gif' && $extension != 'jpeg'){
                return false;
            }
            $time = time();
            $imagesrc = 'statics/images/sublabels/'.$time.'.'.$model->file->extension;
            if($model->file){
                if($model->file->saveAs($imagesrc)){
                    Image::cropSubject($imagesrc, $time);
                }
                $model->labelimg = $imagesrc;
                $model->created_at = $time;
            }
            if($model->saveSubject()){
                $model = new SubjectsForm;
            }
            return $this->refresh();
        }
        return $this->render('new', ['model' => $model]);
    }
    public function actionC($id)
    {
        $subject = Subjects::find()->where(['code' => $id])->one();
        if(!$subject){
            throw new NotFoundHttpException('您要找的内容不存在');
        }
        $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $subject['id'], 'type' => 'subject'])->one();
        $subinfor = SubinforForm::getSubinfor($subject['id']);
        return $this->render('c', ['subject' => $subject, 'isfocus' => $isfocus, 'subinfor' => $subinfor]);
    }
    /**
     * 操作关注专题
     */
    public function actionFc()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = FocusForm::Focus($data['id'], 'subject');
            return json_encode($result);
        }
    }
    public function actionEdit($id)
    {
        if(!Yii::$app->user->isGuest){
            $subject = Subjects::find()->where(['code' => $id])->one();
            if(Yii::$app->user->identity->id == $subject['uid']){
                $model = new SubjectsForm;
                if($model->load(Yii::$app->request->post()) && $model->validate()){
                    $model->file = UploadedFile::getInstance($model, 'file');
                    if($model->file){
                        $extension = $model->file->extension;
                        if($extension != 'jpg' && $extension != 'png' && $extension != 'gif' && $extension != 'jpeg'){
                            return false;
                        }
                        $time = time();
                        $imagesrc = 'statics/images/sublabels/'.$time.'.'.$model->file->extension;
                        $subject = Subjects::find()->where(['code' => $id])->one();
                        if(file_exists($subject['labelimg'])){
                            unlink($subject['labelimg']);
                        }
                        if($model->file->saveAs($imagesrc)){
                            Image::cropSubject($imagesrc, $time);
                        }
                        $model->labelimg = $imagesrc;
                        $model->updated_at = $time;
                    }
                    if($model->updateSubject($id)){
                        $model = new SubjectsForm;
                    }
                    return $this->refresh();
                }
                $subject = Subjects::find()->where(['code' => $id])->one();
                return $this->render('edit', ['model' => $model, 'subject' => $subject]);
            }else{
                throw new NotFoundHttpException("您要找的内容不存在");
                
            }
        }
    }
    public function actionArtical()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if(isset($data['keyword'])){
                $articals = ArticalForm::findBykeyword($data['keyword'], $data['sid']);
            }else{
                $articals = Artical::find()->asArray()->where(['user_id' => Yii::$app->user->identity->id])->all();
                foreach ($articals as $key => $value) {
                    $includes = Includes::find()->asArray()->where(['aid' => $value['id'], 'sid' => $data['sid']])->one();
                    $articals[$key]['includes'] = $includes;
                }
            }
            $subject = Subjects::find()->where(['id' => $data['sid'], 'uid' => Yii::$app->user->identity->id])->one();
            return $this->renderPartial('artical', ['articals' => $articals, 'sid' => $data['sid'], 'subject' => $subject]);
        }
    }
    public function actionInclude()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = IncludesForm::saveIncludes($data['aid'], $data['sid']);
            return json_encode($result);
        }
    }
    public function actionAdded($id)
    {
        if(Yii::$app->request->isAjax){
                $includes = Includes::find()->where(['sid' => $id, 'status' => [1, 2]])->all();
                $aids = [];
                foreach ($includes as $key => $value) {
                    $aids[] = $value['aid'];
                }
                $aids = array_unique($aids);
                $articals = Artical::find()->with('user')->where(['id' => $aids])->orderBy('id desc')->all();
                return $this->renderPartial('added', ['articals' => $articals]);
        }
    }
    public function actionComment($id)
    {
        if(Yii::$app->request->isAjax){
            $includes = Includes::find()->where(['sid' => $id, 'status' => [1, 2]])->all();
            $aids = [];
            foreach ($includes as $key => $value) {
                $aids[] = $value['id'];
            }
            $aids = array_unique($aids);
            $articals = Articalinfor::find()->asArray()->with('artical')->where(['aid' => $aids])->orderBy('comment desc')->all();
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
            $includes = Includes::find()->where(['sid' => $id, 'status' => [1, 2]])->all();
            $aids = [];
            foreach ($includes as $key => $value) {
                $aids[] = $value['id'];
            }
            $aids = array_unique($aids);
            $articals = Articalinfor::find()->asArray()->with('artical')->where(['aid' => $aids])->orderBy('like desc')->all();
            foreach ($articals as $key => $value) {
                $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                $articals[$key]['user'] = $user;
            }
            return $this->renderPartial('seq', ['articals' => $articals]);
        }
    }
}
