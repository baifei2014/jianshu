<?php

namespace frontend\models;

use Yii;
use common\models\Artical;
use frontend\models\ArticaltagForm;
use common\models\Articaltag;
use common\models\Articaltype;
use common\models\User;
use common\models\Articalinfor;
use common\models\Articalset;
use common\models\Includes;
use common\models\Userinfor;
use common\models\Setinfor;
use yii\web\NotFoundHttpException;
use common\models\Userexinfor;

/**
 * This is the model class for table "artical".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $type_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class ArticalForm extends \yii\base\Model
{
    public $title;
    public $content;
    public $file;
    public $created_at;
    public $updated_at;
    public $img;
    public $tag;
    public $id;
    public $set;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required', 'message' => '{attribute}必填'],
            [['content', 'tag'], 'string'],
            [['created_at', 'updated_at', 'set', 'words'], 'integer'],
            ['title', 'string', 'max' => 64, 'tooLong' => '标题不可超过64个字'],
            [['img'],'file','extensions' => 'jpg,png,gif','maxSize'=>1024000,'checkExtensionByMimeType' => true],
        ];
    }
    public static function findBykeyword($keyword, $sid)
    {
        if($keyword == ''){
            return [];
        }
        $articals = Artical::find()->asArray()->where(['title' => $keyword, 'user_id' => Yii::$app->user->identity->id])->all();
        if($articals){
            foreach ($articals as $key => $value) {
                $includes = Includes::find()->where(['aid' => $value['id'], 'sid' => $sid])->one();
                $articals[$key]['includes'] = $includes;
            }
            return $articals;
        }
        $result = [];
        $articals = Artical::find()->where(['user_id' => Yii::$app->user->identity->id])->asArray()->all();
        foreach ($articals as $key => $value) {
            if(preg_match("/".$keyword."/", $value['title']) > 0){
                $result[] = $value;
            }
        }
        if($result){
            foreach ($result as $key => $value) {
                $includes = Includes::find()->where(['aid' => $value['id'], 'sid' => $sid])->one();
                $result[$key]['includes'] = $includes;
            }
            return $result;
        }
        foreach ($articals as $key => $value) {
            if(preg_match("/".$keyword."/", $value['content']) > 0){
                $result[] = $value;
            }
        }
        if($result){
            foreach ($result as $key => $value) {
                $includes = Includes::find()->where(['aid' => $value['id'], 'sid' => $sid])->one();
                $result[$key]['includes'] = $includes;
            }
            return $result;
        }
        return [];

    }
    public static function findArticals()
    {
        $articals = Artical::find()->with('user', 'articalinfor')->orderBy('id desc')->all();
        return $articals;
    }
    public static function findArtical($id)
    {
        $artical = Artical::find()->where(['id' => $id])->with('user', 'userinfor', 'userexinfor', 'articalset')->one();
        if($artical){
            return $artical;
        }else{
            throw new NotFoundHttpException('您要找的内容不存在');
        }
    }
    public function saveArtical()
    {
        $model = new Artical;
        try{
            $model->title = $this->title;
            $model->img = $this->img;
            $model->content = self::getContent($this->content);
            $model->summary = self::getSummary($this->content);
            $model->set_id = $this->set;
            $model->user_id = Yii::$app->user->identity->id;
            $model->created_at = $this->created_at;
            $model->updated_at = $this->updated_at;
            $model->words = self::wordsCount($this->content);
            if(!$model->save()){
                return false;
            }
            $this->id = $model->id;
            if($this->tag){
                if(!self::saveTag($this->tag,$this->id)){
                    return false;
                }
            }
            $userexinfor = Userexinfor::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            $userexinfor->artical = $userexinfor->artical + 1;
            $userexinfor->words = $userexinfor->words + $model->words;
            $userexinfor->save();
            $setinfor = Setinfor::find()->where(['sid' => $this->set])->one();
            $setinfor->artical = $setinfor->artical + 1;
            $setinfor->words = $setinfor->words + $model->words;
            $setinfor->save();
            $articalinfor = new Articalinfor;
            $articalinfor->aid = $this->id;
            $articalinfor->set_id = $this->set;
            $articalinfor->save();
            return true;

        }catch(Exception $e){
            if(file_exists($this->img)){
                unlink($this->img);
            }
            return false;
        }
    }
    public static function wordsCount($content)
    {
        $str = strip_tags($content);
        $pattern = '/([\s|&nbsp;]*)*/';
        $replacestr = '';
        $strs = preg_replace($pattern, $replacestr, $str);
        $words = iconv_strlen($strs,"utf-8");
        return $words;
    }
    public static function saveTag($tags,$aid)
    {
        $tagarray = explode(',', $tags);
        foreach ($tagarray as $key => $value) {
            $data = Articaltag::find()->where(['tag' => $value])->one();
            if($data){
                $tid = $data->id;
                $model = new Articaltype;
                $model->aid = $aid;
                $model->tid = $tid;
                $model->save();
            }else{
                $model = new Articaltag;
                $model->tag = $value;
                if($model->save()){
                    $tid = $model->id;
                    $model = new Articaltype;
                    $model->aid = $aid;
                    $model->tid = $tid;
                    $model->save();
                }
            }
        }
        return true;
    }
    public static function getSummary($content)
    {
        if(mb_strlen($content) > 100){
            return mb_substr(strip_tags($content), 0, 100).'....';
        }else{
            return strip_tags($content).'....';
        }
    }
    public static function getContent($content)
    {
        $toppattern1 = '/^(\s)*<p style="color:#444444;font-family:&quot;font-size:medium;font-style:normal;font-weight:normal;text-align:start;text-indent:0px;background-color:#FFFFFF;"\>/';
        $toppattern2 = '/^(\s)*<br\s\/>/';
        $toppattern3 = '/^(\s)*<\/p>/';
        $bottompattern1 = '/(\s)*<\/p>$/';
        $bottompattern2 = '/(\s)*<\/strong>$/';
        $bottompattern3 = '/(\s)*<br \/>$/';
        $bottompattern4 = '/(\s)*<strong>$/';
        $bottompattern5 = '/(\s)*<p>$/';
        while(preg_match($toppattern1, $content)){
            $content = preg_replace($toppattern1, '', $content);
            if(preg_match($toppattern2, $content)){
                $content = preg_replace($toppattern2, '', $content);
                $content = preg_replace($toppattern3, '', $content);
            }else{
                $content = '<p>'.$content;
                break;
            }
        }
        while (preg_match($bottompattern1, $content)) {
            $content = preg_replace($bottompattern1, '', $content);
            if(preg_match($bottompattern2, $content)){
                $content = preg_replace($bottompattern2, '', $content);
            }else{
                $content = $content.'</p>';
                break;
            }
            if (preg_match($bottompattern3, $content)) {
                $content = preg_replace($bottompattern3, '', $content);
                $content = preg_replace($bottompattern4, '', $content);
                $content = preg_replace($bottompattern5, '', $content);
            }else{
                $content = $content.'</strong></p>';
                break;
            }
        }
        return $content;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'label_img' => 'Label Img',
            'type_id' => 'Type ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'words' => 'Words',
        ];
    }
}
