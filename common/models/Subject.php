<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $sname
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['sname'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'sname' => 'Sname',
        ];
    }
    /**
    * 查询所有部门
    * 计算祖先部门层数
    * 排序
    * 判断是否有子部门并添加标记
    */
    public static function findSubjects()
    {
        $group = [];
        $subjects = self::find()->asArray()->all();
        $subjects = self::ChildSon($subjects);
        $subjects = self::qsorts($group,$subjects);
        $subjects = self::addChildTag($subjects);
        // print_r($subjects);die();
        return $subjects;
    }
    /**
    * 部门排序算法
    */
    public static function qsorts(&$group,$array,$id = 10){
        foreach ($array as $key => $value) {
            if($value['parent_id'] == $id){
                $group[]=$value;
                self::qsorts($group,$array,$value['id']);
            }
        }
        return $group;
    }
    /**
    * 判断每个部门是否有子部门并添加标记
    */
    public static function addChildTag($array){
        $nums = count($array);
        $i = 0;
        while($i<$nums-1){
            if($array[$i]['id'] == $array[$i+1]['parent_id']){
                $array[$i]['has_child'] = true;
            }else{
                $array[$i]['has_child'] = false;
            }
            $i++;
        }
        $array[$nums-1]['has_child'] = false;
        return $array;
    }
    public static function chargeChildSon($array){
        $nums = count($array);
        for ($i=0; $i < $nums; $i++) { 
            $array[$i]['father_nums'] = 0;
        }
        for ($i=0; $i < $nums; $i++) { 
            if($array[$i]['parent_id'] !=0){
                $array[$i]['father_nums']++;
                if($array[$i]['has_child'] == true){

                }
            }
        }
        return $array;
    }
    /**
    * 计算祖先部门层数
    */
    public static function ChildSon($array){
        $nums = count($array);
        $childsons = 0;
        for ($i=0; $i < $nums; $i++) { 
            $fathers = self::countChildSon($array,$i,$j = 0);
            $array[$i]['fathers'] = $fathers;
        }
        return $array;
    }
    public static function countChildSon($array,$i=0,$j=0){
        $nums = count($array);
        if($array[$i]['parent_id'] != 10){
            $parent_id = $array[$i]['parent_id'];
            for ($i=0; $i < $nums; $i++) { 
                if($array[$i]['id'] == $parent_id){
                    $j++;
                    return self::countChildSon($array,$i,$j);
                }
            }
        }else{
            return $j;
        }
    }
}
