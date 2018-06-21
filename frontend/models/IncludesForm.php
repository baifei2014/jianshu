<?php

namespace frontend\models;

use Yii;
use common\models\Includes;
use common\models\Subjects;
use common\models\Artical;
use common\models\Articalinfor;
use common\models\Infor;
use yii\base\Event;

/**
 * This is the model class for table "includes".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $sid
 * @property integer $uid
 * @property integer $status
 */
class IncludesForm extends \yii\base\Model
{

    public static $aid;                // 文章id
    public static $sid;                // 专题id
    public static $auther;          // 文章作者
    public static $admin;           // 专题管理员
    public static $submitinfor;          // 是否允许投稿 1允许 2 不允许
    public static $auditinfor;           // 是否审核 1审核 2 不审核
    public static $time;

    // 返回信息
    // 注： 拒绝是专题管理员拒绝文章投稿的请求
    //      
    // 1 文章未经审核成功添加进专题
    // 2 文章通过审核成功添加进专题
    // 3 文章成功投稿专题，待审核
    // 4 文章被拒绝收录进专题
    // 5 文章作者成功撤回或移除
    // 6 已经不能在投稿该专题
    // 7 专题管理员从专题移除
    // 9 此专题禁止投稿

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'sid', 'uid', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'sid' => 'Sid',
            'uid' => 'Uid',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    // 自己的文章投稿到专题      自己的专题或别人的专题
    public static function includeOwnartTosub($aid, $sid, $order = 2)
    {
        $artical = Artical::find()->where(['id' => $aid])->one();
        self::$auther = $artical['user_id'];
        $subject = Subjects::find()->where(['id' => $sid])->one();
        self::$submitinfor = $subject['submit'];
        self::$auditinfor = $subject['audit'];
        if(Yii::$app->user->identity->id == $subject['uid']){
            $include = Includes::find()->where(['aid' => $aid, 'sid' => $sid])->one();
            if($include){
                if($include->delete()){
                    return [
                        'message' => 7,
                    ];
                }
            }else{
                return self::saveInclude($aid, $sid, 1, 0);
            }
        }else{
            $includeA = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => Yii::$app->user->identity->id])->one();
            $includeB = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => $subject['uid']])->one();
            if($includeA || $includeB){
                if($includeA && $includeB){
                    $time = $includeB['created_at'];
                    if($includeB->delete()){
                        Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => -1, 'time' => $time]]));
                        return [
                            'message' => 5,
                        ];
                    }
                }else if($includeA){
                    if($includeA['status'] == 1 || $includeA['status'] == 2){
                        $includeA['status'] = 5;
                        if($includeA->save()){
                            Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => -1, 'time' => time()]]));
                            return [
                                'message' => 5,
                            ];
                        }
                    }else if($includeA['status'] == 4 || $includeA['status'] == 5){
                        return [
                            'message' => 6,
                        ];
                    }else if($includeA['status'] == 3){
                        $includeA['status'] = 5;
                        if($includeA->save()){
                            return [
                                'message' => 5,
                            ];
                        }
                    }
                }else if($includeB){
                    $time = $includeB['created_at'];
                    if($includeB->delete()){
                        Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => -1, 'time' => $time]]));
                        return [
                            'message' => 5,
                        ];
                    }
                }
            }else{
                if(self::$submitinfor == 1){
                    if(self::$auditinfor == 2){
                        return self::saveInclude($aid, $sid, 1, 1);
                    }else{
                        return self::saveInclude($aid, $sid, 3, 0);
                    }
                }else{
                    return [
                        'message' => 9,
                    ];
                }
            }
        }
    }
    // 别人的文章收入到专题     自己管理的专题
    // $uid 作者用户id
    public static function includeArtToOwnsub($aid, $sid, $order = 2)
    {
        $artical = Artical::find()->where(['id' => $aid])->one();
        self::$auther = $artical['user_id'];
        $includeA = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => self::$auther])->one();
        $includeB = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => Yii::$app->user->identity->id])->one();
        if($includeA || $includeB){
            if($includeA && $includeB){
                $time = $includeB['created_at'];
                if($includeB->delete()){
                    Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => -1, 'time' => $time]]));
                    return [
                        'message' => 7,
                    ];
                }
            }else if($includeA){
                if($includeA['status'] == 4 || $includeA['status'] == 5){
                    return self::saveInclude($aid, $sid, 1, 1);
                }else if($includeA['status'] == 1 || $includeA['status'] == 2){
                    $includeA['status'] = 4;
                    if($includeA->save()){
                        return [
                            'message' => 7,
                        ];
                    }
                }else if($includeA['status'] == 3){
                    $includeA['status'] = $order;
                    if($includeA->save()){
                        if($order == 2){
                            Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => 1, 'time' => $includeA['created_at']]]));
                        }
                        return [
                            'message' => $order,
                        ];
                    }
                }
            }else if($includeB){
                $time = $includeB['created_at'];
                if($includeB->delete()){
                    Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => -1, 'time' => $time]]));
                    return [
                        'message' => 7,
                    ];
                }
            }
        }else{
            return self::saveInclude($aid, $sid, 1, 1);
        }
    }
    public static function saveInclude($aid, $sid, $status, $number = 1)
    {
        $model = new Includes();
        $model->aid = $aid;
        $model->sid = $sid;
        $model->uid = Yii::$app->user->identity->id;
        $model->status = $status;
        $time = time();
        $model->created_at = $time;
        $model->updated_at = $time;
        if($model->save()){
            Yii::$app->trigger('frontend.include', new Event(['sender' => [ 'number' => $number, 'time' => $model->created_at]]));
            return [
                'message' => $status,
            ];
        }
    }
    public static function saveInlcudeInfor($event)
    {
        $data = $event->sender;
        $number = $data['number'];
        $time = $data['time'];
        if($number == 0){
            return;
        }
        $infor = Infor::find()->where(['uid' => self::$auther])->one();
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
        }
    }
    public static function ownDealRequest($include, $aid, $sid, $uid, $status)
    {
        if($status === 1){
            if($include->delete()){
                $result = [
                    'status' => 'fail',
                    'message' => '文章已经从专题移除',
                    'code' => 9,
                ];
                return $result;
            }
        }
        if($status === 2){
            $include->status = 7;
            if($include->save()){
                $result = [
                    'status' => 'fail',
                    'message' => '文章已经从专题移除',
                    'code' => 9,
                ];
                return $result;
            }
        }
        if($status === 3){
            $include->status = 2;
            if($include->save()){
                $result = [
                    'status' => 'success',
                    'message' => '文章已成功添加进专题',
                    'code' => 2,
                ];
                return $result;
            }
        }
        return self::addArticaltoSubbyOwn($aid, $sid, $uid);
    }
    public static function autherDealRequest($include, $aid, $sid, $uid, $status)
    {
        if($status === 1){
            if($include->delete()){
                $result = [
                    'status' => 'fail',
                    'message' => '文章已经从专题移除',
                    'code' => 8,
                ];
                return $result;
            }
        }
        if($status === 2){
            $include->status = 7;
            if($include->save()){
                $result = [
                    'status' => 'fail',
                    'message' => '文章已经从专题移除',
                    'code' => 8,
                ];
                return $result;
            }
        }
        if($status === 3){
            $include->status = 5;
            if($include->save()){
                $result = [
                    'status' => 'fail',
                    'message' => '文章已经从专题撤回',
                    'code' => 8,
                ];
                return $result;
            }
        }
    }
    // 向别人或自己的专题投稿
    public static function contriArtical($aid, $sid, $uid)
    {
        $include = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'status' => [4, 5, 6, 7]])->one();
        $subject = Subjects::find()->where(['id' => $sid, 'uid' => $uid])->one();
        if($subject){
            return self::addArticaltoSubbyOwn($aid, $sid, $uid);
        }else if($include){
            $result = [
                'status' => 'success',
                'message' => '文章已经投稿过该专题',
                'code' => 5,
            ];
            return $result;
        }else{
            return self::addArticaltoSubbyOther($aid, $sid, $uid);
        }
    }
    // 专题创建者向专题添加文章
    public static function addArticaltoSubbyOwn($aid, $sid, $uid)
    {
        $model = new Includes;
        $model->aid = $aid;
        $model->sid = $sid;
        $model->uid = $uid;
        $model->status = 1;
        $time = time();
        $model->created_at = $time;
        $model->updated_at = $time;
        $model->save();
        self::countraiseOtherInfor($aid, $sid);
        $result = [
            'status' => 'success',
            'message' => '文章成功添加到专题',
            'code' => 1,
        ];
        return $result;
    }
    // 非专题创建者向专题添加文章
    public static function addArticaltoSubbyOther($aid, $sid, $uid)
    {
        $right = self::validateRight($sid);
        if($right['status'] == 'ban'){
            $result = [
                'status' => 'ban',
                'message' => '此专题禁止投稿',
                'code' => 10,
            ];
            return $result;
        }
        $model = new Includes;
        $model->aid = $aid;
        $model->sid = $sid;
        $model->uid = $uid;
        if($right['status'] == 'audit'){
            $model->status = 3;
        }else{
            $model->status = 2;
        }
        $time = time();
        $model->created_at = $time;
        $model->updated_at = $time;
        $model->save();
        if($model->status == 2){
            self::countraiseOtherInfor($aid, $sid);
        }
        $result = [
            'status' => 'success',
            'message' => '文章投稿成功',
            'code' => $model->status,
        ];
        return $result;
    }
    public static function countreduceOtherInfor($aid, $sid)
    {
        $artical = Artical::find()->where(['id' => $aid])->one();
        $includes = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => Yii::$app->user->identity->id, 'tag' => 1])->all();
        if($includes){
            return;
        }
        $infor = Infor::find()->where(['uid' => $artical['user_id']])->one();
        if($infor){
            if($infor->others > 0){
                $infor->others = $infor->others - 1;
                $infor->save();
            }
        }else{
            $model = new Infor;
            $model->uid = $artical['user_id'];
            $model->comments = 0;
            $model->likes = 0;
            $model->follows = 0;
            $model->others = 0;
            $model->save();
        }
    }
    public static function countraiseOtherInfor($aid, $sid)
    {
        $artical = Artical::find()->where(['id' => $aid])->one();
        $includes = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => Yii::$app->user->identity->id, 'tag' => 1])->all();
        if($includes){
            return;
        }
        $infor = Infor::find()->where(['uid' => $artical['user_id']])->one();
        if($infor){
            $infor->others = $infor->others + 1;
            $infor->save();
        }else{
            $model = new Infor;
            $model->uid = $artical['user_id'];
            $model->comments = 0;
            $model->likes = 0;
            $model->follows = 0;
            $model->others = 1;
            $model->save();
        }
    }
    public static function validateRight($sid)
    {
        $subjects = Subjects::find()->where(['id' => $sid])->one();
        if($subjects->uid == Yii::$app->user->identity->id){
            return ['status' => 'noaudit'];
        }
        // 1允许投稿2不允许投稿
        if($subjects->submit == 2){
            return ['status' => 'ban'];
        }
        // 1审核2不审核
        if($subjects->audit == 1){
            return ['status' => 'audit'];
        }
    }
    /**
    * 通过专题的id查找需要审核的投稿请求
    */
    public static function findUntreadedRequests()
    {
        $subjects = Subjects::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        $sids = [];
        foreach ($subjects as $key => $value) {
            $sids[] = $value['id'];
        }
        $includes = Includes::find()->asArray()->with('artical', 'user')->where(['sid' => $sids, 'status' => 3])->all();
        foreach ($includes as $key => $value) {
            $articalinfor = Articalinfor::find()->asArray()->where(['aid' => $value['artical']['id']])->one();
            $includes[$key]['articalinfor'] = $articalinfor;
        }
        return $includes;
    }
    public static function findUntreatedBysubject($id)
    {
        $includes = Includes::find()->asArray()->with('artical', 'user')->where(['sid' => $id, 'status' => 3])->all();
        foreach ($includes as $key => $value) {
            $articalinfor = Articalinfor::find()->asArray()->where(['aid' => $value['artical']['id']])->one();
            $includes[$key]['articalinfor'] = $articalinfor;
        }
        return $includes;
    }
    public static function findCommonrequests($id)
    {
        $includes = Includes::find()->asArray()->with('artical', 'user')->where(['sid' => $id, 'status' => [2, 3, 4]])->all();
        foreach ($includes as $key => $value) {
            $articalinfor = Articalinfor::find()->asArray()->where(['aid' => $value['artical']['id']])->one();
            $includes[$key]['articalinfor'] = $articalinfor;
        }
        return $includes;
    }
    public static function dealRequest($id, $resu)
    {
        $include = Includes::find()->where(['id' => $id])->one();
        if(!$include){
            $result = [
                'status' => 'failed',
                'message' => '操作失败',
            ];
            return $result;
        }
        $include->status = $resu;
        $include->updated_at = time();
        if($include->save()){
            if($resu === 2){
                self::countraiseOtherInfor($include['aid'], $include['sid']);
            }
            $result = [
                'status' => 'success',
                'message' => '操作成功',
                'resu' => $resu,
            ];
            return $result;
        }
    }
    public static function saveIncluderequ($aid, $sid, $uid)
    {
        $subject = Subjects::find()->where(['id' => $sid, 'uid' => $uid])->one();
        // 如果专题是自己的
        if($subject){
            $include = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => $uid])->one();
            $otherincludes = Includes::find()->where(['and', 'uid != '.$uid, ['and', 'aid = '.$aid, 'sid = '.$sid]])->all();
            if($include){
                if($include->delete()){
                    for ($i=0; $i < count($otherincludes); $i++) { 
                        $otherincludes[$i]->status = 4;
                        $otherincludes[$i]->save();
                    }
                    $result = [
                        'status' => 'include',
                        'message' => '投稿',
                    ];
                    return $result;
                }
            }else{
                $model = new Includes;
                $model->aid = $aid;
                $model->sid = $sid;
                $model->uid = $uid;
                $model->status = 1;
                $time = time();
                $model->created_at = $time;
                $model->updated_at = $time;
                if($model->save()){
                    for ($i=0; $i < count($otherincludes); $i++) { 
                        $otherincludes[$i]->status = 2;
                        $otherincludes[$i]->save();
                    }
                    $result = [
                        'status' => 'remove',
                        'message' => '移除',
                    ];
                    return $result;
                }
            }
        }else{
            $include = Includes::find()->where(['aid' => $aid, 'sid' => $sid, 'uid' => $uid])->one();
            if($include){
                if($include['status'] == 3){
                    $include->status = 5;
                    if($include->save()){
                        $result = [
                            'status' => 'include',
                            'message' => '投稿',
                        ];
                        return $result;
                    }
                }else if($include['status'] == 1 || $include['status'] == 2){
                    if($include->delete()){
                        $result = [
                            'status' => 'include',
                            'message' => '投稿',
                        ];
                        return $result;
                    }
                }else if($include['status'] == 4 || $include['status'] == 5){
                    $result = [
                        'status' => 'contried',
                        'message' => '已经投过稿',
                    ];
                    return $result;
                }
            }else{
                $right = self::validateRight($sid);
                if($right['status'] == 'stop'){
                    $result = [
                        'status' => 'fail',
                        'message' => '此专题不能投稿',
                    ];
                    return $result;
                }
                $model = new Includes;
                $model->aid = $aid;
                $model->sid = $sid;
                $model->uid = Yii::$app->user->identity->id;
                if($right['status'] == 'audit'){
                    $model->status = 3;
                }else{
                    $model->status = 1;
                }
                $time = time();
                $model->created_at = $time;
                $model->updated_at = $time;
                if($model->save()){
                    if($model->status == 3){
                        $result = [
                            'status' => 'revoke',
                            'message' => '撤回投稿',
                        ];
                    }else if($model->status == 1){
                        $result = [
                            'status' => 'remove',
                            'message' => '移除',
                        ];
                    }
                    return $result;
                }
            }
        }
    }
    public static function saveIncludes($aid, $sid)
    {
        $includes = Includes::find()->where(['aid' => $aid, 'sid' => $sid])->one();
        $artical = Artical::find()->where(['id' => $aid])->one();
        if($includes){
            if($includes->delete()){
                $result = [
                    'status' => 'cancel',
                    'message' => '取消投稿',
                    'id' => $artical->id,
                    'title' => $artical->title,
                ];
                return $result;
            }
        }else{
            $right = self::validateRight($sid);
            if($right['status'] == 'stop'){
                $result = [
                    'status' => 'fail',
                    'message' => '此专题不能投稿',
                ];
                return $result;
            }
            $model = new Includes;
            $model->aid = $aid;
            $model->sid = $sid;
            $model->uid = Yii::$app->user->identity->id;
            if($right['status'] == 'audit'){
                $model->status = 3;
            }else{
                $model->status = 1;
            }
            $time = time();
            $model->created_at = $time;
            $model->updated_at = $time;
            if($model->save()){
                $result = [
                    'status' => 'include',
                    'message' => '收录成功',
                    'id' => $artical->id,
                    'title' => $artical->title,
                ];
                return $result;
            }
        }
    }
}
