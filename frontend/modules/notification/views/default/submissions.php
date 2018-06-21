<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="submissions-container">
    <div class="submissions-toper">
        <div class="row">
            <div class="col-sm-5">
                <?php echo Html::a('<span class="back-requestlist"><i class="icon-reply"></i>&nbsp;返回投稿请求列表</span>', ['default/requests']) ?>
            </div>
            <div class="col-sm-3">
                <span class="subjectinfor-title"><?php echo $data['name']; ?></span>
            </div>
            <div class="col-sm-4" style="text-align: right;">
                <input type="checkbox" name="untreated-submissions">只看未处理投稿
            </div>
        </div>
    </div>
<?php 
    if($includes){
?>
    <?php 
        foreach ($includes as $key => $value) {
    ?>
    <div class="cont-acc">
        <div class="contacc-top">
            <div class="contacctop-left">
                <img src="<?php echo $value['user']['avatar']; ?>">
            </div>
            <div class="contacctop-right">
                <span class="contacctop-name"><?php echo $value['user']['nickname']; ?></span><span class="contacctop-behavior"><?php echo Yii::$app->formatter->asRelativeTime($value['created_at']); ?></span>
            </div>
        </div>
        <div class="contacc-middle">
            <div class="contbcc-area">
                <div class="contbccmiddle-left">
                    <div class="contbccmiddle-top">
                        <?php echo $value['artical']['title']; ?>
                    </div>
                    <div class="contbccmiddle-middle">
                        <?php echo $value['artical']['summary']; ?>
                    </div>
                </div>
                <div class="contbccmiddle-right">
                    <img src="<?php echo $value['artical']['img']; ?>">
                </div>
            </div>
            <div class="contbccmiddle-bottom">
                <span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['articalinfor']['like']; ?></span></span>
            </div>
        </div>
        <input type="hidden" value="<?php echo $value['sid'] ?>" name="include-id">
        <input type="hidden" value="<?php echo $value['artical']['id'] ?>" name="artical-id">
        <div class="deal-area">
            <?php
                if($value['status'] == 3){
            ?>
                <span class="operate-area"><span class="accept-btn">接受</span><span class="refuse-btn">拒绝</span></span><span class="submissions-time"><?php echo date('Y.m.d H:i', $value['created_at']); ?>&nbsp;投稿</span>
            <?php 
                }else if($value['status'] == 2){
            ?>
                <span class="operate-area"><span class="has-deal">已收入</span><span class="removei-btn">移除</span></span><span class="submissions-time"><?php echo date('Y.m.d H:i', $value['created_at']); ?>&nbsp;投稿</span>
            <?php 
                }else if($value['status'] == 4){
            ?>
                <span class="operate-area"><span class="has-deal">已拒绝</span></span><span class="submissions-time"><?php echo date('Y.m.d H:i', $value['created_at']); ?>&nbsp;投稿</span>
            <?php 
                }
            ?>
        </div>
    </div>
<?php 
        }
    }else{
?>
<div class="empty-submissions">
    <p class="empty-icon"><i class="icon-desktop icon-4x"></i></p>
    <span class="submissions-infor">投稿都处理完了~休息一下吧</span>
</div>
<?php
    }
?>
</div>
<script type="text/javascript">
    $('.back-requestlist')
    .click(function(){
        var url = $(this).parents('a').prop('href');
        $.ajax({
            url: url,
            type: 'get',
        }).always(function(result){
            $('.sub-content').html(result);
        });
        return false;
    })
    $('.accept-btn')
    .click(function(){
        var i = $('.deal-area').index($(this).parents('.deal-area'));
        var iid = $('input[name="include-id"]').eq(i).val();
        var aid = $('input[name="artical-id"]').eq(i).val();
        var resu = 2;
        submissionsRequest(i, iid, aid, resu);
    })
    $('.refuse-btn')
    .click(function(){
        var i = $('.deal-area').index($(this).parents('.deal-area'));
        var iid = $('input[name="include-id"]').eq(i).val();
        var aid = $('input[name="artical-id"]').eq(i).val();
        var resu = 4;
        submissionsRequest(i, iid, aid, resu);
    })
    $('.removei-btn')
    .click(function(){
        var i = $('.deal-area').index($(this).parents('.deal-area'));
        var iid = $('input[name="include-id"]').eq(i).val();
        var aid = $('input[name="artical-id"]').eq(i).val();
        var resu = 4;
        submissionsRequest(i, iid, aid, resu);
    })
    // 
    function submissionsRequest(i, iid, aid, resu){
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('iid', iid);
        formData.append('aid', aid);
        formData.append('resu', resu);
        $.ajax({
            url: '<?php echo 'index.php?r=notification/default/dealrequest' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
                if(data['message'] === "2"){
                    $('.operate-area').eq(i).html('<span class="has-deal">已收入</span><span class="removei-btn">移除</span>');
                    $('.removei-btn').off('click');
                    $('.removei-btn').on('click', function(){
                        var i = $('.deal-area').index($(this).parents('.deal-area'));
                        var iid = $('input[name="include-id"]').eq(i).val();
                        var aid = $('input[name="artical-id"]').eq(i).val();
                        var resu = 4;
                        submissionsRequest(i, iid, aid, resu);
                    })
                }
                if(data['message'] === 7){
                    $('.operate-area').eq(i).html('<span class="has-deal">已拒绝</span>');
                }
        });
    }
    $('input[name="untreated-submissions"]')
    .click(function(){
        var url = '<?php echo 'index.php?r=notification/default/untreated&id='.$data['id'].'&name='.$data['name'] ?>';
        $.ajax({
            url: url,
            type: 'get',
        }).always(function(result){
            $('.sub-content').html(result);
        });
    })
</script>
