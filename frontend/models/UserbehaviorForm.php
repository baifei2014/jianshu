<?php

namespace frontend\models;

use Yii;
use common\models\Userbehavior;
use common\models\Like;
use common\models\User;
use common\models\Userexinfor;
use common\models\Focus;
use common\models\Comment;
use common\models\Articalset;
use common\models\Subjects;
use frontend\models\UserexinforForm;
use frontend\models\SubinforForm;
use frontend\models\SetinforForm;

/**
 * This is the model class for table "userbehavior".
 *
 * @property integer $id
 * @property integer $o_id
 * @property string $type
 * @property integer $created_at
 */
class UserbehaviorForm extends \yii\base\Model
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['o_id', 'created_at', 'u_id'], 'integer'],
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
            'o_id' => 'O ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'u_id' => 'U Id',
        ];
    }

    public static function saveCommentbehavior($aid, $cid)
    {
        $model = new Userbehavior;
        $model->aid = $aid;
        $model->uid = Yii::$app->user->identity->id;
        $model->cid = $cid;
        $model->behavior = '发表了评论';
        $model->created_at = time();
        if($model->save()){
            return true;
        }
    }
    public static function getUserBehavior($id)
    {
        $userbehavior = Userbehavior::find()->with('user')->orderBy('id desc')->where(['u_id' => $id])->asArray()->all();
        foreach ($userbehavior as $key => $value) {
            if($value['type'] == 'like'){
                $like = Like::find()->asArray()->with('artical', 'articalinfor')->where(['id' => $value['o_id']])->one();
                $user = User::find()->asArray()->where(['id' => $like['artical']['user_id']])->one();
                $like['artical']['user'] = $user;
                $userbehavior[$key]['result'] = $like;
            }
            if($value['type'] == 'comment'){
                $comment = Comment::find()->asArray()->with('artical', 'bereplyer' ,'articalinfor')->where(['id' => $value['o_id']])->one();
                $user = User::find()->asArray()->where(['id' => $comment['artical']['user_id']])->one();
                $comment['artical']['user'] = $user;
                $userbehavior[$key]['result'] = $comment;
            }
            // 如果动态为关注
            // 然后判断是关注人或专题或文集
            
            if($value['type'] == 'auther'){
                $focus = Focus::find()->asArray()->where(['id' => $value['o_id']])->one();
                $infor = User::find()->with('userinfor')->asArray()->where(['id' => $focus['f_id']])->one();
                if(!Yii::$app->user->isGuest){
                    $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $infor['id'], 'type' => 'auther'])->one();
                    $focus['isfocus'] = $isfocus;
                }
                $uexinfor = Userexinfor::find()->where(['user_id' =>$focus['f_id']])->one();
                $focus['infor'] = $infor;
                $focus['uexinfor'] = $uexinfor;
                $userbehavior[$key]['result'] = $focus;
            }
            if($value['type'] == 'subject'){
                $focus = Focus::find()->asArray()->where(['id' => $value['o_id']])->one();
                $infor = Subjects::find()->with('maker')->asArray()->where(['id' => $focus['f_id']])->one();
                if(!Yii::$app->user->isGuest){
                    $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $infor['id'], 'type' => 'subject'])->one();
                    $focus['isfocus'] = $isfocus;
                }
                $subinfor = SubinforForm::getSubinfor($focus['f_id']);
                $focus['infor'] = $infor;
                $focus['subinfor'] = $subinfor;
                $userbehavior[$key]['result'] = $focus;
            }
            if($value['type'] == 'set'){
                $focus = Focus::find()->asArray()->where(['id' => $value['o_id']])->one();
                $infor = Articalset::find()->with('maker')->asArray()->where(['id' => $focus['f_id']])->one();
                if(!Yii::$app->user->isGuest){
                    $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $infor['id'], 'type' => 'set'])->one();
                    $focus['isfocus'] = $isfocus;
                }
                $setinfor = SetinforForm::getSetinfor($focus['f_id']);
                $focus['infor'] = $infor;
                $focus['setinfor'] = $setinfor;
                $userbehavior[$key]['result'] = $focus;
            }
        }
        return $userbehavior;
    }
}
