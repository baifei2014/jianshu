<?php

namespace common\models;

use Yii;
use common\models\Artical;

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
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['aid', 'pid', 'created_at'], 'integer'],
            [['nickname', 'email', 'webaddress'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'aid' => 'Aid',
            'pid' => 'Pid',
            'nickname' => 'Nickname',
            'email' => 'Email',
            'webaddress' => 'Webaddress',
            'created_at' => 'Created At',
        ];
    }
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'pid']);
    }
    public function getArtical()
    {
        return $this->hasOne(Artical::className(), ['id' => 'aid']);
    }
    public static function findComment($id)
    {
        $comment = self::find()->asArray()->where(['aid' => $id])->orderBy('id desc')->all();
        $comment = self::sortComment($comment);
        return $comment;
    }
    public static function sortComment($comment, $pid=0)
    {
        $comments = [];
        foreach ($comment as $key => $value) {
            if($value['pid'] == $pid){
                $values = self::find()->asArray()->where(['id' => $value['id']])->with('parent')->one();
                $comments[] = $values;
                $reply = self::find()->asArray()->where(['pid' => $value['id']])->all();
                if($reply){
                    $comments = array_merge($comments, self::sortComment($reply,$value['id']));
                }
            }
        }
        return $comments;
    }
    public static function findLastcomment()
    {
        $comment = self::find()->limit(5)->orderBy('id desc')->with('artical')->all();
        if($comment){
            return $comment;
        }else{
            return [];
        }
    }
}
