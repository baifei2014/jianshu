<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "collect".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $aid
 * @property integer $created_at
 */
class Chatroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chatroom';
    }
}