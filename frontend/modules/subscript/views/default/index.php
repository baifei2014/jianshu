<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '关注 - 简书';
?>
<div class="user-index">
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
    <div class="col-nw-3">
        <span class="all-focus">全部关注</span>
        <div class="allfocus-area">
            <ul>
                <li class="focus-list"><a href="/subscript/default/subcircle" class="actived"><span class="circle-avatar"><i class="icon-globe icon-large"></i></span>简友圈</a></li>
                <?php 
                    foreach ($focus as $key => $value) {
                ?>
                <li class="focus-list">
                <?php 
                    if($value['type'] == 'auther'){
                        echo Html::a('<img src="'.'/'.$value['result']['avatar'].'" class="focus-avatar">'.$value['result']['nickname'],['default/user', 'id' => $value['result']['id']]);
                    }else if($value['type'] == 'subject'){
                        echo Html::a('<img src="'.'/'.$value['result']['labelimg'].'" class="focus-avatar">'.$value['result']['name'], ['default/subject', 'id' => $value['result']['id']]);
                    }else if($value['type'] == 'set'){
                        echo Html::a('<span class="set-avatar"><i class="icon-book icon-large"></i></span>'.$value['result']['name'], ['default/set', 'id' => $value['result']['id']]);
                    }
                ?>
                </li>
                <?php
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-nw-9">
        <div class="sub-content">
        </div>
    </div>
</div>
<script type="text/javascript" src="/statics/js/jquery.js"></script>
<script type="text/javascript">
    $.ajax({
        url: '<?php echo '/subscript/default/subcircle'; ?>',
        type: 'get',
    }).always(function(result){
        $('.sub-content').html(result);
    });
    $('.allfocus-area a')
    .click(function(){
        var i = $('.allfocus-area a').index(this);
        var url = $('.allfocus-area a').eq(i).prop('href');
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            $('.sub-content').html(result);
        })
        $('.allfocus-area a').removeClass('actived');
        $('.allfocus-area a').eq(i).addClass('actived');
        return false;
    })
</script>
