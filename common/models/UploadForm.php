<?php 
namespace common\models;

use yii\base\model;
use yii\web\uploadedfile;

class UploadForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'],'file'],
        ];
    }
}
