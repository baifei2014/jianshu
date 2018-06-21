<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Userexinfor;
use common\models\Userbehavior;
use common\models\Subjects;
use common\models\Articalset;
use common\models\Includes;
use common\models\Artical;

/**
 * This is the model class for table "focus".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $f_id
 * @property string $type
 * @property integer $created_at
 */
class Focus extends \yii\db\ActiveRecord
{
    public $tags;
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
    public function getUserfocus()
    {
        return $this->hasOne(User::className(), ['id' => 'f_id']);
    }
    public function getSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'f_id']);
    }
    public function getSet()
    {
        return $this->hasOne(Articalset::className(), ['id' => 'f_id']);
    }
    public function getSubjectinclu()
    {
        return $this->hasMany(Includes::className(), ['sid' => 'f_id']);
    }
    public function getSetinclu()
    {
        return $this->hasMany(Artical::className(), ['set_id' => 'f_id']);
    }
    public function getUserfans()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
    public function getUserfoinfor()
    {
        return $this->hasOne(Userexinfor::className(), ['user_id' => 'f_id']);
    }
    public function getUserioinfor()
    {
        return $this->hasOne(Userexinfor::className(), ['user_id' => 'u_id']);
    }
    public function getUserbehavior()
    {
        return $this->hasMany(Userbehavior::className(), ['u_id' => 'f_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'focus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'f_id', 'created_at'], 'integer'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'f_id' => 'F ID',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
