<?php 
use yii\bootstrap\ActiveForm;
?>
<div class="artical-collect">
    <div class="collect-top">
        <span class="colecttitle-area"><i class="icon-bookmark icon-large"></i><span class="collect-title">喜欢的文章</span></span>
    </div>
    <div class="collect-middle">
    </div>
</div>
<script type="text/javascript" src="/statics/js/jquery.js"></script>
<script type="text/javascript">
    $.ajax({
        url: '<?php echo '/site/li'; ?>',
        type: 'get',
    }).always(function(result){
        $('.collect-middle').html(result);
    });
</script>
