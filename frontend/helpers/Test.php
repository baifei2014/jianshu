<?php 
namespace frontend\helpers;

use yii;
use common\models\Userinfor;
class Test
{
    public static function saveInfor()
    {
        $userinfor = Userinfor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        if($userinfor){
            echo '哈哈哈';die();
        }else{
            echo '呵呵呵呵';die();
        }
        $userinfor->uid = Yii::$app->user->identity->id;
        $userinfor->sex = '南岸';
        if($userinfor->save()){
            echo '哈哈哈哈';die();
        }else{
            echo 'hehheh';die();
        }
    }
    public static function findInfor()
    {
        $query = (new \yii\db\Query())
            ->select(['nickname'])
            ->from('user')
            ->where(['nickname' => '我是谁']);
        $query->andwhere(['not in', 'id', Yii::$app->user->identity->id]);
        $data = $query->all();
        if ($data) {
            // $this->addError($attribute, '邮箱或密码错误.');
            return ['哈哈哈哈'];
        }else{
            return ['呵呵呵呵呵'];
        }
    }
}
