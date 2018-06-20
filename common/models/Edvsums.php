<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edvsums".
 *
 * @property integer $id
 * @property integer $sums
 * @property string $date
 */
class Edvsums extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edvsums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sums'], 'integer'],
            [['date'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sums' => 'Sums',
            'date' => 'Date',
        ];
    }
    public static function saveEvsums()
    {
        $date = self::find()->where(['date' => date('Y-m-d', time())])->one();
        if($date){
            $date->sums = $date->sums+1;
            if($date->save()){
                return true;
            }
            return true;
        }else{
            $vmodel = new Edvsums;
            $vmodel->sums = 1;
            $vmodel->date = date('Y-m-d', time());
            if($vmodel->save()){
                return true;
            }
            return true;
        }
    }
    public static function findDaygapdata($days = 7)
    {
        $array = [];
        $date = date_create(date('Y-m-d', time()));
        date_sub($date, date_interval_create_from_date_string($days." days"));
        $olddate = date_format($date, 'Y-m-d');
        $data = self::find()->asArray()->where(['>', 'date', $olddate])->all();
        $array = self::pattern($days, $data);
        return $array;
    }
    public static function pattern($days, $data)
    {
        $array = [];
        $k = 0;
        for ($i=0; $i < $days; $i++) { 
            $j = $days-$i-1;
            if(isset($data[$k])){
                if($data[$k]['date'] === date('Y-m-d', strtotime('-'.$j.' day'))){
                    $array[$i] = $data[$k]['sums'];
                    $k++;
                }else{
                    $array[$i] = 0;
                }
            }else{
                $j = $days-$i-1;
                $array[$i] = 0;
            }
        }
        return $array;
    }
    public static function dateData($days = 7)
    {
        $datearray = [];
        for ($i=0; $i < $days; $i++) { 
            $j = $days-$i-1;
            $datearray[$i] = date('Y-m-d', strtotime('-'.$j.' day'));
        }
        return $datearray;
    }
}
