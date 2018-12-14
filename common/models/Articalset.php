<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Artical;

/**
 * This is the model class for table "articalset".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $name
 * @property integer $created_at
 */
class Articalset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artical_set';
    }
    public function getMaker()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    public function getArticalset()
    {
        return $this->hasMany(Artical::className(), ['set_id' => 'id']);
    }
    public function getArtical()
    {
        return $this->hasMany(Artical::className(), ['set_id' => 'id']);
    }
    public function getAuther()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'created_at', 'words', 'focus'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'words' => 'Words',
            'focus' => 'Focus',
            'created_at' => 'Created At',
        ];
    }
}
