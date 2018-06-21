<?php

namespace frontend\models;

use Yii;
use common\models\Articalset;

/**
 * This is the model class for table "articalset".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $name
 * @property integer $created_at
 */
class ArticalsetForm extends \yii\base\Model
{
    public $name;
    public $uid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    public static function savearticalset($articalset)
    {
        $model = Articalset::find()->where(['uid' => Yii::$app->user->identity->id, 'name' => $articalset])->all();
        if(!empty($model)){
            $response = [
                'status' => 'error',
                'message' => '文集名重复',
            ];
        }else{
            $model = new Articalset;
            $model->uid = Yii::$app->user->identity->id;
            $model->name = $articalset;
            $model->created_at = time();
            if($model->save()){
                $setinfor = new Setinfor();
                $setinfor->sid = $model->id;
                $setinfor->save();
                $response = [
                    'status' => 'success',
                    'message' => '保存成功',
                    'name' => $model->name,
                    'id' => $model->id,
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'message' => '保存失败',
                ];
            }
        }
        return json_encode($response);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
            'created_at' => 'Created At',
        ];
    }
}
