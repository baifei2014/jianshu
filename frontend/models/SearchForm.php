<?php 
namespace frontend\models;

use Yii;
use common\models\Artical;
use yii\db\Query;

class SearchForm extends \yii\base\Model
{
    public $keyword;
    public function rules()
    {
        return [
            ['keyword', 'required'],
            [['keyword'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'keyword' => '关键字',
        ];
    }
    public function findContent()
    {
        if(empty($this->keyword)){
            return [];
        }
        $query = new Query;
        $byauther = $query->select('*')
                    ->from('artical')
                    ->where(['auther' => $this->keyword])
                    ->all();
        $bytitle = $query->select('*')
                    ->from('artical')
                    ->where(['title' => $this->keyword])
                    ->all();
        if($byauther || $bytitle){
            $data = array_merge($byauther, $bytitle);
            return $this->addChangeTitle($data);
        }
        $bylikeauther = $query->select('*')
                    ->from('artical')
                    ->where(['like', 'auther', $this->keyword])
                    ->all();
        $byliketitle = $query->select('*')
                    ->from('artical')
                    ->where(['like', 'title', $this->keyword])
                    ->all();
        if($bylikeauther || $byliketitle){
            $data = array_merge($bylikeauther, $byliketitle);
            return $this->addChangeTitle($data);
        }
    }
    public function addChangeTitle($allartical)
    {
        if(empty($allartical)){
            return false;
        }
        foreach ($allartical as $key => $value) {
            if(mb_strlen($value['title']) > 30){
                $allartical[$key]['oldtitle'] = $value['title'];
                $allartical[$key]['title'] = mb_substr($value['title'], 0, 30).' ....';
            }else{
                $allartical[$key]['oldtitle'] = $value['title'];
                $allartical[$key]['title'] = $value['title'];
            }
        }
        return $allartical;
    }
}
