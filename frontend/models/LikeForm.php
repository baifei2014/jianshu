<?php

namespace frontend\models;

use Yii;
use common\models\Like;
use common\models\Articalinfor;
use common\models\Userbehavior;
use common\models\Infor;
use common\models\Artical;
use yii\base\Event;
use common\models\Userexinfor;

/**
 * This is the model class for table "like".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $a_id
 * @property integer $created_at
 */
class LikeForm extends \yii\base\Model
{
    public static $time;
    /**
    * 查询记录并根据结果判断是保存喜欢记录还是删除记录
    */
    public static function saveLike($aid, $wid)
    {
        Yii::$app->on('frontend.like', ['frontend\models\LikeForm', 'saveLikeInfor']);
        Yii::$app->on('frontend.like', ['frontend\models\LikeForm', 'saveUserbehaviorInfor']);
        Yii::$app->on('frontend.like', ['frontend\models\LikeForm', 'saveArticalinforInfor']);
        $like = Like::find()->where(['u_id' => Yii::$app->user->identity->id, 'a_id' => $aid])->one();
        if($like){
            self::$time = $like['created_at'];
            if($like->delete()){
                Yii::$app->trigger('frontend.like', new Event(['sender' => ['aid' => $aid, 'wid' => $wid, 'number' => -1, 'oid' => $like->id, 'type' => 'like']]));
                $userexinfor = Userexinfor::find()->where(['user_id' => $wid])->one();
                $userexinfor->likes = $userexinfor->likes - 1;
                $userexinfor->save();
                $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
                $result = [
                    'status' => 'cancel',
                    'message' => '取消喜欢成功',
                    'like' => $articalinfor->like,
                ];
                return $result;
            }
        }else{
            $model = new Like;
            $model->u_id = Yii::$app->user->identity->id;
            $model->wid = $wid;
            $model->a_id = $aid;
            $model->created_at = time();
            if($model->save()){
                self::$time = $model->created_at;
                Yii::$app->trigger('frontend.like', new Event(['sender' => ['aid' => $aid, 'wid' => $wid, 'number' => 1, 'oid' => $model->id, 'type' => 'like']]));
                $userexinfor = Userexinfor::find()->where(['user_id' => $wid])->one();
                $userexinfor->likes = $userexinfor->likes + 1;
                $userexinfor->save();
                $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
                $result = [
                    'status' => 'success',
                    'message' => '喜欢成功',
                    'like' => $articalinfor->like,
                ];
                return $result;
            }
        }
    }
    public static function saveArticalinforInfor($event)
    {
        $uid = Yii::$app->user->identity->id;
        $data = $event->sender;
        $aid = $data['aid'];
        $number = $data['number'];
        $articalinfor = Articalinfor::find()->where(['aid' => $aid])->one();
        $articalinfor->like = $articalinfor->like + $number;
        $articalinfor->save();
    }
    public static function saveUserbehaviorInfor($event)
    {
        $uid = Yii::$app->user->identity->id;
        $data = $event->sender;
        $oid = $data['oid'];
        $type = $data['type'];
        $number = $data['number'];
        if($number == 1){
            $behavior = new Userbehavior;
            $behavior->u_id = $uid;
            $behavior->o_id = $oid;
            $behavior->type = $type;
            $behavior->save();
        }else{
            $behavior = Userbehavior::find()->where(['u_id' => $uid, 'o_id' => $oid, 'type' => $type])->one();
            $behavior->delete();
        }
    }
    public static function saveLikeInfor($event)
    {
        $data = $event->sender;
        $wid = $data['wid'];
        $number = $data['number'];
        $uid = Yii::$app->user->identity->id;
        $time = self::$time;
        if($wid == $uid){
            return;
        }
        $infor = Infor::find()->where(['uid' => $wid])->one();
        if($infor){
            if($number < 0){
                if($time > $infor['likestime']){
                    $infor->likes = $infor->likes + $number;
                }
            }else{
                $infor->likes = $infor->likes + $number;
                $infor->likesuptime = $time;
            }
            $infor->save();
        }else{
            $model = new Infor;
            $model->uid = $wid;
            $model->likes = 1;
            $model->likestime = $time - 1;
            $model->likesuptime = $time;
            $model->save();
        }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'a_id', 'wid', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'a_id' => 'A ID',
            'created_at' => 'Created At',
            'wid' => 'Wid',
        ];
    }
}
