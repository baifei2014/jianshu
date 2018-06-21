<div class="col-lg-12">
    <a href="javascript:;" class="btn">你好啊</a>
</div>
<script type="text/javascript">
$.ajax({
    url: '<?php echo Yii::$app->request->baseUrl. '/index/abc' ?>',
    type: 'post',
    success: function (data) {
     alert(data);
    }
});
</script>
