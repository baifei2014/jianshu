<?php

namespace common\models;

use Yii;
use common\models\Artical;
use common\models\Articalinfor;

/**
 * This is the model class for table "collect".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $aid
 * @property integer $created_at
 */
class Collect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collect';
    }

    public function getArtical()
    {
        return $this->hasOne(Artical::className(), ['id' => 'aid']);
    }
    public function getArticalinfor()
    {
        return $this->hasOne(Articalinfor::className(), ['aid' => 'aid']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'aid', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'aid' => 'Aid',
            'created_at' => 'Created At',
        ];
    }
}
