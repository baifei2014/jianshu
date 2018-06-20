<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $type_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['type_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'label_img' => 'Label Img',
            'type_id' => 'Type ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'is_valid' => 'Is Valid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public static function findLastArticals()
    {
        $articals = [];
        $posts = self::find()->orderBy('id desc')->limit(8)->all();
        $artical = self::find()->orderBy('id desc')->one();
        foreach ($posts as $key => $value) {
            if($value != $artical){
                $articals[] = $value;
            }
        }
        return $articals;
    }
    public static function findLastArtical()
    {
        $artical = self::find()->orderBy('id desc')->one();
        return $artical;
    }
    public static function findArtical($id)
    {
        $artical = self::find()->where(['id' => $id])->one();
        return $artical;
    }
    public static function findpreArtical($id)
    {
        $num = self::find()->where(['<','id',$id])->count()-1;
        $artical = self::find()->offset($num)->limit(1)->one();
        return $artical;
    }
    public static function findMoArts()
    {
        $articals = [];
        $posts = self::find()->orderBy('id desc')->limit(21)->all();
        $artical = self::find()->orderBy('id desc')->one();
        foreach ($posts as $key => $value) {
            if($value != $artical){
                $articals[] = $value;
            }
        }
        return $articals;
    }
}
