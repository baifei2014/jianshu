<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "userinfor".
 *
 * @property integer $id
 * @property string $avatar
 * @property string $sex
 * @property string $summary
 * @property string $web
 * @property string $qrcode
 */
class Userinfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_infor';
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['uid', 'integer'],
            [['summary', 'web', 'qrcode'], 'string', 'max' => 255],
            [['sex'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sex' => 'Sex',
            'summary' => 'Summary',
            'web' => 'Web',
            'qrcode' => 'Qrcode',
        ];
    }
}
