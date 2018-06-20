<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "managers".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $mid
 */
class Managers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'managers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'mid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'mid' => 'Mid',
        ];
    }
}
