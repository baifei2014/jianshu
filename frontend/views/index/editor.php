<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'nickname'); ?>
<a href="javascript:;" class="btn">提交</a>
<?php echo Html::submitButton('提交', ['class' => 'btn']); ?>

<?php ActiveForm::end(); ?>
<?php //echo $ko; ?>
<script type="text/javascript">
    $('.btn')
    .click(function(){
        alert('哈哈哈')
        var token = $("input[name='_csrf-frontend']").val();
        var _csrf = '_csrf-frontend';
        $.ajax({
           //url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=index/mail' ?>',
           url: '<?php echo 'index.php?r=index/mail' ?>'+'&id=1',
           type: 'get',
           success: function (data) {
              alert(data);
           },
           error: function (result){
                // for(var i in result)
                //     alert(result[i]);
           }
      });
        return false;
    })
</script>
