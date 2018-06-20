<?php

namespace frontend\models;

use Yii;
use common\models\Userinfor;
use common\models\User;

/**
 * This is the model class for table "userinfor".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $avatar
 * @property string $sex
 * @property string $summary
 * @property string $web
 * @property string $qrcode
 */
class UserinforForm extends \yii\base\Model
{

    public $file;
    public $summary;
    public $qrcode;
    public $web;
    public $sex;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png'],
            [['avatar', 'summary', 'web', 'qrcode'], 'string', 'max' => 255],
            [['sex'], 'string', 'max' => 6],
        ];
    }

    public static function saveSex($sex)
    {
        $model = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        if(!$model){
            $result = [
                'status' => 'error',
                'message' => '保存失败',
            ];
            return $result;
        }
        if($sex == $model->sex){
            $result = [
                'status' => 'success',
                'message' => '保存成功',
                'words' => $sex,
            ];
            return $result;
        }
        $model->sex = $sex;
        if($model->update()){
            $result = [
                'status' => 'success',
                'message' => '保存成功',
                'words' => $sex,
            ];
            return $result;
        }
    }
    public static function checkweb($web)
    {
        if($web != ''){
            $pattern = '/(https|http):\/\/([\S]+)+:?([\d]*)?([\/\S]*)?/';
            $isMatched = preg_match($pattern, $web, $matches);
            if($isMatched == 0){
                return $false;
            }
        }
        return true;
    }
    public static function saveWeb($web)
    {
        if(!self::checkweb($web)){
            $result = [
                'status' => 'error',
                'message' => 'url地址不合法',
            ];
            return $result;
        }
        $model = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        if(!$model){
            $result = [
                'status' => 'error',
                'message' => '保存失败',
            ];
            return $result;
        }
        $model->web = $web;
        if($model->save()){
            $result = [
                'status' => 'success',
                'message' => '保存成功',
                'words' => $web,
            ];
            return $result;
        }
    }
    public static function saveSummary($summary)
    {
        $model = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        if(!$model){
            $result = [
                'status' => 'error',
                'message' => '保存失败',
            ];
            return $result;
        }
        $model->summary = $summary;
        if($model->save()){
            $result = [
                'status' => 'success',
                'message' => '保存成功',
                'words' => $summary,
            ];
            return $result;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'sex' => 'Sex',
            'summary' => 'Summary',
            'web' => 'Web',
            'qrcode' => 'Qrcode',
        ];
    }
    public static function saveAvatar($filename)
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        if($user){
            $oldfilename = $user['avatar'];
            if(file_exists($oldfilename)){
                if($oldfilename != 'statics/images/avatar.png'){
                    unlink($oldfilename);
                }
            }
            $user->avatar = $filename;
            if($user->save()){
                return true;
            }
        }else{
            $model = new User;
            $model->uid = Yii::$app->user->identity->id;
            $model->avatar = $filename;
            if($model->save()){
                return true;
            }
        }
    }
    public static function saveQrcode($filename)
    {
        $user = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        if($user){
            $oldfilename = $user['qrcode'];
            if(file_exists($oldfilename)){
                unlink($oldfilename);
            }
            $user->qrcode = $filename;
            if($user->save()){
                return true;
            }
        }else{
            $model = new Userinfor;
            $model->uid = Yii::$app->user->identity->id;
            $model->qrcode = $filename;
            if($model->save()){
                return true;
            }
        }
    }
}
