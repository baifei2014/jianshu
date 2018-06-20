<?php

namespace frontend\models;

use Yii;
use common\models\Userexinfor;
use common\models\Focus;
use common\models\Artical;

/**
 * This is the model class for table "userexinfor".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $focus
 * @property integer $fans
 * @property integer $artical
 * @property integer $sets
 */
class UserexinforForm extends \yii\base\Model
{

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'focus', 'fans', 'artical'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'focus' => 'Focus',
            'fans' => 'Fans',
            'artical' => 'Artical',
        ];
    }
}
