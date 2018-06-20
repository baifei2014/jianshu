<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Includes;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $labelimg
 * @property string $name
 * @property string $describe
 * @property integer $submit
 * @property integer $audit
 * @property integer $created_at
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }
    public function getMaker()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    public function getIncludes()
    {
        return $this->hasMany(Includes::className(), ['sid' => 'id'])->where(['status' => 3]);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'submit', 'audit', 'created_at', 'updated_at'], 'integer'],
            [['describe', 'code'], 'string'],
            [['labelimg', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'labelimg' => 'Labelimg',
            'name' => 'Name',
            'describe' => 'Describe',
            'submit' => 'Submit',
            'audit' => 'Audit',
            'code' => 'Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
