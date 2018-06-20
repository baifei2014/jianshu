<?php

namespace frontend\models;

use Yii;
use Articaltag;

/**
 * This is the model class for table "articaltag".
 *
 * @property integer $id
 * @property string $tag
 */
class ArticaltagForm extends \yii\base\Model
{
    public $tag;
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
    public function saveTag()
    {

    }
}
