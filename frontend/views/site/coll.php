<?php 
use yii\bootstrap\ActiveForm;
?>
<div class="coll-index">
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<?php 
    foreach ($articals as $key => $value) {
?>
    <div class="collect-list">
        <div class="contacc-top">
            <div class="contacctop-left">
                <img src="<?php echo $value['user']['avatar']; ?>">
            </div>
            <div class="contacctop-right">
                <span class="contacctop-name"><?php echo $value['user']['nickname']; ?></span><span class="contacctop-behavior"><?php echo date('m月d H:i', $value['created_at']); ?></span>
            </div>
        </div>
        <div class="contacc-middle">
            <div class="contbcc-area">
                <div class="contbccmiddle-left">
                    <div class="contbccmiddle-top">
                        <?php echo $value['artical']['title']; ?>
                        <input type="hidden" value="<?php echo $value['artical']['id']; ?>" name="articalid">
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
                <span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['articalinfor']['like']; ?></span><span class="cancel-collect cancel-btn">取消收藏</span></span>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>
<script type="text/javascript">
    $('.collect-list')
    .mouseenter(function(){
        var i = $('.collect-list').index(this);
        $('.cancel-collect').eq(i).css('visibility', 'visible');
    })
    $('.collect-list')
    .mouseleave(function(){
        var i = $('.collect-list').index(this);
        $('.cancel-collect').eq(i).css('visibility', 'hidden');
    })
    $('.cancel-btn')
    .click(function(){
        var i = $('.cancel-btn').index(this);
        var aid = $('input[name="articalid"]').eq(i).val();
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('aid', aid);
        $.ajax({
            url: '<?php echo 'index.php?r=site/cancelcoll' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            $.ajax({
                url: '<?php echo 'index.php?r=site/coll'; ?>',
                type: 'get',
            }).always(function(result){
                $('.collect-middle').html(result);
            });
        });
    })
</script>
