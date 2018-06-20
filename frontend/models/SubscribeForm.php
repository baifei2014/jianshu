<?php 
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Subscribe;

class SubscribeForm extends Model
{
    const STATUS_SUBSCRIBE = 1;
    public $email;
    public function rules()
    {
        return [
            [['created_at', 'update_at'], 'integer'],
            [['email', 'auth_key', 'subscribe_token'], 'string', 'max' => 255],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'subscribe_token' => 'Subscribe Token',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }
    public function saveSubscriber()
    {
        $email = Subscribe::findOne(['email' => $this->email]);
        if($email){
            return false;
        }
        $model = new Subscribe;
        $model->email = $this->email;
        $model->auth_key = Yii::$app->security->generateRandomString();
        $model->created_at = time();
        $model->update_at = time();
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
    public function sendEmail()
    {
        $subscriber = Subscribe::findOne(['email' => $this->email]);
        if(!$subscriber){
            return false;
        }
        if(!self::isSubscribeTokenValid($subscriber->subscribe_token)){
            $subscriber->generateSubscribeToken();
            if(!$subscriber->save()){
                return false;
            }
        }
        return Yii::$app
            ->mailer
            ->compose('subscribe-html', ['subscriber' => $subscriber])
            ->setTo($this->email)
            ->setSubject('订阅爱阅团')
            ->send();
    }
    public static function isSubscribeTokenValid($token)
    {
        if(empty($token)){
            return false;
        }
        $timestamp = substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    public static function checkToken($token)
    {
        if(!self::isSubscribeTokenValid($token)){
            return false;
        }
        $model = Subscribe::findOne(['subscribe_token' => $token]);
        if(!$model){
            return false;
        }
        $model->status = self::STATUS_SUBSCRIBE;
        $model->subscribe_token = null;
        return $model->save();
    }
    public static function checkEmail($email)
    {
        $email = Subscribe::find()->where(['email' => $email])->one();
        if($email){
            return '此邮箱已经订阅过我们网站';
        }else{
            return null;
        }
    }
}
