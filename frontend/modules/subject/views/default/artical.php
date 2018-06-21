<?php 
use yii\bootstrap\ActiveForm;
?>
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="artical-list">
    <table class="own-artical">
    <?php 
        if($subject){
            $plusartical = '收录';
        }else{
            $plusartical = '投稿';
        }
    ?>
        <?php 
            foreach ($articals as $key => $value) {
        ?>
        <tr>
            <td>
                <div class="artical-title">
                    <span><?php echo $value['title']; ?></span>
                    <div class="include-status">
                    <?php if($value['includes']){?>
                        <span class="included-tag">
                        <?php 
                            if($value['includes']['status'] == 1 || $value['includes']['status'] == 2){
                                echo '已加入';
                            }elseif($value['includes']['status'] == 3){
                                echo '待审核';
                            }elseif($value['includes']['status'] == 5){
                                echo '已撤回';
                            }elseif($value['includes']['status'] == 4){
                                echo '未通过';
                        } ?>
                        </span>
                    <?php } ?>
                    </div>
                    <input type="hidden" value="<?php echo $value['id']; ?>" name="artical-id">
                </div>
            </td>
            <td>
                <div class="btns-groups">
                <?php if($value['includes']){ ?>
                    <?php if($value['includes']['status'] == 1 || $value['includes']['status'] == 2){ ?>
                    <span class="remove-area include-btns">移除</span>
                    <?php }elseif($value['includes']['status'] == 3){ ?>
                    <span class="revoke-area include-btns">撤回</span>
                    <?php }elseif($value['includes']['status'] == 4){ ?>
                    <span class="include-areas include-btns">再次投稿</span>
                    <?php }else{ ?>
                    <span class="include-areas include-btns"><?php echo $plusartical ?></span>
                    <?php } ?>
                <?php }else{ ?>
                    <span class="include-areas include-btns"><?php echo $plusartical ?></span>
                <?php } ?>
                </div>
            </td>
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
        var aid = $('input[name="artical-id"]').eq(i).val();
        includes(i, aid);
    })
    function includes(i, aid){
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        var sid = '<?php echo $sid; ?>';
        var uid = '<?php echo Yii::$app->user->identity->id; ?>';
        formData.append('sid', sid);
        formData.append('aid', aid);
        formData.append('uid', uid);
        $.ajax({
            url: '<?php echo 'index.php?r=site/includeb' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
                if(data['message'] == 1 || data['message'] == 2){
                    $('.btns-groups').eq(i).html('<span class="remove-area include-btns">移除</span>');
                    $('.include-status').eq(i).html('<span class="included-tag">已加入</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var aid = $('input[name="artical-id"]').eq(i).val();
                        includes(i, aid);
                    })
                }
                if(data['message'] == 3){
                    $('.btns-groups').eq(i).html('<span class="revoke-area include-btns">撤回</span>');
                    $('.include-status').eq(i).html('<span class="included-tag">待审核</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var aid = $('input[name="artical-id"]').eq(i).val();
                        includes(i, aid);
                    })
                }
                if(data['message'] == 4){
                    alert('文章已经投稿过该专题');
                    $('.include-status').eq(i).html('<span class="included-tag">未通过</span>');
                    $('.include-btns').off('click');
                    $('.include-btns').one('click',function(){
                        var i = $('.include-btns').index(this);
                        var aid = $('input[name="artical-id"]').eq(i).val();
                        includes(i, aid);
                    })
                }
                if(data['message'] == 6){
                    alert('文章已经投稿过该专题');
                }
                if(data['message'] == 5){
                    alert('文章已经投稿过该专题');
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">投稿</span>');
                    $('.include-status').eq(i).html('<span class="included-tag">已撤回</span>');
                }
                if(data['message'] == 7){
                    $('.btns-groups').eq(i).html('<span class="include-areas include-btns">收录</span>');
                    $('.include-status').eq(i).html('<span class="included-tag"></span>');
                }
                $('.include-btns').off('click');
                $('.include-btns').one('click',function(){
                    var i = $('.include-btns').index(this);
                    var aid = $('input[name="artical-id"]').eq(i).val();
                    includes(i, aid);
                })
                if(data['message'] === 9){
                alert('此专题禁止投稿');
            }
        });
    }
</script>
