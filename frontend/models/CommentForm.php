<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Comment;
use common\models\User;
use common\models\Userinfor;
use common\models\Articalinfor;
use common\models\Userbehavior;
use common\models\Infor;
use common\models\Artical;
use yii\base\Event;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $p_id
 * @property string $a_id
 * @property string $comment
 * @property string $user_id
 * @property integer $created_at
 */
class CommentForm extends \yii\base\Model
{
    public $comment;
    public $a_id;
    public $p_id;
    public $user_id;
    public $created_at;

    public $id;
    public $time;

    public static $auserid;
    public static $cuserid;
    public $bereplyer;
    public static $messager = [];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'a_id', 'user_id', 'created_at'], 'integer'],
            [['comment'], 'required'],
            [['comment', 'bereplyer'], 'string'],
        ];
    }
    public static function findCommentNum($aid)
    {
        $comments = Comment::find()->where(['a_id' => $aid, 'p_id' => 0])->all();
        return count($comments);
    }
    public function saveComment()
    {
        if(!$this->validate()){
            return null;
        }
        $comment = new Comment();
        $comment->p_id = $this->p_id;
        $comment->bereplyer = self::checkBeReplyer($this->bereplyer);
        $comment->a_id = $this->a_id;
        $comment->comment = $this->comment;
        $comment->user_id = $this->user_id;
        $comment->created_at = time();
        if($comment->save()){
            Yii::$app->on('frontend.comment', ['frontend\models\CommentForm', 'saveCommentInfor']);
            Yii::$app->trigger('frontend.comment', new Event(['sender' => ['time' => $comment->created_at, 'pid' => $comment->p_id, 'aid' => $comment->a_id, 'bereplyer' => $comment->bereplyer]]));
            $this->id = $comment->id;
            $this->time = $comment->created_at;
            $articalinfor = Articalinfor::find()->where(['aid' => $this->a_id])->one();
            $articalinfor->comment = $articalinfor->comment + 1;
            $userbehavior = new Userbehavior;
            $userbehavior->u_id = Yii::$app->user->identity->id;
            $userbehavior->o_id = $this->id;
            $userbehavior->type = 'comment';
            if($articalinfor->save() && $userbehavior->save()){
                return true;
            }
        }
    }
    public static function checkBeReplyer($bereplyer)
    {
        if(Yii::$app->user->identity->nickname == $bereplyer){
            return '';
        }
        $user = User::find()->where(['nickname' => $bereplyer])->one();
        if($user){
            return $bereplyer;
        }else{
            return '';
        }
    }
    public static function findComments($comments, $Id)
    {
        //$comments = Comment::find()->where(['a_id' => $Id]);
        $childcomments = Comment::find()->where(['a_id' => $Id])->asArray()->all();
        $comments = ArrayHelper::toArray($comments);
        return self::subtree($comments, 0, $childcomments);
    }
    public static function subtree($arr,$id=0, $childcomments){
        $subs = [];
        foreach($arr as $v) {
            if($v['p_id'] == $id) {
                $user_id = User::find()->where(['id' => $v['user_id']])->asArray()->one();
                $userinfor = Userinfor::find()->where(['uid' => $v['user_id']])->asArray()->one();
                $v['user'] = $user_id;
                $v['userinfor'] = $userinfor;
                $v['child'] = self::childtree($childcomments,$v['id']);
                $subs[] = $v;
            }
        }
        return $subs;
    }
    public static function childtree($array, $pid)
    {
        $subs = [];
        foreach($array as $v) {
            if($v['p_id'] == $pid) {
                $user_id = User::find()->where(['id' => $v['user_id']])->asArray()->one();
                $userinfor = Userinfor::find()->where(['uid' => $v['user_id']])->asArray()->one();
                $v['user'] = $user_id;
                $v['userinfor'] = $userinfor;
                $v['replyer'] = self::getBereplyerinfor($v['bereplyer']);
                $subs[] = $v;
            }
        }
        return $subs;
    }
    public static function getBereplyerinfor($name)
    {
        $user = User::find()->asArray()->where(['nickname' => $name])->one();
        // $user = ArrayHelper::toArray($replyer);
        // echo count($user);die();
        // print_r($user);die();
        if($user){
            return $user;
        }else{
            return [];
        }
    }
    /**
    * 保存评论信息
    */
    public static function saveCommentInfor($event)
    {
        $data = $event->sender;
        $time = $data['time'];
        $tomessager = self::getToMessager($data['pid'], $data['aid'], $data['bereplyer']);
        foreach ($tomessager as $key => $value) {
            $infor = Infor::find()->where(['uid' => $value])->one();
            if($infor){
                $infor->comments = $infor->comments + 1;
                $infor->commentsuptime = $time;
                $infor->save();
            }else{
                $infor = new Infor;
                $infor->uid = $value;
                $infor->comments = 1;
                $infor->commentstime = $time - 1;
                $infor->commentsuptime = $time;
                $infor->save();
            }
        }
    }
    /** 
    * 获取要发送给消息的用户id列表
    */
    public static function getToMessager($pid, $aid, $bereplyer)
    {
        // 通过aid查询文章信息并判断是否给此文章作者发送消息
        $artical = Artical::find()->where(['id' => $aid])->one();
        if($artical && $artical['user_id'] != Yii::$app->user->identity->id){
            self::$messager[] = $artical['user_id'];
        }
        // 通过pid查询评论信息并判断是否给pid所属的评论者发送消息
        $comment = Comment::find()->where(['id' => $pid])->one();
        if($comment && $comment['user_id'] != yii::$app->user->identity->id){
            self::$messager[] = $comment['user_id'];
        }
        // 通过bereplyer查询用户信息并判断是否给此用户发送信息
        $replyer = User::find()->where(['nickname' => $bereplyer])->one();
        if($replyer && $replyer['id'] != Yii::$app->user->identity->id){
            self::$messager[] = $replyer['id'];
        }
        return array_unique(self::$messager);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'p_id' => 'P ID',
            'a_id' => 'A ID',
            'comment' => 'Comment',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'bereplyer' => 'Bereplyer',
        ];
    }
}
?>
