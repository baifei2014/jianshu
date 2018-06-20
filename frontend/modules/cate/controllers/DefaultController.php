<?php

namespace frontend\modules\cate\controllers;

use yii\web\Controller;
use common\models\Artical;
use yii\data\Pagination;

/**
 * Default controller for the `cate` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $topics = Artical::find();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $topics->count(),
            ]);
        $articals = $topics->orderBy('id desc' )
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['articals' => $articals,'pagination' => $pagination]);
    }
}
