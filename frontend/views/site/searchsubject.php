<?php 
use yii\bootstrap\ActiveForm;
?>
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="artical-tlist">
    <div class="ownsubject-content">
        <div class="ownsubject-table">
        <?php 
            foreach ($subjects as $key => $value) {
        ?>
            <div class="subject-odd">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?php echo $value['labelimg'] ?>" class="subject-img-small">
                        </div>
                        <div class="col-sm-9" style="padding-top: 2px;">
                            <dd class="subjectplus-name"><?php echo $value['name']; ?></dd>
                            <dd class="subjectplus-infor">0篇文章 · 0人关注</dd>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" style="text-align: right;">
                    <div class="btns-groups btn-owns"><?php if($value['include']['status'] == 2 || $value['include']['status'] == 1){ ?><span class="remove-area include-btns">移除</span><?php }else if($value['include']['status'] == 3){ ?><span class="revoke-area include-btns">撤回</span><?php }else{ ?><span class="include-areas include-btns">投稿</span><?php } ?></div>
                </div>
            </div>
            <input type="hidden" value="<?php echo $value['id']; ?>" name="ownsubject-id">
        <?php
            }
        ?>
        </div>
    </div>
    
</div>
<script type="text/javascript">
    $('.include-btns')
    .click(function(){
        var i = $('.include-btns').index(this);
        var sid = $('input[name="ownsubject-id"]').eq(i).val();
        includes(i, sid);
    })
    function includes(i, sid){
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        var aid = '<?php echo $aid; ?>';
        var uid = '<?php echo Yii::$app->user->identity->id; ?>';
        formData.append('sid', sid);
        formData.append('aid', aid);
        formData.append('uid', uid);
        $.ajax({
            url: '<?php echo 'index.php?r=site/include' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'success'){
                if(data['code'] == 1){
                    $('.btns-groups').eq(i).html('<span class="remove-area include-btns">移除</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }else if(data['code'] == 3){
                    $('.btns-groups').eq(i).html('<span class="revoke-area include-btns">撤回</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }else if(data['code'] == 5){
                    alert('文章已经投稿过该专题');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }
            }else if(data['status'] == 'remove'){
                alert(data['code']);
                if(data['code'] == 8){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">投稿</span>');
                }else if(data['code'] == 9){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">收入</span>');
                }
                $('.include-btns').off('click');
                $('.include-btns').one('click',function(){
                    var i = $('.include-btns').index(this);
                    var sid = $('input[name="ownsubject-id"]').eq(i).val();
                    includes(i, sid);
                })
            }else if(data['status'] === 'ban'){
                alert('此专题禁止投稿');
            }
        });
    }
</script>
