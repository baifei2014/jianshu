<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Userexinfor;
use common\models\Articalset;
use common\models\Userinfor;
use common\models\Setinfor;
use common\models\Infor;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $nickname;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['nickname', 'unique', 'targetClass' => '\common\models\User', 'message' => '这个昵称已经被使用.'],
            ['nickname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '这个邮箱已经注册过了.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->nickname = $this->nickname;
        $user->avatar = 'statics/images/avatar.png';
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if($user->save()){
            $this->id = $user->id;
            $model = new Articalset;
            $model->uid = $this->id;
            $model->name = '日记本';
            $model->created_at = time();
            if($model->save()){
                $setinfor = new Setinfor;
                $setinfor->sid = $this->id;
                $setinfor->save();
            }
            $userexinfor = new Userexinfor;
            $userexinfor->user_id = $this->id;
            $userexinfor->save();
            $userinfor = new Userinfor;
            $userinfor->uid = $this->id;
            $userinfor->sex = '男';
            $userinfor->save();
            $infor = new Infor();
            $infor->uid = $this->id;
            $time = time();
            $infor->commentstime = $time;
            $infor->commentsuptime = $time;
            $infor->likestime = $time;
            $infor->likesuptime = $time;
            $infor->followstime = $time;
            $infor->followsuptime = $time;
            $infor->otherstime = $time;
            $infor->othersuptime = $time;
            $infor->save();
            return $user;
        }else{
            return null;
        }
    }
    public function attributeLabels()
    {
        return [
            'nickname' => '昵称',
            'email' => '邮箱',
            'password' => '密码',
        ];
    }
}
