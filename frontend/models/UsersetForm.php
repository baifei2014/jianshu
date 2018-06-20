<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\User;
/**
 * Signup form
 */
class UsersetForm extends Model
{
    public $nickname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['nickname', 'checkunique'],
            ['nickname', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    public function checkunique($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $query = (new \yii\db\Query())
                ->select(['nickname'])
                ->from('user')
                ->where(['nickname' => $this->nickname]);
            $query->andwhere(['not in', 'id', Yii::$app->user->identity->id]);
            $data = $query->all();
            if ($data) {
                $this->addError($attribute, '昵称已经被别人使用.');
            }
        }
    }
    public static function checkNickname($nickname)
    {
        if($nickname == ''){
            return false;
        }
        if(mb_strlen($nickname) < 2 || mb_strlen($nickname) > 255){
            return false;
        }
        $query = (new \yii\db\Query())
            ->select(['nickname'])
            ->from('user')
            ->where(['nickname' => $nickname]);
        $query->andwhere(['not in', 'id', Yii::$app->user->identity->id]);
        $data = $query->all();
        if ($data) {
            return false;
        }
        return true;
    }
    public static function saveNickname($nickname)
    {
        if(!self::checkNickname($nickname)){
            $result = [
                'status' => 'error',
                'message' => '昵称不合法',
            ];
            return $result;
        }
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        if(!$user){
            $result = [
                'status' => 'error',
                'message' => '保存失败',
            ];
            return $result;
        }
        if($nickname == $user->nickname){
            $result = [
                'status' => 'success',
                'message' => '保存成功',
                'words' => $nickname,
            ];
            return $result;
        }
        $user->nickname = $nickname;
        if($user->save()){
            $result = [
                'status' => 'success',
                'message' => '保存成功',
                'words' => $nickname,
            ];
            return $result;
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
