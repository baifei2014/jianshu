<?php

namespace frontend\modules\artical\controllers;

use common\models\UserInfo;
use common\services\NotificationService;
use common\services\PostService;
use common\services\TopicService;
use Yii;
use yii\web\Controller;
use common\models\Comment;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for PostComment model.
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 登录用户POST操作
                    ['allow' => true, 'actions' => ['delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能操作
                    ['allow' => true, 'actions' => ['create', 'update'], 'roles' => ['@']],
                ]
            ],
        ]);
    }

    /**
     * 创建评论
     * @param $id
     * @return Comment|\yii\web\Response
     */
    public function actionCreate($id,$parent='',$parusername='')
    {
        $model = new Comment();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->parent = $parent;
            $model->parusername = $parusername;
            $model->artical_id = $id;
            $model->created_at = time();
            $model->ip = Yii::$app->getRequest()->getUserIP();
            if ($model->save()) {
                return $this->redirect(['/artical/default/view', 'id' => $id]);
            }
        }
        return $model;
    }

    /**
     * 修改评论
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = PostComment::findComment($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/topic/default/view', 'id' => $model->post_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 伪删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = PostComment::findComment($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        // 事物 暂时数据库类型不支持 无效
        $transaction = \Yii::$app->db->beginTransaction();
        $updateComment = $model->updateCounters(['status' => -1]);
        $updateNotify = Notification::updateAll(['status' => 0], ['comment_id' => $model->id]);
        $updateTopic = Topic::updateAllCounters(['comment_count' => -1], ['id' => $model->post_id]);
        if ($updateNotify && $updateComment && $updateTopic) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }
        return $this->redirect(['/topic/default/view', 'id' => $model->post_id]);
    }

}
