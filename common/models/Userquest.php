<?php

namespace common\models;

use Yii;
use common\models\Artical;

/**
 * This is the model class for table "userquest".
 *
 * @property integer $id
 * @property integer $aid
 * @property string $type
 * @property string $result
 * @property integer $created_at
 * @property integer $status
 */
class Userquest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userquest';
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
            [['aid', 'created_at', 'status'], 'integer'],
            [['type', 'result'], 'string', 'max' => 50],
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
            'type' => 'Type',
            'result' => 'Result',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    public static function operateQuest($id, $for)
    {
        $quest = self::find()->where(['id' => $id])->one();
        if(!$quest){
            return false;
        }
        if($for == 'audit'){
            $quest->status = 1;
            if($quest->save()){
                $artical = Artical::find()->where(['id' => $quest['aid']])->one();
                if($quest->type == 'star'){
                    $artical->star = $quest->result;
                    $artical->save();
                    return true;
                }
                if($quest->type == 'danger'){
                    $artical->danger = $quest->result;
                    $artical->save();
                    return true;
                }
                if($quest->type == 'delete'){
                    $artical->delete();
                    Comments::deleteAll('aid = :aid', [':aid' => $artical['id']]);
                    Userquest::deleteAll('aid = :aid', [':aid' => $artical['id']]);
                    return true;
                }
            }
        }
        if($for == 'unaudit'){
            $quest->status = 2;
            if($quest->save()){
                return true;
            }
        }
    }
}
