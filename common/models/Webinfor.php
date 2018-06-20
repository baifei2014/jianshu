<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinfor".
 *
 * @property integer $id
 * @property string $webname
 * @property string $introduce
 * @property string $area
 * @property string $type
 * @property integer $register
 * @property string $opname
 * @property string $opnumber
 */
class Webinfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinfor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['register', 'created_at'], 'integer'],
            [['webname', 'introduce', 'area', 'opname'], 'string', 'max' => 255],
            [['type', 'opnumber'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'webname' => 'Webname',
            'introduce' => 'Introduce',
            'area' => 'Area',
            'type' => 'Type',
            'register' => 'Register',
            'opname' => 'Opname',
            'opnumber' => 'Opnumber',
        ];
    }
    public static function getWorkdays()
    {
        $infor = self::find()->one();
        if($infor){
            $intervaldays = time()-$infor->created_at;
            // $workdays = Yii::$app->formatter->asDuration($intervaldays, ',');
            // $datas = preg_split("/\,/", $workdays);
            // return $datas[0];
            $day = 60*60*24;
            return $workdays = floor($intervaldays/$day);
        }else{
            return '0天';
        }
    }
}
