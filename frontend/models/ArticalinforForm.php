<?php

namespace frontend\models;

use Yii;
use common\models\Articalinfor;
use common\models\Userbehavior;
use common\models\Comment;

/**
 * This is the model class for table "articalinfor".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $brower
 * @property integer $like
 */
class ArticalinforForm extends \yii\base\Model
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'brower', 'like'], 'integer'],
        ];
    }

    public static function saveLike($aid)
    {
        $userbehavior = Userbehavior::find()->where(['uid' => Yii::$app->user->identity->id, 'aid' => $aid, 'behavior' => '喜欢了文章'])->one();
        if($userbehavior){
            $userbehavior->delete();
            $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
            $articalinfor->like = $articalinfor->like-1;
            if($articalinfor->save()){
                $result = [
                    'status' => 'cancel',
                    'message' => '取消喜欢成功',
                    'like' => $articalinfor->like,
                ];
                return $result;
            }
        }else{
            $behavior = new Userbehavior;
            $behavior->aid = $aid;
            $behavior->uid = Yii::$app->user->identity->id;
            $behavior->behavior = '喜欢了文章';
            $behavior->created_at = time();
            $behavior->save();
            $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
            $articalinfor->like = $articalinfor->like+1;
            if($articalinfor->save()){
                $result = [
                    'status' => 'success',
                    'message' => '喜欢成功',
                    'like' => $articalinfor->like,
                ];
                return $result;
            }
        }
    }
    public static function saveCommentsums($aid)
    {
        $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
        $comment = Comment::find()->where(['a_id' => $aid])->all();
        $articalinfor->comment = count($comment);
        if($articalinfor->save()){
            return true;
        }
    }
    public static function saveBrower($aid)
    {
        $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
        if($articalinfor){
            $articalinfor->brower = $articalinfor->brower + 1;
            if($articalinfor->save()){
                return true;
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'brower' => 'Brower',
            'like' => 'Like',
            'comment' => 'Comment',
        ];
    }
}
