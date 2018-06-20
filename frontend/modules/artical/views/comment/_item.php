<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:56
 * description:
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::register($this);
AppAsset::addCss($this,Yii::$app->request->baseUrl."/statics/css/main.css");
?>
<?= Html::jsFile('@web/statics/js/jquery-1.9.1.js')?>
    <div class="infos" id="comment">

        <div class="media-headings meta info opts">
            <?php
            if($value['parent'] == null){
            echo Html::a($value['user_id']['username'], ['/user/default/show', 'username' => $value['user_id']['username']], ['class' => 'author']), ' 评论于 ',
            Html::tag('addr', Yii::$app->formatter->asRelativeTime($value['created_at']), ['title' => Yii::$app->formatter->asDatetime($value['created_at'])]);
            }else{
            echo Html::a($value['user_id']['username'], ['/user/default/show', 'username' => $value['user_id']['username']], ['class' => 'author']), ' 回复 ',Html::a($value['parusername'], ['/user/default/show', 'username' => $value['parusername']], ['class' => 'author']),' 于 ',
            Html::tag('addr', Yii::$app->formatter->asRelativeTime($value['created_at']), ['title' => Yii::$app->formatter->asDatetime($value['created_at'])]);
            }
            ?>
        </div>

        <div class="panel-body markdown-reply content-body">
            <?= HtmlPurifier::process(Markdown::process($value['comment'], 'gfm')) ?>
        <span class="opts pull-left">
                <?php
                    echo Html::a('回复', 'javascript:void(0)',
                        [
                            'data-username' => $value['user_id']['username'],
                            'title' => '回复此楼',
                        ]
                    );
                ?>
                <div class="reply"><?php $form = ActiveForm::begin([
        'action' => [
            '/artical/comment/create',
            'parent' => $value['id'],
            'parusername' => $value['user_id']['username'],
            'id' => Yii::$app->request->getQueryParam('id')],
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>
   <?= $form->field($comment, 'comment')->textarea(['rows' => 2,'disabled' => Yii::$app->user->getIsGuest(),'value' => '']) ?>
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
               
<?php ActiveForm::end(); ?></div>
            </span>
            </div>
    </div>
