<?php

namespace common\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;
use common\models\Artical;

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
class Comment extends \yii\db\ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getArtical()
    {
        return $this->hasOne(Artical::className(), ['id' => 'a_id']);
    }
    public function getBereplyer()
    {
        return $this->hasOne(User::className(), ['nickname' => 'bereplyer']);
    }
    public function getArticalinfor()
    {
        return $this->hasOne(Articalinfor::className(), ['aid' => 'a_id']);
    }
    public function getPcomment()
    {
        return $this->hasOne(self::className(), ['id' => 'p_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'a_id', 'user_id', 'created_at'], 'integer'],
            [['a_id', 'comment', 'user_id'], 'required'],
            [['comment','bereplyer'], 'string'],
        ];
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
    public function getUserbynick()
    {
        return $this->hasOne(User::className(), ['nickname' => 'bereplyer']);
    }
    public static function findCommentList($Id)
    {
        //$comments = Comment::find()->where(['artical_id' => $Id]);
        $comments = Comment::findAll(['artical_id' => $Id]);
        $comments = ArrayHelper::toArray($comments);
        return self::subtree($comments, 0);
    }
    public static function subtree($arr,$id=0){
    $subs = array();
    foreach($arr as $v) {
        if($v['parent'] == $id) {
            $user_id = User::findOne($v['user_id']);
            $user_id = ArrayHelper::toArray($user_id);
            $v['user_id'] = $user_id;
            $subs[] = $v;
            $subs = array_merge($subs,self::subtree($arr,$v['id']));
        }
    }
    return $subs;
    }
}
