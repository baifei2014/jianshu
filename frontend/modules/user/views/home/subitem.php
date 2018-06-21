<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($focus as $key => $value) {
?>
<div class="focus-user">
    <div class="row">
    <?php 
        if($value['type'] === 'subject'){
    ?>
        <div class="col-sm-8">
            <div class="focususer-infor">
                <div class="focususerinfor-left">
                    <?php echo Html::a('<img src="'.'/'.$value['subject']['labelimg'].'" class="focussubject-img-middle">', Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id' => $value['subject']['code']])) ?>
                </div>
                <div class="focususerinfor-right">
                    <span><?php echo Html::a($value['subject']['name'], Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id' => $value['subject']['code']]), ['class' => 'userfocus-name']); ?></span>
                    <p class="befocus-userinfor"><span><?php echo $value['user']['nickname']; ?> 编，</span><span>关注 <?php echo $value['result']['focus']; ?>，</span><span>文章 <?php echo $value['result']['artical']; ?></span></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="opfocus-area">
                <div class="tabtimeline-area">
                <?php 
                    if($value['isfocus']){
                ?>
                    <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                    <?php 
                        }else{
                    ?>
                    <span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>
                <?php 
                    }
                ?>
                </div>
                <input type="hidden" value="<?php echo $value['set']['id']; ?>" name="befocus_id">
                <input type="hidden" value="<?php echo $value['type']; ?>" name="befocus_type">
            </div>
        </div>
    <?php 
        }else if($value['type'] === 'set'){
    ?>
        <div class="col-sm-8">
            <div class="focususer-infor">
                <div class="focususerinfor-left">
                    <?php echo Html::a('<div class="focusset-img-middle"><i class="icon-book icon-2x"></i></div>', Yii::$app->urlManager->createAbsoluteUrl(['nb/default/index', 'id' => $value['set']['id']])); ?>
                </div>
                <div class="focususerinfor-right">
                    <span><?php echo Html::a($value['set']['name'], Yii::$app->urlManager->createAbsoluteUrl(['nb/default/index', 'id' => $value['set']['id']]), ['class' => 'userfocus-name']); ?></span>
                    <p class="befocus-userinfor"><span><?php echo $value['user']['nickname']; ?> 编，</span><span>关注 <?php echo $value['result']['focus']; ?>，</span><span>文章 <?php echo $value['result']['artical']; ?></span></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="opfocus-area">
                <div class="tabtimeline-area">
                <?php 
                    if($value['isfocus']){
                ?>
                    <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                    <?php 
                        }else{
                    ?>
                    <span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>
                <?php 
                    }
                ?>
                </div>
                <input type="hidden" value="<?php echo $value['set']['id']; ?>" name="befocus_id">
                <input type="hidden" value="<?php echo $value['type']; ?>" name="befocus_type">
            </div>
        </div>
    <?php
        }
    ?>
    </div>
</div>
<?php
    }
?>
<script type="text/javascript">
    $('.tabtimeline-area')
    .click(function(){
        var i = $('.opfocus-area .tabtimeline-area').index(this);
        var id = $('input[name="befocus_id"]').eq(i).val();
        var type = $('input[name="befocus_type"]').eq(i).val();
        diffClick(id, i, type);
    })
    function diffClick(id, i, type)
    {
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('uid', id);
        formData.append('type', type);
        $.ajax({
            url: '<?php echo '/user/home/ofocus' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'cancel'){
                $('.tabtimeline-area').eq(i).html('');
                $('.tabtimeline-area').eq(i).html('<span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>');
                $('.tabtimeline-area').off('click');
                $('.tabtimeline-area').on('click', function(){
                    var i = $('.opfocus-area .tabtimeline-area').index(this);
                    var id = $('input[name="befocus_id"]').eq(i).val();
                    var type = $('input[name="befocus_type"]').eq(i).val();
                    diffClick(id, i, type);
                })
            }else if(data['status'] === 'success'){
                $('.tabtimeline-area').eq(i).html('');
                $('.tabtimeline-area').eq(i).html('<span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>');
                $('.tabtimeline-area').off('click');
                $('.tabtimeline-area').on('click', function(){
                    var i = $('.opfocus-area .tabtimeline-area').index(this);
                    var id = $('input[name="befocus_id"]').eq(i).val();
                    var type = $('input[name="befocus_type"]').eq(i).val();
                    diffClick(id, i, type);
                })
                $('.tabtimeline-area .focused-btn').on('mouseover',function(){
                    var i = $('.tabtimeline-area .focused-btn').index(this);
                    $('.tabtimeline-area .focused-btn').eq(i).html('');
                    $('.tabtimeline-area .focused-btn').eq(i).html('<i class="icon-remove"></i>&nbsp;取消关注');
                })
                $('.tabtimeline-area .focused-btn').on('mouseout',function(){
                    var i = $('.tabtimeline-area .focused-btn').index(this);
                    $('.tabtimeline-area .focused-btn').eq(i).html('');
                    $('.tabtimeline-area .focused-btn').eq(i).html('<i class="icon-ok"></i>&nbsp;已关注');
                })
            }
        });
    }
    $('.tabtimeline-area .focused-btn')
    .mouseenter(function(){
        var i = $('.tabtimeline-area .focused-btn').index(this);
        $('.tabtimeline-area .focused-btn').eq(i).html('');
        $('.tabtimeline-area .focused-btn').eq(i).html('<i class="icon-remove"></i>&nbsp;取消关注');
    })
    $('.tabtimeline-area .focused-btn')
    .mouseleave(function(){
        var i = $('.tabtimeline-area .focused-btn').index(this);
        $('.tabtimeline-area .focused-btn').eq(i).html('');
        $('.tabtimeline-area .focused-btn').eq(i).html('<i class="icon-ok"></i>&nbsp;已关注');
    })
</script>
