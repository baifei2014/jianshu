<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "userbehavior".
 *
 * @property integer $id
 * @property integer $o_id
 * @property string $type
 * @property integer $created_at
 * @property integer $u_id
 */
class Userbehavior extends \yii\db\ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userbehavior';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['o_id', 'u_id'], 'integer'],
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
            'o_id' => 'O ID',
            'type' => 'Type',
            'u_id' => 'U Id',
        ];
    }
}
