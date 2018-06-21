<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
//use yii\web\Controller;
use frontend\controllers\base\BaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Artical;
use yii\data\Pagination;
use common\models\User;
use frontend\models\ArticalForm;
use frontend\models\CommentForm;
use frontend\models\ArticalinforForm;
use common\models\Articalinfor;
use common\models\Userbehavior;
use common\models\Articalset;
use common\models\Collect;
use frontend\models\LikeForm;
use common\models\Like;
use common\models\Focus;
use common\models\Subjects;
use common\models\Includes;
use frontend\models\IncludesForm;
use common\models\Infor;
use common\models\Comment;
use yii\web\Response;
use yii\base\Event;
use yii\base\Exception;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
        // return [
        //     'access' => [
        //         'class' => AccessControl::className(),
        //         'only' => ['logout', 'signup'],
        //         'rules' => [
        //             [
        //                 'actions' => ['signup'],
        //                 'allow' => true,
        //                 'roles' => ['?'],
        //             ],
        //             [
        //                 'actions' => ['logout'],
        //                 'allow' => true,
        //                 'roles' => ['@'],
        //             ],
        //         ],
        //     ],
        //     'verbs' => [
        //         'class' => VerbFilter::className(),
        //         'actions' => [
        //             'logout' => ['post'],
        //         ],
        //     ],
        // ];
    // }

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
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $articals = ArticalForm::findArticals();
        return $this->render('index', ['articals' => $articals]);
    }
    public function actionP($id)
    {
        $artical = ArticalForm::findArtical($id);
        $articalinfor = Articalinfor::find()->where(['aid' => $id])->one();
        ArticalinforForm::saveBrower($id);
        $model = new CommentForm;
        if(Yii::$app->user->isGuest){
            $isfocus = null;
            $collect = null;
            $islike = null;
        }else{
            $isfocus = Focus::find()->where(['u_id' => Yii::$app->user->identity->id, 'f_id' => $artical['user_id'], 'type' => 'auther'])->one();
            $collect = Collect::find()->where(['uid' => Yii::$app->user->identity->id, 'aid' => $id])->one();
            // print_r($comments);die();
            $islike = Like::find()->where(['u_id' => Yii::$app->user->identity->id, 'a_id' => $id])->one();
        }

        // 创建一个 DB 查询来获得所有 status 为 1 的文章
        $query = Comment::find()->where(['p_id' => 0, 'a_id' => $id]);

        // 得到文章的总数（但是还没有从数据库取数据）
        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination(['defaultPageSize' => 15, 'totalCount' => $count]);
        // 使用分页对象来填充 limit 子句并取得文章数据
        $comments = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('id desc')
            ->all();
        $rcomments = CommentForm::findComments($comments, $id);
        $commentnum = CommentForm::findCommentNum($id);
        return $this->render('p', ['artical' => $artical, 'collect' => $collect, 'articalinfor' => $articalinfor, 'model' => $model, 'rcomments' => $rcomments, 'commentnum' => $commentnum, 'islike' => $islike, 'isfocus' => $isfocus, 'pagination' => $pagination]);
    }
    public function actionSubject()
    {
        $data = Yii::$app->request->post();
        if(isset($data['keyword'])){
            if($data['keyword'] == ''){
                $subjects = Subjects::find()->asArray()->with('user')->where(['uid' => $data['uid'], 'name' => $data['keyword']])->all();
            }else{
                $subjects = Subjects::find()->asArray()->with('user')->where(['and', 'uid = '. $data['uid'], ['like', 'name', $data['keyword']]])->all();
            }
            foreach ($subjects as $key => $value) {
                $include = Includes::find()->asArray()->where(['aid' => $data['aid'], 'sid' => $value['id'], 'status' => [1, 2]])->one();
                $subjects[$key]['include'] = $include;
            }
        }else{
            $subjects = Subjects::find()->asArray()->with('user')->where(['uid' => Yii::$app->user->identity->id])->all();
            foreach ($subjects as $key => $value) {
                $include = Includes::find()->asArray()->where(['aid' => $data['aid'], 'sid' => $value['id'], 'status' => [1, 2]])->one();
                $subjects[$key]['include'] = $include;
            }
        }
        return $this->renderPartial('subject', ['subjects' => $subjects, 'aid' => $data['aid']]);
    }
    public function actionAllsubject()
    {
        $data = Yii::$app->request->post();
        // 查出自己的专题
        $ownsubjects = Subjects::find()->asArray()->where(['uid' => Yii::$app->user->identity->id])->all();
        // 先暂时查出不是自己的专题
        $othersubjects = Subjects::find()->asArray()->where(['!=', 'uid', Yii::$app->user->identity->id])->limit(8)->all();
        foreach ($ownsubjects as $key => $value) {
            $include = Includes::find()->asArray()->where(['aid' => $data['aid'], 'sid' => $value['id']])->one();
            $ownsubjects[$key]['include'] = $include;
        }
        foreach ($othersubjects as $key => $value) {
            $include = Includes::find()->asArray()->where(['aid' => $data['aid'], 'sid' => $value['id']])->one();
            $othersubjects[$key]['include'] = $include;
        }
        return $this->renderPartial('allsubject', ['ownsubjects' => $ownsubjects, 'othersubjects' => $othersubjects, 'aid' => $data['aid']]);
    }
    public function actionSearchsubject()
    {
        $data = Yii::$app->request->post();
        if(isset($data['keyword'])){
            if($data['keyword'] == ''){
                $subjects = Subjects::find()->asArray()->with('user')->where(['name' => $data['keyword']])->all();
            }else{
                $subjects = Subjects::find()->asArray()->with('user')->where(['like', 'name', $data['keyword']])->all();
            }
            foreach ($subjects as $key => $value) {
                $include = Includes::find()->asArray()->where(['aid' => $data['aid'], 'sid' => $value['id']])->one();
                $subjects[$key]['include'] = $include;
            }
        }
        return $this->renderPartial('searchsubject', ['subjects' => $subjects, 'aid' => $data['aid']]);
    }
    public function actionIncludea()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            Yii::$app->on('frontend.include', ['frontend\models\IncludesForm', 'saveInlcudeInfor']);
            $result = IncludesForm::includeArtToOwnsub($data['aid'], $data['sid']);
            return json_encode($result);
        }
    }
    public function actionIncludeb()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            Yii::$app->on('frontend.include', ['frontend\models\IncludesForm', 'saveInlcudeInfor']);
            $result = IncludesForm::includeOwnartTosub($data['aid'], $data['sid']);
            return json_encode($result);
        }
    }
    public function actionTestc()
    {
        Yii::$app->cache->set('name', '蒋龙豪');
        echo Yii::$app->cache->get('name');
    }
    public function actionLike()
    {
        if(Yii::$app->request->isAjax){
            if(Yii::$app->user->isGuest){
                $result = [
                    'status' => 'error',
                    'message' => '未登录用户无法操作',
                ];
                return json_encode($result);
            }
            $data = Yii::$app->request->post();
            $result = LikeForm::saveLike($data['aid'], $data['wid']);
            return json_encode($result);
        }
    }
    public function actionComment($p_id  = '', $a_id = '')
    {
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new CommentForm();
            if($model->load(Yii::$app->request->post())){
                $model->a_id = $a_id;
                $model->user_id = Yii::$app->user->identity->id;
                if($model->saveComment()){
                    return [
                        'aid' => $a_id,
                    ];
                }
            }
        }
    }
    public function actionGetcomment()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            // 创建一个 DB 查询来获得所有 status 为 1 的文章
            $query = Comment::find()->where(['p_id' => 0, 'a_id' => $data['aid']]);

            // 得到文章的总数（但是还没有从数据库取数据）
            $count = $query->count();

            // 使用总数来创建一个分页对象
            $pagination = new Pagination(['defaultPageSize' => 15, 'totalCount' => $count]);
            // 使用分页对象来填充 limit 子句并取得文章数据
            $comments = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy('id desc')
                ->all();
            $rcomments = CommentForm::findComments($comments, $data['aid']);
            return $this->renderPartial('getcomment', ['rcomments' => $rcomments, 'pagination' => $pagination, 'aid' => $data['aid']]);
        }
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->renderPartial('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }

        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionShow()
    {
        return $this->render('show');
    }
    public function actionCollecta()
    {
        return $this->render('collecta');
    }
    public function actionColl()
    {
        $articals = Collect::find()->asArray()->with('artical', 'articalinfor')->orderBy('id desc')->where(['uid' => Yii::$app->user->identity->id])->all();
        foreach ($articals as $key => $value) {
            $user = User::find()->asArray()->where(['id' => $value['artical']['user_id']])->one();
            $articals[$key]['user'] = $user;
        }
        return $this->renderPartial('coll', ['articals' => $articals]);
    }
    public function actionCancelcoll()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $coll = Collect::find()->where(['uid' => Yii::$app->user->identity->id, 'aid' => $data['aid']])->one();
            if($coll){
                $coll->delete();
            }
            return true;
        }
    }
    public function actionLikea()
    {
        return $this->render('likea');
    }
    public function actionLi()
    {
        $articals = Userbehavior::find()->with('artical', 'user', 'articalinfor')->orderBy('id desc')->where(['uid' => Yii::$app->user->identity->id, 'behavior' => '喜欢了文章'])->all();
        return $this->renderPartial('li', ['articals' => $articals]);
    }
    public function actionCancelli()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $li = Userbehavior::find()->where(['uid' => Yii::$app->user->identity->id, 'behavior' => '喜欢了文章', 'aid' => $data['aid']])->one();
            if($li){
                $li->delete();
            }
            return true;
        }
    }
    public function actionCollect()
    {
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $collect = Collect::find()->where(['uid' => Yii::$app->user->identity->id, 'aid' => $data['aid']])->one();
            if($collect){
                if($collect->delete()){
                    $result = [
                        'status' => 'nocollect',
                        'message' => '取消关注',
                    ];
                }
            }else{
                $model = new Collect;
                $model->uid = Yii::$app->user->identity->id;
                $model->aid = $data['aid'];
                $model->created_at = time();
                if($model->save()){
                    $result = [
                        'status' => 'collect',
                        'message' => '成功关注',
                    ];
                }
            }
            return json_encode($result);
        }
    }
    public function actionTest()
    {
        $uid = 5;
        $aid = 75;
        $sid = 8;
        $otherincludes = Includes::find()->where(['and', 'uid != '.$uid, ['and', 'aid = '.$aid, 'sid = '.$sid]])->one();
        print_r($otherincludes);
    }
    public function actionInforsum()
    {
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $subjects = Subjects::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        $sids = [];
        foreach ($subjects as $key => $value) {
            $sids[] = $value['id'];
        }
        $sum = $infor['comments'] + $infor['likes'] + $infor['follows'] + $infor['others'];
        $includes = Includes::find()->where(['id' => $sids, 'status' => 3])->all();
        $sum = $sum + count($includes);
        return $sum;
    }
}
