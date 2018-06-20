<?php

namespace frontend\modules\blog\controllers;

use yii\web\Controller;
use common\models\Posts;

/**
 * Default controller for the `blog` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $lastarticals = Posts::findLastArticals();
        $lastartical = Posts::findLastArtical();
        return $this->render('index',['lastarticals' => $lastarticals,'lastartical' => $lastartical]);
    }
    public function actionArtical($id)
    {
        $artical = Posts::findArtical($id);
        $preartical = Posts::findpreArtical($id);
        return $this->render('artical',['artical' => $artical,'preartical' => $preartical]);
    }
    public function actionMoarts()
    {
        $lastarticals = Posts::findMoArts();
        $lastartical = Posts::findLastArtical();
        $num =  count($lastarticals);
        return $this->render('moarts',['lastartical' => $lastartical,'lastarticals' => $lastarticals,'num' => $num]);
    }
    public function actionAbout()
    {
        return $this->render('about');
    }
}
