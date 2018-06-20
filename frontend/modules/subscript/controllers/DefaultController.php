<?php

namespace frontend\modules\subscript\controllers;

use yii;
use yii\web\Controller;
use common\models\Focus;
use common\models\Userbehavior;
use common\models\Like;
use common\models\Subjects;
use common\models\User;
use common\models\Articalset;
use common\models\Artical;
use common\models\Articalinfor;
use common\models\Comment;
use common\models\Includes;

/**
 * Default controller for the `subscript` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $focus = Focus::find()->asArray()->where(['u_id' => Yii::$app->user->identity->id])->all();
        foreach ($focus as $key => $value) {
            if($value['type'] == 'auther'){
                $user = User::find()->where(['id' => $value['f_id']])->one();
                $focus[$key]['result'] = $user;
            }
            if($value['type'] == 'subject'){
                $subject = Subjects::find()->asArray()->where(['id' => $value['f_id']])->one();
                $focus[$key]['result'] = $subject;
            }
            if($value['type'] == 'set'){
                $set = Articalset::find()->asArray()->where(['id' => $value['f_id']])->one();
                $focus[$key]['result'] = $set;
            }
        }
        return $this->render('index', ['focus' => $focus]);
    }
    public function actionTimeline()
    {
        // if(Yii::$app->request->isAjax){
            Focus::find()->where(['u_id' => Yii::$app->identity->id, 'type' => 'auther'])->all();
        //}
    }
    public function actionSubcircle()
    {
        if(Yii::$app->request->isAjax){
            $auther = [];
            $focus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'type' => 'auther'])->all();
            foreach ($focus as $key => $value) {
                $auther[] = $value['f_id'];
            }
            $userbehavior = Userbehavior::find()->with('user')->asArray()->where(['u_id' => $auther])->orderBy('id desc')->all();
            foreach ($userbehavior as $key => $value) {
                if($value['type'] == 'like'){
                    $like = Like::find()->asArray()->with('artical', 'articalinfor')->where(['id' => $value['o_id']])->one();
                    $user = User::find()->asArray()->where(['id' => $like['artical']['user_id']])->one();
                    $like['artical']['user'] = $user;
                    $userbehavior[$key]['result'] = $like;
                }
                if($value['type'] == 'comment'){
                    $comment = Comment::find()->asArray()->with('artical', 'bereplyer' ,'articalinfor')->where(['id' => $value['o_id']])->one();
                    $user = User::find()->asArray()->where(['id' => $comment['artical']['user_id']])->one();
                    $comment['artical']['user'] = $user;
                    $userbehavior[$key]['result'] = $comment;
                }
                if($value['type'] == 'focus'){
                    $focus = Focus::find()->asArray()->where(['id' => $value['o_id']])->one();
                    if($focus['type'] == 'auther'){
                        $infor = User::find()->with('userinfor')->asArray()->where(['id' => $focus['f_id']])->one();
                        $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $infor['id'], 'type' => 'auther'])->one();
                        $focus['infor'] = $infor;
                        $focus['isfocus'] = $isfocus;
                    }
                    if($focus['type'] == 'set'){
                        $infor = Articalset::find()->asArray()->where(['id' => $focus['f_id']])->one();
                        $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $infor['id'], 'type' => 'set'])->one();
                        $focus['infor'] = $infor;
                        $focus['isfocus'] = $isfocus;
                    }
                    if($focus['type'] == 'subject'){
                        $infor = Subjects::find()->asArray()->where(['id' => $focus['f_id']])->one();
                        $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $infor['id'], 'type' => 'subject'])->one();
                        $focus['infor'] = $infor;
                        $focus['isfocus'] = $isfocus;
                    }
                    $userbehavior[$key]['result'] = $focus;
                }
            }
            return $this->renderPartial('subcircle', ['userbehavior' => $userbehavior]);
        }
    }
    public function actionUser($id)
    {
        if(Yii::$app->request->isAjax){
            $user = User::find()->with('userexinfor')->where(['id' => $id])->one();
            return $this->renderPartial('user', ['user' => $user]);
        }
    }
    public function actionCatelog($keyword, $id)
    {
        if(Yii::$app->request->isAjax){
            if($keyword == 'subject_id'){
                $articals = Includes::find()->asArray()->with('artical')->where(['sid' => $id])->all();
                foreach ($articals as $key => $value) {
                    $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                    $articalinfor = Articalinfor::find()->where(['aid' => $value['artical']['id']])->one();
                    $articals[$key]['user'] = $user;
                    $articals[$key]['articalinfor'] = $articalinfor;
                }
                return $this->renderPartial('subcatelog', ['articals' => $articals]);
            }
            $articals = Artical::find()->with('user', 'articalinfor')->where([$keyword => $id])->all();
            return $this->renderPartial('catelog', ['articals' => $articals]);
        }
    }
    public function actionComment($keyword, $id)
    {
        if(Yii::$app->request->isAjax){
            if($keyword == 'subject_id'){
                $ids = [];
                $inarticals = Includes::find()->asArray()->where(['sid' => $id])->all();
                foreach ($inarticals as $key => $value) {
                    $ids[] = $value['aid'];
                }
                $articals = Articalinfor::find()->asArray()->with('artical')->where(['aid' => $ids])->orderBy('comment desc')->all();
                foreach ($articals as $key => $value) {
                    $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                    $articals[$key]['user'] = $user;
                }
                return $this->renderPartial('subcomment', ['articals' => $articals]);
            }
            $ids = [];
            $setids = Articalset::find()->where([$keyword => $id])->all();
            foreach ($setids as $key => $value) {
                $ids[] = $value['id'];
            }
            $articals = Articalinfor::find()->asArray()->with('artical')->where(['set_id' => $ids])->orderBy('comment desc')->all();
            foreach ($articals as $key => $value) {
                $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                $articals[$key]['user'] = $user;
            }
            return $this->renderPartial('comment', ['articals' => $articals]);
        }
    }
    public function actionSeq($keyword, $id)
    {
        if(Yii::$app->request->isAjax){
            if($keyword == 'subject_id'){
                $ids = [];
                $inarticals = Includes::find()->asArray()->where(['sid' => $id])->all();
                foreach ($inarticals as $key => $value) {
                    $ids[] = $value['aid'];
                }
                $articals = Articalinfor::find()->asArray()->with('artical')->where(['aid' => $ids])->orderBy('like desc')->all();
                foreach ($articals as $key => $value) {
                    $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                    $articals[$key]['user'] = $user;
                }
                return $this->renderPartial('subseq', ['articals' => $articals]);
            }
            $ids = [];
            $setids = Articalset::find()->where([$keyword => $id])->all();
            foreach ($setids as $key => $value) {
                $ids[] = $value['id'];
            }
            $articals = Articalinfor::find()->asArray()->with('artical')->where(['set_id' => $ids])->orderBy('like desc')->all();
            foreach ($articals as $key => $value) {
                $user = User::find()->where(['id' => $value['artical']['user_id']])->one();
                $articals[$key]['user'] = $user;
            }
            return $this->renderPartial('seq', ['articals' => $articals]);
        }
    }
    public function actionSubject($id)
    {
        if(Yii::$app->request->isAjax){
            $subject = Subjects::find()->where(['id' => $id])->one();
            return $this->renderPartial('subject', ['subject' => $subject]);
        }
    }
    public function actionSet($id)
    {
        if(Yii::$app->request->isAjax){
            $articalset = Articalset::find()->where(['id' => $id])->one();
            return $this->renderPartial('set', ['articalset' => $articalset]);
        }
    }
}
