<!--<script type="text/javascript" src="/demos/ordertest/assets/5bf29e8d/jquery.js"></script>
<script type="text/javascript" src="/demos/ordertest/assets/5bf29e8d/jquery.ba-bbq.js"></script>-->
<!--<script type="text/javascript">
$(document).ready(function(){
  $('#asset_id').live('change', function () {
    var asset_id = this.value;
//    alert(this.value);
    var my_id = "";
//    var val = $("#complect_line_id");
//    alert(val.value);
//    var t = document.getElementById("complect_line_id");
//    alert(t.value);
    $(this).next().each(function(){my_id = this.value });
//    alert(my_id);
//    $(this).css("background", "yellow");
//    alert(this.id);
    var q = '#'; //'?r=asset/UpdateGrid&id='+my_id;
//        
//    jQuery.ajax({'url'    :q,
//                 'data'   :{'asset_id':$(this).val()},
//                 'type'   :'post',
////                 'success':function(){alert('Поле обновлено');},
//                 'error'  :function(){alert('error');},
//                 'cache'  :false});
  })
});
</script> -->
<?php
//$cs = Yii::app()->clientScript;
// 
//$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
//$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
// 
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');

$this->breadcrumbs=array(
    'Товары по шаблонам',
);
//var_dump($complect_lines);
?>

<div class="form">
<?php
    echo CHtml::beginForm();
?>
<table class="items">
<thead>
<tr>
<th id="product-grid_c0">Тип</th><th id="product-grid_c1">Название</th><th id="product-grid_c1">Количество</th><th class="button-column" id="product-grid_c2">&nbsp;</th></tr>
</thead>
<tbody>    
    <?php
        foreach ($complect_lines as $c_l) {
            echo '<tr>';
            if ($c_l->asset_template_id>0) {
                echo "<td>Шаблон</td>";
                echo '<td>'.CHtml::dropDownList('asset_id_'.$c_l->id,$c_l->asset_id, Asset::findAssetsByTemplate($c_l->asset_template_id)).'</td>';
            } else {
                echo '<td>'.$c_l->asset->waretype->short_name.'</td>';
                echo '<td>'.$c_l->asset->name.'</td>';
            }   
            
            echo '<td>'.$c_l->amount.'</td>';
                
            echo '</tr>';
       }
    ?>
</tbody>
</table>
    
<div class="row buttons">
        <?php echo CHtml::submitButton('Продолжить',array("name"=>"my_button")); ?>
</div>    
<?php
    echo CHtml::endForm();
?>
</div><!-- form -->