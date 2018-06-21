<?php 
use yii\bootstrap\ActiveForm;
?>
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="artical-tlist">
    <div class="ownsubject-toper">
        我管理的专题
    </div>
    <div class="ownsubject-content">
        <div class="ownsubject-table">
        <?php 
            foreach ($ownsubjects as $key => $value) {
        ?>
            <div class="subject-odd">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?php echo '/'.$value['labelimg'] ?>" class="subject-img-small">
                        </div>
                        <div class="col-sm-9" style="padding-top: 2px;">
                            <dd class="subjectplus-name"><?php echo $value['name']; ?></dd>
                            <dd class="subjectplus-infor">0篇文章 · 0人关注</dd>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" style="text-align: right;">
                    <div class="btns-groups btn-owns"><?php if($value['include']['status'] == 2 || $value['include']['status'] == 1){ ?><span class="remove-area include-btns">移除</span><?php }else{ ?><span class="include-areas include-btns">收入</span><?php } ?></div>
                </div>
            </div>
            <input type="hidden" value="<?php echo $value['id']; ?>" name="ownsubject-id">
        <?php
            }
        ?>
        </div>
    </div>
    <div class="ownsubject-btoper">
        推荐专题
    </div>
    <div class="ownsubject-content">
        <div class="ownsubject-table">
        <?php 
            foreach ($othersubjects as $key => $value) {
        ?>
            <div class="subject-odd">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?php echo '/'.$value['labelimg'] ?>" class="subject-img-small">
                        </div>
                        <div class="col-sm-9" style="padding-top: 2px;">
                            <dd class="subjectplus-name"><?php echo $value['name']; ?></dd>
                            <dd class="subjectplus-infor">0篇文章 · 0人关注</dd>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3" style="text-align: right;">
                    <div class="btns-groups btn-owns">
                    <?php 
                        if($value['include']['status'] == 2 || $value['include']['status'] == 1){ 
                    ?>
                        <span class="remove-area include-btns">移除</span>
                    <?php 
                        }else if($value['include']['status'] == 3){ 
                    ?>
                        <span class="revoke-area include-btns">撤回</span>
                    <?php 
                        }else{ 
                    ?>
                        <span class="include-areas include-btns">投稿</span>
                    <?php } ?>
                </div>
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
        formData.append('sid', sid);
        formData.append('aid', aid);
        $.ajax({
            url: '<?php echo '/site/includeb' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
                if(data['message'] == 1 || data['message'] == 2){
                    $('.btns-groups').eq(i).html('<span class="remove-area include-btns">移除</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }
                if(data['message'] == 3){
                    $('.btns-groups').eq(i).html('<span class="revoke-area include-btns">撤回</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }
                if(data['message'] == 4){
                    alert('文章已经投稿过该专题');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }
                if(data['message'] == 6){
                    alert('文章已经投稿过该专题');
                }
                if(data['message'] == 5){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">投稿</span>');
                }
                if(data['message'] == 7){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">收入</span>');
                }
                $('.include-btns').off('click');
                $('.include-btns').one('click',function(){
                    var i = $('.include-btns').index(this);
                    var sid = $('input[name="ownsubject-id"]').eq(i).val();
                    includes(i, sid);
                })
            
                if(data['message'] == 9){
                    alert('此专题禁止投稿');
                }
        });
    }
</script>
