<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "managergroup".
 *
 * @property integer $parent_id
 * @property integer $id
 * @property string $name
 * @property string $creater
 */
class Managergroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 16],
            // [['creater'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Parent ID',
            'id' => 'ID',
            'name' => 'Name',
            'creater' => 'Creater',
        ];
    }
}
