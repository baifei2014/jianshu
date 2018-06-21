<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use common\models\Userinfor;
use common\models\Userbehavior;
use common\models\User;
use common\models\Comment;
use common\models\Artical;
use common\models\Focus;
use frontend\models\FocusForm;
use common\models\Subjects;
use common\models\Like;
use common\models\Articalset;
use frontend\models\UserexinforForm;
use frontend\models\SetinforForm;
use frontend\models\SubinforForm;
use frontend\models\UserbehaviorForm;
use yii\web\NotFoundHttpException;
use common\models\Userexinfor;
use common\models\Setinfor;
use common\models\Subinfor;

/**
 * Default controller for the `user` module
 */
class HomeController extends Controller
{
    public function actionU($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        if(!$user){
            throw new NotFoundHttpException('您要找的内容不存在');
        }
        $userinfor = Userinfor::find()->where(['uid' => $id])->one();
        $focus = Focus::find()->asArray()->where(['u_id' => $id])->all();
        $fans = Focus::find()->asArray()->where(['f_id' => $id])->all();
        $subjects = Subjects::find()->orderBy('id desc')->where(['uid' => $id])->all();
        if(Yii::$app->user->isGuest){
            $isfans = null;
        }else{
            $isfans = Focus::find()->asArray()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $id, 'type' => 'auther'])->one();
        }
        $sets = Articalset::find()->with('articalset')->where(['uid' => $id])->all();
        $setids = [];
        foreach ($sets as $key => $value) {
            $setids[] = $value['id'];
        }
        $issets = Artical::find()->where(['set_id' => $setids])->all();
        $uexinfor = Userexinfor::find()->where(['user_id' => $id])->one();
        return $this->render('u', ['user' => $user, 'isfans' => $isfans, 'subjects' => $subjects, 'userinfor' => $userinfor, 'focus' => $focus, 'fans' => $fans, 'sets' => $sets, 'issets' => $issets, 'uexinfor' => $uexinfor]);
    }
    public function actionSubscriptions($id)
    {
        if(Yii::$app->request->isAjax){
            $focus = Focus::find()->asArray()->with('subject', 'set', 'subjectinclu', 'setinclu')->where(['and', 'u_id = '.$id, ['or', 'type = "set"', 'type = "subject"']])->orderBy('id desc')->all();
            foreach ($focus as $key => $value) {
                $isfocus = Focus::find()->where(['and', 'u_id = '.Yii::$app->user->identity->id, ['and', 'f_id = '.$value['f_id'], 'type = "'.$value['type'].'"']])->one();
                $focus[$key]['isfocus'] = $isfocus;
                if($value['type'] == 'set'){
                    $user = User::find()->where(['id' => $value['set']['uid']])->one();
                    $infor = Setinfor::find()->where(['sid' => $value['f_id']])->one();
                    $focus[$key]['result'] = $infor;
                    $focus[$key]['user'] = $user;
                }
                if($value['type'] == 'subject'){
                    $user = User::find()->where(['id' => $value['subject']['uid']])->one();
                    $infor = Subinfor::find()->where(['sid' => $value['f_id']])->one();
                    $focus[$key]['result'] = $infor;
                    $focus[$key]['user'] = $user;
                }
            }
            return $this->renderPartial('subitem', ['focus' => $focus, 'ownid' => $id]);
        }
        $user = User::find()->where(['id' => $id])->one();
        $userinfor = Userinfor::find()->where(['uid' => $id])->one();
        $focus = Focus::find()->asArray()->where(['u_id' => $id])->all();
        $fans = Focus::find()->asArray()->where(['f_id' => $id])->all();
        $subjects = Subjects::find()->orderBy('id desc')->where(['uid' => $id])->all();
        $isfans = Focus::find()->asArray()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $id, 'type' => 'auther'])->one();
        $sets = Articalset::find()->with('articalset')->where(['uid' => $id])->all();
        $setids = [];
        foreach ($sets as $key => $value) {
            $setids[] = $value['id'];
        }
        $issets = Artical::find()->where(['set_id' => $setids])->all();
        return $this->render('subscriptions', ['user' => $user, 'isfans' => $isfans, 'subjects' => $subjects, 'userinfor' => $userinfor, 'focus' => $focus, 'fans' => $fans, 'sets' => $sets, 'issets' => $issets]);
    }
    public function actionSubitem($id)
    {
        // $focus = Focus::find()->with('subject', 'set')->where(['and', 'u_id = '.$id, ['or', 'type = set', 'type = subject']])->orderBy('id desc')->all();
        $focus = Focus::find()->asArray()->with('subject', 'set')->where(['u_id' => 1, 'type' => ['subject', 'set']])->orderBy('id desc')->all();
        foreach ($focus as $key => $value) {
            if($value['type'] == 'set'){
                $infor = Setinfor::find()->where(['sid' => $value['f_id']])->one();
            }
            if($value['type'] == 'subject'){
                $infor = Subinfor::find()->where(['sid' => $value['f_id']])->one();
            }
            $focus[$key]['result'] = $infor;
        }
        return $this->renderPartial('subitem', ['focus' => $focus, 'ownid' => $id]);
    }
    public function actionLikenotes($id)
    {
        if(Yii::$app->request->isAjax){
            $articals = Like::find()->asArray()->with('artical', 'articalinfor', 'auther')->where(['u_id' => $id])->all();
            return $this->renderPartial('likeitem', ['articals' => $articals]);
        }
        $user = User::find()->where(['id' => $id])->one();
        $userinfor = Userinfor::find()->where(['uid' => $id])->one();
        $focus = Focus::find()->asArray()->where(['u_id' => $id])->all();
        $fans = Focus::find()->asArray()->where(['f_id' => $id])->all();
        $subjects = Subjects::find()->orderBy('id desc')->where(['uid' => $id])->all();
        $isfans = Focus::find()->asArray()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $id, 'type' => 'auther'])->one();
        $sets = Articalset::find()->with('articalset')->where(['uid' => $id])->all();
        $setids = [];
        foreach ($sets as $key => $value) {
            $setids[] = $value['id'];
        }
        $issets = Artical::find()->where(['set_id' => $setids])->all();
        return $this->render('likenotes', ['user' => $user, 'isfans' => $isfans, 'subjects' => $subjects, 'userinfor' => $userinfor, 'focus' => $focus, 'fans' => $fans, 'sets' => $sets, 'issets' => $issets]);
    }
    public function actionTimeline($id)
    {
        if(Yii::$app->request->isAjax){
        
            $userbehavior = UserbehaviorForm::getUserBehavior($id);
            // print_r($userbehavior);die();
            return $this->renderPartial('timeline', ['userbehavior' => $userbehavior]);

        }
    }
    public function actionTest()
    {
        $userbehavior = UserbehaviorForm::getUserBehavior(2);
        print_r($userbehavior);die();
    }
    public function actionArtical($id)
    {
        if(Yii::$app->request->isAjax){
            $articals = Artical::find()->asArray()->with('articalinfor', 'user')->where(['user_id' => $id])->all();
            return $this->renderPartial('artical', ['articals' => $articals]);
        }
    }
    /** 
    * 关注的用户
    */
    
    public function actionFocus($id)
    {
        if(Yii::$app->request->isAjax){
            $focus = Focus::find()->asArray()->with('userfocus', 'userfoinfor')->where(['u_id' => $id, 'type' => 'auther'])->all();
            if(Yii::$app->user->isGuest){
                foreach ($focus as $key => $value) {
                    $focus[$key]['isfocus'] = null;
                }
            }else{
                foreach ($focus as $key => $value) {
                    $result = Focus::find()->asArray()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $value['f_id'], 'type' => 'auther'])->one();
                    $focus[$key]['isfocus'] = $result;
                }
            }
            return $this->renderPartial('focus', ['focus' => $focus]);
        }
    }
    /**
    * 粉丝用户
    */
    public function actionFans($id)
    {
        if(Yii::$app->request->isAjax){
            $fans = Focus::find()->asArray()->with('userfans', 'userioinfor')->where(['f_id' => $id, 'type' => 'auther'])->all();
            if(Yii::$app->user->isGuest){
                foreach ($fans as $key => $value) {
                    $fans[$key]['isfocus'] = null;
                }
            }else{
                foreach ($fans as $key => $value) {
                    $result = Focus::find()->asArray()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $value['u_id'], 'type' => 'auther'])->one();
                    $fans[$key]['isfocus'] = $result;
                }
            }
            return $this->renderPartial('fans', ['fans' => $fans]);
        }
    }
    // 关注或取关
    public function actionOfocus()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $result = FocusForm::Focus($data['uid'], $data['type']);
            return json_encode($result);
        }
    }
}
