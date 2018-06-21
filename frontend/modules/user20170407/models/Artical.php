<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%artical}}".
 *
 * @property string $id
 * @property string $title
 * @property string $type
 * @property string $content
 * @property integer $created_at
 * @property string $created_by
 * @property string $tags
 * @property integer $comment
 * @property integer $is_top
 * @property integer $status
 * @property integer $view
 * @property integer $is_open
 */
class Artical extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%artical}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content'],'required'],
            [['content'], 'string'],
            [['created_at'], 'integer'],
            [['title', 'type', 'created_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'type' => '分类',
            'content' => '内容',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'tags' => 'Tags',
            'is_top' => 'Is Top',
            'status' => 'Status',
            'view' => 'View',
            'is_open' => 'Is Open',
        ];
    }
}
