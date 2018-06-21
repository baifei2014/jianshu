<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "subscribe".
 *
 * @property integer $id
 * @property string $email
 * @property string $auth_key
 * @property string $subscribe_token
 * @property integer $created_at
 * @property integer $update_at
 */
class Subscribe extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'update_at'], 'integer'],
            ['email', 'required'],
            [['email', 'auth_key', 'subscribe_token'], 'string', 'max' => 255],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'subscribe_token' => 'Subscribe Token',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }
    public function generateSubscribeToken()
    {
        $this->subscribe_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
