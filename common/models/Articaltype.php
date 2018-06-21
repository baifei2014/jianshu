<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "articaltype".
 *
 * @property integer $id
 * @property string $type
 * @property integer $aid
 * @property integer $tid
 */
class Articaltype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articaltype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'tid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'tid' => 'Tid',
        ];
    }
}
