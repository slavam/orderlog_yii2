<!--<script type="text/javascript">
$(document).ready(function(){
$('#Asset_cost').live('change', function () {
    var did = "";
     did = document.getElementById('Asset_id').value;
     alert(did);
            $.ajax({
                   url: '?r=asset/UpdateGrid',
                   data:{
                       'cost' : $(this).value(),
                       'id' : did
                   },                   
                   error : function(){
                         alert('Error');
                   },
                   success: function(){
                         alert('Поле обновлено');
                   }
            });    
    }); 
});    
</script>-->
<!--<script type="text/javascript">
$(document).ready(function(){
$('#Asset_cost').live('change', function () {
//    var did = $(this).attr("id");
//  var did = "";
//     did = $(this).getElementById('Asset_id').value;
var my_id = "";
  $(this).next().each(function(){my_id = this.value });
//  alert(my_id);
//var did = $('#id_20').get(0).value;
//    alert(did);
  var q ='?r=asset/UpdateGrid&id='+my_id;
//  alert(q);
//  q = "'url'=>'?r=asset/UpdateGrid', 'data' => 'id='"+did+", 'type'=>'post', 'success'=>'function(msg){alert('Поле обновлено');}', 'error'=>'function(){alert('error');}'";
    <?php //echo CHtml::ajax(array(
        //'url'=> "q",
       // 'data' => '{cost : $(this).value()}',
        //'data'=>'data',
       // 'type'=>'post',
       // 'success'=>"function(msg){alert('Поле обновлено');}",
       // 'error'=>"function(){alert('error');}"
   // ))?>
})});
</script> -->

<script type="text/javascript">
$(document).ready(function(){
  $('#Asset_cost').live('change', function () {
    var my_id = "";
    $(this).next().each(function(){my_id = this.value });
    var q ='?r=asset/UpdateGrid&id='+my_id;
    jQuery.ajax({'url'    :q,
                 'data'   :{'Asset[cost]':$(this).val()},
                 'type'   :'post',
                 'success':function(){alert('Поле обновлено');},
                 'error'  :function(){alert('error');},
                 'cache'  :false});
  })
});
</script> 
<?php
$this->breadcrumbs=array(
    'Товары',
);

$this->menu=array(
    array('label'=>'Create Asset', 'url'=>array('create')),
    array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>Товары</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
                array(
                'name'=>'Тип',
                'value'=>'$data->waretype->short_name'),
                array(
                'name'=>'Группа',
                'value'=>'$data->assetgroup->name'),
                array(
                'name'=>'Название',
                'value'=>' $data->name'),
                array(
                'name'=>'Тип цены',
                'value'=>' $data->priceType->name'),
                array(
                'name'=>'Цена',
                'type'=>'raw',
                'value'=>'$data->get_price()'),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("asset/show",array("id"=>$data->id))'),
        ),
)); ?>

<?php echo CHtml::link('Добавить товар', Yii::app()->createUrl("asset/create"))?>
<br>
<?php echo CHtml::link('Добавить товар по шаблону', Yii::app()->createUrl("assetTemplate/getTemplate"))?>