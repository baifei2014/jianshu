<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Artical;
use yii\data\Pagination;
use common\models\Comment;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class ReplyController extends Controller
{
    /**
     * @inheritdoc
     */
    const PAGE_SIZE = 50;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
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
    public function actionView($id)
    {
        $model = Artical::findOne($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::findCommentList($id),
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]]
        ]);
        $models = new Comment;
        return $this->render('view',['model' => $model,'models' => $models,'dataProvider' => $dataProvider,'comment' => new Comment(),]);
    }
    public function actionReply()
    {
        print_r(Yii::$app->request->post());
        return $this->render('reply');
    }
}
