<?php

namespace frontend\models;

use Yii;
use common\models\Focus;
use common\models\Userbehavior;
use common\models\Infor;
use common\models\Subjects;
use common\models\Articalset;
use common\models\Subinfor;
use yii\base\Event;
use common\models\Setinfor;
use common\models\Userexinfor;

/**
 * This is the model class for table "focus".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $f_id
 * @property string $type
 * @property integer $created_at
 */
class FocusForm extends \yii\base\Model
{
    public static $id;
    public static $time;

    // 关注或取关
    public static function Focus($id, $type = '')
    {
        Yii::$app->on('frontend.focusperson', ['frontend\models\FocusForm', 'saveFocusInforA']);
        Yii::$app->on('frontend.focusperson', ['frontend\models\FocusForm', 'saveUserbehaviorInfor']);
        Yii::$app->on('frontend.focusnotperson', ['frontend\models\FocusForm', 'saveFocusInforB']);
        Yii::$app->on('frontend.focusnotperson', ['frontend\models\FocusForm', 'saveUserbehaviorInfor']);
        Yii::$app->on('frontend.focusnotperson', ['frontend\models\FocusForm', 'saveSubinforInfor']);
        $uid = Yii::$app->user->identity->id;
        if($type == 'auther'){
            $eventname = 'frontend.focusperson';
            if($uid == $id){
                $result = [
                    'status' => 'error',
                    'message' => '自己不能关注自己',
                ];
                return $result;
            }
        }else{
            $eventname = 'frontend.focusnotperson';
        }
        $focus = Focus::find()->where(['u_id' => $uid, 'f_id' => $id, 'type' => $type])->one();
        if($focus){
            self::$time = $focus['created_at'];
            if($focus->delete()){
                Yii::$app->trigger($eventname, new Event(['sender' => ['id' => $id, 'number' => -1, 'oid' => $focus->id, 'type' => $type]]));
                $result = [
                    'status' => 'cancel',
                    'message' => '取消关注成功',
                ];
                return $result;
            }
        }else{
            $model = new Focus;
            $model->u_id = Yii::$app->user->identity->id;
            $model->f_id = $id;
            $model->type = $type;
            $model->created_at = time();
            if($model->save()){
                self::$time = $model->created_at;
                Yii::$app->trigger($eventname, new Event(['sender' => ['id' => $id, 'number' => 1, 'oid' => $model->id, 'type' => $type]]));
                $result = [
                    'status' => 'success',
                    'message' => '关注成功',
                ];
                return $result;
            }
        }
    }
    public static function saveSubinforInfor($event)
    {
        $data = $event->sender;
        $id = $data['id'];
        $number = $data['number'];
        $type = $data['type'];
        if($type == 'subject'){
            $subinfor = Subinfor::find()->where(['sid' => $id])->one();
            $subinfor->focus = $subinfor->focus + $number;
            $subinfor->save();
        }else if($type == 'set'){
            $setinfor = Setinfor::find()->where(['sid' => $id])->one();
            $setinfor->focus = $setinfor->focus + $number;
            $setinfor->save();
        }
    }
    public static function saveUserbehaviorInfor($event)
    {
        $uid = Yii::$app->user->identity->id;
        $data = $event->sender;
        $befocusid = $data['id'];
        $oid = $data['oid'];
        $type = $data['type'];
        $number = $data['number'];
        if($number == 1){
            $focus = Userexinfor::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            $fans = Userexinfor::find()->where(['user_id' => $befocusid])->one();
            $focus->focus = $focus->focus + 1;
            $fans->fans = $fans->fans + 1;
            $focus->save();
            $fans->save();
            $behavior = new Userbehavior;
            $behavior->u_id = $uid;
            $behavior->o_id = $oid;
            $behavior->type = $type;
            $behavior->save();
        }else{
            $focus = Userexinfor::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            $fans = Userexinfor::find()->where(['user_id' => $befocusid])->one();
            $focus->focus = $focus->focus - 1;
            $fans->fans = $fans->fans - 1 ;
            $focus->save();
            $fans->save();
            $behavior = Userbehavior::find()->where(['u_id' => $uid, 'o_id' => $oid, 'type' => $type])->one();
            $behavior->delete();
        }
    }
    public static function saveFocusInforB($event)
    {
        $data = $event->sender;
        $sid = $data['id'];
        $number = $data['number'];
        $type = $data['type'];
        $time = self::$time;
        if($type == 'subject'){
            $sobject = Subjects::find()->where(['id' => $sid])->one();
        }else{
            $sobject = Articalset::find()->where(['id' => $sid])->one();
        }
        $infor = Infor::find()->where(['uid' => $sobject['uid']])->one();
        if($infor){
            if($number < 0){
                if($time > $infor['otherstime']){
                    $infor->others = $infor->others + $number;
                }
            }else{
                $infor->others = $infor->others + $number;
                $infor->othersuptime = $time;
            }
            $infor->save();
        }else{
            $model = new Infor;
            $model->uid = $sobject['uid'];
            $model->others = 1;
            $model->otherstime = $time - 1;
            $model->othersuptime = $time;
            $model->save();
        }
    }
    public static function saveFocusInforA($event)
    {
        $data = $event->sender;
        $touid = $data['id'];
        $number = $data['number'];
        $time = self::$time;
        $infor = Infor::find()->where(['uid' => $touid])->one();
        if($infor){
            if($number < 0){
                if($time > $infor['followstime']){
                    $infor->follows = $infor->follows + $number;
                }
            }else{
                $infor->follows = $infor->follows + $number;
                $infor->followsuptime = $time;
            }
            $infor->save();
        }else{
            $model = new Infor;
            $model->uid = $touid;
            $model->follows = 1;
            $model->followstime = $time - 1;
            $model->followsuptime = $time;
            $model->save();
        }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'f_id', 'created_at'], 'integer'],
            [['type'], 'string', 'max' => 255],
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
            'f_id' => 'F ID',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
