<?php

namespace common\models;

use Yii;
use common\models\Artical;

/**
 * This is the model class for table "articalinfor".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $brower
 * @property integer $like
 */
class Articalinfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artical_infor';
    }

    public function getArtical()
    {
        return $this->hasOne(Artical::className(), ['id' => 'aid']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'brower', 'like', 'comment'], 'integer'],
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
            'brower' => 'Brower',
            'like' => 'Like',
            'comment' => 'Comment',
        ];
    }
}
