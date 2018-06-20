<?php

namespace frontend\models;

use Yii;
use common\models\Subjects;
use common\models\Subinfor;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $labelimg
 * @property string $name
 * @property string $describe
 * @property integer $submit
 * @property integer $audit
 * @property integer $created_at
 */
class SubjectsForm extends \yii\base\Model
{

    public $file;
    public $name;
    public $describe;
    public $submit;
    public $audit;
    public $labelimg;
    public $uid;
    public $created_at;
    public $code;
    public $updated_at;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [['uid', 'submit', 'audit', 'created_at', 'updated_at'], 'integer'],
            [['describe', 'code'], 'string'],
            [['labelimg', 'name'], 'string', 'max' => 255],
            ['file', 'file'],
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
            'labelimg' => 'Labelimg',
            'name' => 'Name',
            'describe' => 'Describe',
            'submit' => 'Submit',
            'audit' => 'Audit',
            'code' => 'Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function saveSubject()
    {
        if(!$this->validate()){
            return false;
        }
        $model = new Subjects;
        $model->uid = Yii::$app->user->identity->id;
        $model->code = self::getCode($this->labelimg);
        $model->labelimg = $this->labelimg;
        $model->name = $this->name;
        $model->describe = $this->describe;
        $model->submit = $this->submit;
        $model->audit = $this->audit;
        $model->created_at = $this->created_at;
        $model->updated_at = $this->created_at;
        if($model->save()){
            $subinfor = new Subinfor;
            $subinfor->sid = $model->id;
            $subinfor->save();
            return true;
        }
    }
    public function updateSubject($id)
    {
        if(!isset($id)){
            return false;
        }
        if(!$this->validate()){
            return false;
        }
        $model = Subjects::find()->where(['code' => $id])->one();
        $model->labelimg = isset($this->labelimg) ? $this->labelimg : $model->labelimg;
        $model->name = $this->name;
        $model->describe = $this->describe;
        $model->submit = $this->submit;
        $model->audit = $this->audit;
        $model->updated_at = isset($this->updated_at) ? $this->updated_at : time();
        if($model->save()){
            return true;
        }
    }
    public static function getCode($key)
    {
        $code = mb_substr(md5($key), 7, 12, 'utf-8');
        return $code;
        // $data = Subjects::find()->where(['code' => $code])->one();
        // if($data){
        //     return self::getCode();
        // }else{
        //     return $code;
        // }
    }
}
