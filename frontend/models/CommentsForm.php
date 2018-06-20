<?php

namespace frontend\models;

use Yii;
use common\models\Comments;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $content
 * @property integer $aid
 * @property integer $pid
 * @property string $nickname
 * @property string $email
 * @property string $webaddress
 * @property integer $created_at
 */
class CommentsForm extends \yii\base\Model
{

    public $nickname;
    public $email;
    public $webaddress;
    public $content;
    public $aid;
    public $pid;
    public $created_at;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['nickname', 'email', 'content'], 'required', 'message' => '{attribute}必填'],
            ['email', 'email'],
            ['nickname', 'string', 'max' => 16, 'message' => '{attribute}最长16位'],
            ['nickname', 'string', 'min' => 2, 'message' => '{attribute}最短2位'],
            ['webaddress', 'url', 'defaultScheme' => 'http', 'message' => '{attribute}不是一个有效的URL'],
            [['aid', 'pid', 'created_at'], 'integer'],
            ['email', 'checkEmail'],
            [['nickname', 'email', 'webaddress'], 'string', 'max' => 255],
        ];
    }

    public function checkEmail($attribute, $params)
    {
        $infor = Comments::find()->where(['email' => $this->email])->one();
        if(!$infor){
            return;
        }
        if($infor->nickname != $this->nickname){
            $this->addError($attribute, "此邮箱已经注册过，请使用相应的昵称.");
        }
    }
    public static function checkajaxEmail($email, $nickname)
    {
        $infor = Comments::find()->where(['email' => $email])->one();
        if(!$infor){
            return;
        }
        if($infor->nickname != $nickname){
            return "此邮箱已经注册过，请使用相应的昵称.";
        }
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
            return true;
        }
    }
    public static function checkBeReplyer($bereplyer)
    {
        if(Yii::$app->user->identity->username == $bereplyer){
            return '';
        }
        $user = User::find()->where(['username' => $bereplyer])->one();
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
        $user = User::find()->asArray()->where(['username' => $name])->one();
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '评论',
            'aid' => 'Aid',
            'pid' => 'Pid',
            'nickname' => '昵称',
            'email' => '邮箱',
            'webaddress' => '网址',
            'created_at' => 'Created At',
        ];
    }
}
