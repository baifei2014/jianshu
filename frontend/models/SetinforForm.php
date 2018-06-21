<?php

namespace frontend\models;

use Yii;
use common\models\Setinfor;
use common\models\Artical;
use common\models\Focus;

/**
 * This is the model class for table "setinfor".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $focus
 * @property integer $artical
 * @property integer $words
 */
class SetinforForm extends \yii\base\Model
{

    public static function getSetinfor($id)
    {
        $setinfor = Setinfor::find()->where(['sid' => $id])->one();
        if($setinfor){
            return $setinfor;
        }else{
            return null;
        }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'focus', 'artical', 'words'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'focus' => 'Focus',
            'artical' => 'Artical',
            'words' => 'Words',
        ];
    }
}
