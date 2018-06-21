<?php

namespace frontend\models;

use Yii;
use common\models\Subinfor;
use common\models\Artical;
use common\models\Focus;
use common\models\Includes;

/**
 * This is the model class for table "subinfor".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $focus
 * @property integer $artical
 * @property integer $words
 */
class SubinforForm extends \yii\base\Model
{

    public static function getSubinfor($id)
    {
        $subinfor = Subinfor::find()->where(['sid' => $id])->one();
        if($subinfor){
            $focus = Focus::find()->asArray()->where(['f_id' => $id, 'type' => 'subject'])->all();
            $includes = Includes::find()->where(['sid' => $id, 'status' => [1, 2]])->all();
            $aids = [];
            foreach ($includes as $key => $value) {
                $aids[] = $value['id'];
            }
            $articals = Artical::find()->where(['id' => $aids])->all();
            $words = 0;
            foreach ($articals as $key => $value) {
                $words += $value['words'];
            }
            if($subinfor->focus != count($focus) || $subinfor->artical != count($articals)){
                $subinfor->focus = count($focus);
                $subinfor->artical = count($articals);
                $subinfor->save();
            }
            return $subinfor;
        }else{
            $focus = Focus::find()->asArray()->where(['f_id' => $id, 'type' => 'set'])->all();
            $includes = Includes::find()->where(['sid' => $id, 'status' => [1, 2]])->all();
            $aids = [];
            foreach ($includes as $key => $value) {
                $aids[] = $value['id'];
            }
            $aids = array_unique($aids);
            $articals = Artical::find()->where(['id' => $aids])->all();
            $words = 0;
            foreach ($articals as $key => $value) {
                $words += $value['words'];
            }
            $model = new subinfor;
            $model->sid = $id;
            $model->focus = count($focus);
            $model->artical = count($articals);
            $model->save();
            return $model;
        }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'focus', 'artical', 'words'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'focus' => 'Focus',
            'artical' => 'Artical',
            'words' => 'Words',
        ];
    }
}
