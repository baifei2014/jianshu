<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "membersubject".
 *
 * @property integer $id
 * @property integer $mid
 * @property integer $sid
 */
class Membersubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'membersubject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'sid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mid' => 'Mid',
            'sid' => 'Sid',
        ];
    }
}
