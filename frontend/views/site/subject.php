<?php 
use yii\bootstrap\ActiveForm;
?>
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="artical-list">
    <table class="own-artical">
        <?php 
            foreach ($subjects as $key => $value) {
        ?>
        <tr>
            <td>
                <div class="artical-title">
                    <div class="row">
                        <div class="col-bm-2">
                            <img src="<?php echo '/'.$value['labelimg'] ?>" class="subject-img-small">
                        </div>
                        <div class="col-bm-10">
                            <dd class="subjectplus-name"><?php echo $value['name']; ?></dd>
                            <dd class="subjectplus-infor"><?php echo $value['user']['nickname'].' 编'; ?>
                                <span class="articalplus-status"><?php
                                    if($value['include']['status'] == 2 || $value['include']['status'] == 1){
                                        echo '已加入';
                                    }
                                ?></span>
                            </dd>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $value['id']; ?>" name="ownsubject-id">
            </td>
            <td><div class="btns-groups"><?php if($value['include']['status'] == 2 || $value['include']['status'] == 1){ ?><span class="remove-area include-btns">移除</span><?php }else{ ?><span class="include-areas include-btns">收入</span><?php } ?></div></td>
        </tr>
        <?php 
            }
        ?>
    </table>
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
            url: '<?php echo '/site/includea' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
                if(data['message'] == 1 || data['message'] == 2){
                    $('.btns-groups').eq(i).html('<span class="remove-area include-btns">移除</span>');
                    $('.articalplus-status').eq(i).text('已加入');
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
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">收入</span>');
                    $('.articalplus-status').eq(i).text('');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var sid = $('input[name="ownsubject-id"]').eq(i).val();
                        includes(i, sid);
                    })
                }
                if(data['message'] == 5){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">投稿</span>');
                }
                if(data['message'] == 7){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">收入</span>');
                    $('.articalplus-status').eq(i).text('');
                }
                $('.include-btns').off('click');
                $('.include-btns').one('click',function(){
                    var i = $('.include-btns').index(this);
                    var sid = $('input[name="ownsubject-id"]').eq(i).val();
                    includes(i, sid);
                })
                if(data['message'] === 9){
                alert('此专题禁止投稿');
            }
        });
    }
</script>
