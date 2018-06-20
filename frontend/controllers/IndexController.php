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
use common\models\User;

use common\models\UploadForm;
use yii\web\UploadedFile;
use frontend\models\ArticalForm;
use frontend\models\CommentsForm;
use common\models\Comments;
use frontend\models\SubscribeForm;
use frontend\models\SearchForm;

/**
 * Site controller
 */
class IndexController extends Controller
{
    /**
     * @inheritdoc
     */
    const PAGE_SIZE = 50;
    // public $layout = false;
    public $error;
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
        $starartical = ArticalForm::findStarArtical();
        $allartical = Artical::find();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $allartical->count(),
            ]);
        $artical = $allartical->orderBy('id desc' )
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        $artical = ArticalForm::addTag($artical);
        return $this->render('index',['artical' => $artical, 'pagination' => $pagination, 'starartical' => $starartical]);
    }
    public function actionSubscribe()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->get();
            return SubscribeForm::checkEmail($data['email']);
        }
        if(Yii::$app->request->isPost){
            $model = new SubscribeForm;
            if($model->load(Yii::$app->request->post()) && $model->saveSubscriber()){
                if($model->sendEmail()){
                    return $this->render('subscribe');
                }
            }else{
                return $this->goHome();
            }
        }
    }
    public function actionRealscribe($token) // $token
    {
        if(SubscribeForm::checkToken($token)){
            return $this->render('realscribe');
        }
        return $this->goHome();
    }
    public function actionSearch()
    {
        if(Yii::$app->request->isPost){
            $model = new SearchForm;
            if($model->load(Yii::$app->request->post())){
                $data = $model->findContent();
                $postdata = Yii::$app->request->post();
                $keyword = $postdata['SearchForm']['keyword'];
                return $this->render('search', ['data' => $data, 'keyword' => $keyword, 'model' => $model]);
            }
        }
        return $this->goHome();
    }
    public function actionComment($id = '', $place = 'a0')
    {
        if(Yii::$app->request->isPost){
            $model = new CommentsForm;
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->saveComment($id)){
                    return $this->redirect(['index/detail', 'id' => $id, '#' => $place]);
                }else{
                    Yii::$app->session->setFlash('error', '保存失败');
                    return $this->redirect(['index/detail', 'id' => $id]);
                }
            }
        }
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->get();
            return CommentsForm::checkajaxEmail($data['email'], $data['nickname']);
        }
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
        return $this->render('view',['model' => $model,'dataProvider' => $dataProvider,'comment' => new Comment(),]);
    }
    public function actionDetail($id)
    {
        if($id){
            $artical = Artical::find()->where(['id' => $id])->one();
            $nextartical = Artical::nextArtical($id);
            $comment = Comments::findComment($id);
            $model = new CommentsForm;
            return $this->render('detail', ['artical' => $artical, 'nextartical' => $nextartical, 'comment' => $comment, 'model' => $model]);
        }
    }
    public function actionMail()
    {
        $user = ['email' => '759395919@qq.com', 'token' => '20170325'];
        $mail= Yii::$app->mailer->compose('subscribe-html', ['user' => $user]);
        $mail->setTo('759395919@qq.com');  
        $mail->setSubject("订阅爱阅团");
        //$mail->setTextBody('zheshisha ');   //发布纯文字文本
        if($mail->send())  
            echo "success";  
        else  
            echo "failse";   
        die(); 
    }
    public function actionUpload()
    {
    $model = new UploadForm();

    if (Yii::$app->request->isPost) {
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->file && $model->validate()) {
            $model->file->saveAs('d:/wamp/www/advanced/frontend/uploads/' . $model->file->baseName . '.' . $model->file->extension);
        }
    }

    return $this->render('upload', ['model' => $model]);
    }
    public function actionEditor()
    {
        $model = new CommentsForm;
        if(Yii::$app->request->isAjax){
            echo '哈哈哈';
        }
        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                print_r(Yii::$app->request->post());die();
                $model = new CommentsForm;
            }else{
                print_r(Yii::$app->request->post());die();
            }
        }
        return $this->render('editor', ['model' => $model]);
    }
    public function actionAbc()
    {
        echo '哈哈哈';
    }

}
