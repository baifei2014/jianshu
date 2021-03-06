<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subinfor".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $focus
 * @property integer $artical
 * @property integer $words
 */
class Subinfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subinfor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'focus', 'artical'], 'integer'],
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
        ];
    }
}
