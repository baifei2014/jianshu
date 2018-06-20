<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setinfor".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $focus
 * @property integer $artical
 * @property integer $words
 */
class Setinfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setinfor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'focus', 'artical', 'words'], 'integer'],
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
            'focus' => 'Focus',
            'artical' => 'Artical',
            'words' => 'Words',
        ];
    }
}
