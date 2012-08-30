<div class="form">
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dog_select',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Выберите родительский договор',
        'autoOpen'=>false,
        'width'=>'1000',
        'buttons' => array
        (
             'Ok'=>'js:function(){
              var gsr = jQuery("#jqgrid").jqGrid(\'getGridParam\',\'selrow\'); 
              
              if (gsr){
                    var row = jQuery("#jqgrid").jqGrid("getRowData",gsr);
                    $("#Document_parent_doc_id").val(gsr);
                    $("#document_identify").append("№"+row.dog_number+", Контрагент: "+row.provider+", Вид: "+row.dog_kind);
                    $("#dog_select").dialog("close")
                    }
                    else {alert(\'Выберите документ\')}
                    }',
             'Cancel'=>'js:function(){$("#dog_select").dialog("close")}',
        ),
    ),
    
));

$this->endWidget('zii.widgets.jui.CJuiDialog');

// the link that may open the dialog
?>
    
<?if ($notice = Yii::app()->user->getFlash('notice')):?>
  <div class="notice">
      <? echo $notice;?>
  </div>  
    <?endif;?>
<?
echo CHtml::link(CHtml::image('/images/add.png').'Добавить главный договор', '#', array(
   'onclick'=>"$(\"#dog_select\").dialog(\"open\").load('".Yii::app()->createUrl('/dogovor_archiv/documents/view')."'); return false;",
));
echo $form->renderBegin();
//echo CHtml::hiddenField('Document[parent_id]');
echo $form['parent_doc_id'];
if ($model->parent_doc_id)
{
    $pdid="№".$parent_model->attrs['dog_number'].", Контрагент: ".$parent_model->attrs['provider'].", Вид: ".Reference::model()->getReferenceItemById($parent_model->attrs['dog_kind']);
}
echo CHtml::tag('p',array('id'=>'document_identify'),'Главный договор: '.$pdid);
?> 
    <div class="block_wrapper">
    <table width="900">
          <thead>
            <tr>
                <th>Классификация документа</th>
                <th>Нумерация и сроки</th>
                <th>Финансовые признаки</th>
<!--                <th>Общие сведения</th> -->
            </tr>
          </thead>      
    <tr>
        <td>
             <table>

                <tr>
                    <td>
                        <table>
<!--                            <tr>
                                <td colspan="2"><b><?//echo $model->templ_description;?></b></td>
                            </tr>-->
                            <tr>
                                <td width="154"><b><?echo $model->templ_description; ?></b></td>
                                <td><?echo $form['status'];?></td>
                            </tr>
                        </table>

                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                               <td> <?echo $form['dog_kind'];?></td>
                                <td><?echo $form['author_login'];?></td>
                            </tr>                         
                        </table>
                        </td>
                </tr>
                <tr>
                    <td><?echo $form['dog_type'];?></td>
                </tr>
            </table>
       </td>
       <td>
           <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><? echo $form['inside_number'];?></td>
                            <td><?echo $form['dog_fact_date'];?></td>
                        </tr>
                        <tr>
                            <td><? echo $form['dog_number'];?></td>
                            <td><?echo  $form['dog_date'];?></td>
                        </tr>
                    
                    </table>
                    
                </td>
            </tr>
            <tr>
               <td><?echo $form['dog_period'];?></td>
            </tr>
           </table> 
       </td>
       <td>
                <table>
                        
                       
                        <tr>
                            <td><?echo $form['tarif_type'];?></td>
                        </tr>
                        <tr>
                            <td><?echo $form['tarif'];?></td>
                        </tr>
                         <tr>
                            <td><?echo $form['reward_percent'];?></td>
                        </tr>
                </table> 
                            <?echo $form['reestr'];?>
       </td>
        
</table>
</div>    
    
<div class="block_wrapper">    
    <table width="900">
        <thead>
            <tr>
                <th>Сведения контрагента</th>
            </tr>
        </thead>
        
        <tr>
            <td>
            <table>
                <tr>
                    <td><?echo $form['provider'];?></td>
                    <td><?echo $form['okpo'];?></td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td><?echo $form['provider_contact'];?></td>
        </tr>
         
        <tr>
            <td>
                <table>
                    <tr>
                        <td><?echo $form['recipient'];?></td>
                        <td><?echo $form['pay_system'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><?echo $form['subject'];?></td>
        </tr>
        
        <tr>
            <td><?echo $form['note'];?></td>
        </tr>
        <tr>
            <td><?echo $form['delegation'];?></td>
        </tr>
    </table>
</div> 
<?php 
foreach($form->getButtons() as $element)
    echo $element->render();
    
echo $form->renderEnd(); //endform
echo $scancopies;
?>
</div>