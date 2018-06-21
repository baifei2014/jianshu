<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $name
 * @property string $account
 * @property string $sex
 * @property string $weixin
 * @property integer $phonenumber
 * @property string $mail
 * @property string $position
 * @property string $tag
 * @property integer $created_at
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phonenumber', 'created_at'], 'integer'],
            [['name', 'account', 'weixin', 'mail', 'position', 'tag'], 'string', 'max' => 255],
            [['sex'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'account' => 'Account',
            'sex' => 'Sex',
            'weixin' => 'Weixin',
            'phonenumber' => 'Phonenumber',
            'mail' => 'Mail',
            'position' => 'Position',
            'tag' => 'Tag',
            'created_at' => 'Created At',
        ];
    }
    public static function findMember()
    {
        $members = self::find()->asArray()->all();
        return $members;
    }
}
