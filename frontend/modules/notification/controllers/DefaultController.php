<?php

namespace frontend\modules\notification\controllers;

use yii;
use yii\web\Controller;
use common\models\Artical;
use common\models\Comment;
use frontend\models\CommentForm;
use common\models\Subjects;
use frontend\models\IncludesForm;
use common\models\Focus;
use common\models\Like;
use frontend\helpers\Sort;
use common\models\Includes;
use common\models\Infor;
use common\models\Articalset;

/**
 * Default controller for the `notification` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $subjects = Subjects::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        $sids = [];
        foreach ($subjects as $key => $value) {
            $sids[] = $value['id'];
        }
        $includes = Includes::find()->where(['sid' => $sids, 'status' => 3])->all();
        $contri = count($includes);
        return $this->render('index', ['infor' => $infor, 'contri' => $contri]);
    }
    public function actionComment()
    {
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        // 评论消息有几类
        // 1, 评论我的文章的
        // 2, 我是一级评论艾特回复我或评论的
        // 3, 在别人评论下艾特回复我的
        // 同时自己回复或评论的不显示

        // 获取评论消息可以通过3中类型
        // 1，获取所有以我文章id为aid的评论
        // 2，获取所有以我一级评论为p_id的评论
        // 3，获取所有bereplyer为我的昵称并且user_id不是我的评论
        // 这三种情况会有重复，但差集即为所有评论消息

        // 获取我发表文章的id
        $articals = Artical::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        $aids = [];
        foreach ($articals as $key => $value) {
            $aids[] = $value['id'];
        }

        // 获取2, 3情况下的父评论id
        $ucomments = Comment::find()->where(['user_id' => Yii::$app->user->identity->id, 'p_id' => 0])->all();
        $rcomments = Comment::find()->where(['and', 'bereplyer = "'.Yii::$app->user->identity->nickname.'"', 'user_id != '.Yii::$app->user->identity->id.''])->all();
        $cids = [];
        foreach ($ucomments as $key => $value) {
            $cids[] = $value['id'];
        }
        foreach ($rcomments as $key => $value) {
            $cids[] = $value['p_id'];
        }

        $comments = Comment::find()->with('user', 'artical', 'pcomment')->where(['and', 'user_id != '.Yii::$app->user->identity->id.'', ['in', 'a_id', $aids]])->orwhere(['and', 'user_id != '.Yii::$app->user->identity->id.'', ['in', 'p_id', $cids]])->orderBy('id desc')->all();
        $model = new CommentForm;
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $commentinfor = $infor['comments'];
        $infor->comments = 0;
        $infor->commentstime = $infor->commentsuptime;
        $infor->save();
        return $this->renderPartial('comment', ['comments' => $comments, 'model' => $model, 'infor' => $infor, 'commentinfor' => $commentinfor]);
    }
    public function actionReply($p_id  = '', $a_id = '', $user_id)
    {
        $model = new CommentForm;
        if($model->load(Yii::$app->request->post())){
            $model->p_id = $p_id ? $p_id : 0;
            $model->a_id = $a_id;
            $model->user_id = $user_id;
            if($model->saveComment()){
                return $this->redirect(['default/index']);
            }
        }
    }
    public function actionRequests()
    {
        $subjects = Subjects::find()->with('includes')->where(['uid' => Yii::$app->user->identity->id])->all();
        return $this->renderPartial('requests', ['subjects' => $subjects]);
    }
    public function actionAllsubmissions()
    {
        $includes = IncludesForm::findUntreadedRequests();
        return $this->renderPartial('allsubmissions', ['includes' => $includes]);
    }
    /**
    * 需要两个参数
    * id参数
    * name 参数
    */
    public function actionSubmissions()
    {
        $data = Yii::$app->request->get();
        $includes = IncludesForm::findCommonrequests($data['id']);
        return $this->renderPartial('submissions', ['data' => $data, 'includes' => $includes]);
    }
    public function actionUntreated()
    {
        $data = Yii::$app->request->get();
        $includes = IncludesForm::findUntreatedBysubject($data['id']);
        return $this->renderPartial('untreated', ['data' => $data, 'includes' => $includes]);
    }
    // 喜欢自己文章的记录
    public function actionLikes()
    {
        $likes = Like::find()->with('user', 'artical')->orderBy('id desc')->where(['and', 'wid = '.Yii::$app->user->identity->id, 'u_id != '.Yii::$app->user->identity->id])->all();
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $likeinfor = $infor['likes'];
        $infor->likes = 0;
        $infor->likestime = $infor->likesuptime;
        $infor->save();
        $lis = Like::find()->where(['and', 'u_id != '.Yii::$app->user->identity->id, 'wid = '.Yii::$app->user->identity->id])->all();
        return $this->renderPartial('likes', ['likes' => $likes, 'likeinfor' => $likeinfor]);
    }
    public function actionFollows()
    {
        $follows = Focus::find()->with('userfans')->where(['f_id' => Yii::$app->user->identity->id, 'type' => 'auther'])->all();
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $followsinfor = $infor['follows'];
        $infor->follows = 0;
        $infor->followstime = $infor->followsuptime;
        $infor->save();
        return $this->renderPartial('follows', ['follows' => $follows, 'followsinfor' => $followsinfor]);
    }
    // 其他消息
    // 关注文集或专题
    // 文章被拒或收录
    // 自己的文章被添加进别人的专题
    public function actionOthers()
    {
        $ownsubjects = Subjects::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        $ownsets = Articalset::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        $sidss = [];
        foreach ($ownsubjects as $key => $value) {
            $sidss[] = $value['id'];
        }
        foreach ($ownsets as $key => $value) {
            $sidss[] = $value['id'];
        }
        $oinfors = Focus::find()->orderBy('id desc')->asArray()->with('subject', 'set', 'user')->where(['and', 'u_id != '.Yii::$app->user->identity->id, ['or', 'type = "subject"', 'type = "set"']])->andWhere(['f_id' => $sidss])->all();
        foreach ($oinfors as $key => $value) {
            $oinfors[$key]['tag'] = 'focus';
        }
        // print_r($oinfors);die();
        $ownarticals = Artical::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        $aids = [];
        foreach ($ownarticals as $key => $value) {
            $aids[] = $value['id'];
        }
        $othersubjects = Subjects::find()->where(['!=', 'uid', Yii::$app->user->identity->id])->all();
        $sids = [];
        foreach ($othersubjects as $key => $value) {
            $sids[] = $value['id'];
        }
        // $uinfors = Includes::find()->with('artical', 'subject', 'maker')->orderBy('updated_at desc')->where(['aid' => $aids, 'sid' => $sids, 'status' => [1, 2, 4]])->all();
        $uinfors = Includes::find()->with('artical', 'subject', 'maker')->asArray()->orderBy('updated_at desc')->where(['aid' => $aids, 'sid' => $sids, 'status' => [1, 2, 4]])->all();
        foreach ($uinfors as $key => $value) {
            $uinfors[$key]['tag'] = 'include';
        }
        // print_r($uinfors);die();
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $othersinfor = $infor['others'];
        $infor->others = 0;
        $infor->otherstime = $infor->othersuptime;
        $infor->save();
        $otherinfors = Sort::sortOtherinfors($oinfors, $uinfors);
        // foreach ($otherinfors as $key => $value) {
        //     echo $value['tag'].'<br>';
        // }
        // die();
        return $this->renderPartial('others', ['otherinfors' => $otherinfors, 'othersinfor' => $othersinfor]);
    }
    // 用户处理请求函数
    // 接受两个参数
    // 1, 请求id
    // 2, 用户操作结果
    public function actionDealrequest()
    {
        $data = Yii::$app->request->post();
        Yii::$app->on('frontend.include', ['frontend\models\IncludesForm', 'saveInlcudeInfor']);
        $result = IncludesForm::includeArtToOwnsub($data['aid'], $data['iid'], $data['resu']);
        return json_encode($result);
    }
}
