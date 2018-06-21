<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rightcontrol".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $mid
 * @property integer $brower
 * @property integer $manager
 */
class Rightcontrol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rightcontrol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'mid', 'brower', 'manager'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'mid' => 'Mid',
            'brower' => 'Brower',
            'manager' => 'Manager',
        ];
    }
}
