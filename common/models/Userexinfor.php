<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "userexinfor".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $focus
 * @property integer $fans
 * @property integer $artical
 * @property integer $sets
 */
class Userexinfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_exinfor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'focus', 'fans', 'artical'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'focus' => 'Focus',
            'fans' => 'Fans',
            'artical' => 'Artical',
        ];
    }
}
