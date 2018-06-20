<?php

namespace common\models;

use Yii;
use common\models\Artical;
use common\models\User;
use common\models\Subjects;

/**
 * This is the model class for table "includes".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $sid
 * @property integer $uid
 * @property integer $status
 */
class Includes extends \yii\db\ActiveRecord
{
    public $tags;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'includes';
    }
    public function getMaker()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'sid']);
    }
    public function getArtical()
    {
        return $this->hasOne(Artical::className(), ['id' => 'aid']);
    }
    public function getSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'sid']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'sid', 'uid', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'sid' => 'Sid',
            'uid' => 'Uid',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
