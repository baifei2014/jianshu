<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "articaltag".
 *
 * @property integer $id
 * @property string $tag
 */
class Articaltag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articaltag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
        ];
    }
}
