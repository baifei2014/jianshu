<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "infor".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $comments
 * @property integer $likes
 * @property integer $follows
 * @property integer $others
 */
class InforForm extends \yii\base\Model
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'comments', 'likes', 'follows', 'others'], 'integer'],
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
            'comments' => 'Comments',
            'likes' => 'Likes',
            'follows' => 'Follows',
            'others' => 'Others',
        ];
    }
}
