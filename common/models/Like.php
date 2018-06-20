<?php

namespace common\models;

use Yii;
use common\models\Artical;
use common\models\Articalinfor;
use common\models\User;

/**
 * This is the model class for table "like".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $a_id
 * @property integer $created_at
 */
class Like extends \yii\db\ActiveRecord
{
    public function getArtical()
    {
        return $this->hasOne(Artical::className(), ['id' => 'a_id']);
    }
    public function getAuther()
    {
        return $this->hasOne(User::className(), ['id' => 'wid']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
    public function getArticalinfor()
    {
        return $this->hasOne(Articalinfor::className(), ['aid' => 'a_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'a_id', 'wid', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'a_id' => 'A ID',
            'created_at' => 'Created At',
            'wid' => 'Wid',
        ];
    }
}
