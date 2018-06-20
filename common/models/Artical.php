<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Userinfor;
use common\models\Articalset;
use common\models\Articalinfor;
use common\models\Focus;
use common\models\Userexinfor;


/**
 * This is the model class for table "artical".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $type_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Artical extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artical';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required', 'message' => '{attribute}必填'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'words'], 'integer'],
            ['title', 'string', 'max' => 64, 'tooLong' => '标题不可超过64个字'],
            [['img'],'file','extensions' => 'jpg,png,gif','maxSize'=>1024000,'checkExtensionByMimeType' => false],
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getComment()
    {
        return $this->hasMany(Comment::className(), ['a_id' => 'id']);
    }
    public function getUserinfor()
    {
        return $this->hasOne(Userinfor::className(), ['uid' => 'user_id']);
    }
    public function getUserexinfor()
    {
        return $this->hasOne(Userexinfor::className(), ['user_id' => 'user_id']);
    }
    public function getArticalset()
    {
        return $this->hasOne(Articalset::className(), ['id' => 'set_id']);
    }
    public function getArticalinfor()
    {
        return $this->hasOne(Articalinfor::className(), ['aid' => 'id']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'img' => 'Img',
            'type_id' => 'Type ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'words' => 'Words',
        ];
    }
    public static function nextArtical($id)
    {
        $adjacent = [];
        $preartical = self::find()->where(['<', 'id', $id])->orderBy('id desc')->limit(1)->one();
        $nextartical = self::find()->where(['>', 'id', $id])->orderBy('id desc')->limit(1)->one();
        $adjacent['preartical'] = $preartical;
        $adjacent['nextartical'] = $nextartical;
        return $adjacent;
    }
    public static function auditArtical($id, $for = 'audit')
    {
        $artical = self::find()->where(['id' => $id])->one();
        if(!$artical){
            return false;
        }
        if($for == 'audit'){
            $artical->status = 1;
            if($artical->save()){
                return true;
            }
        }
        if($for == 'unaudit'){
            if($artical->delete()){
                Comments::deleteAll('aid = :aid', [':aid' => $id]);
                return true;
            }
        }
    }
}
