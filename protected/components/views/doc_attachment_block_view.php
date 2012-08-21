<div id="scancopies" class="block_wrapper">
    <p class="block-head"><?php echo $title ?></p>
    <div class="block-content">
        <div>
            <?$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dog_select',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Выберите родительский договор',
        'autoOpen'=>false,
        'width'=>'300',
        'buttons' => array
        (
             'Ok'=>'js:
   function(){
             var options = { 
                url: \''.Yii::app()->createUrl('/dogovor_archiv/scancopies/EditFileMetadata',array('id'=>'')).'\',
                type: \'post\',
                dataType: \'json\',
                error: function(res, status, exeption) {
                                      alert("error:"+res.responseText);},
                success:  function(data) {

                            var status=data[\'status\'];
                			
                			if(status=="ok"){
	                	 		grid.setGridParam({datatype:\'json\'});
	                			  $("#create_dialog").dialog(\'close\');
                			}
                			else if(status=="err"){
	                				alert("error:"+data[\'message\']);
	                			}
                			else{
	                            var response= jQuery.parseJSON (data);
	
	                            $.each(response, function(key, value) { 
	                              $("#"+key+"_em_").show();
	                              $("#"+key+"_em_").html(value[0]);
	                            });
	                        }
                    },

            }; 

                $(\'#asset-form\').ajaxSubmit(options); 

                       
                    }',
             'Cancel'=>'js:function(){$("#dog_select").dialog("close")}',
        ),
    ),
    
));
?>

<?                
//Заканчиваем виджет
$this->endWidget('zii.widgets.jui.CJuiDialog');

$url = Yii::app()->createUrl('dogovor_archiv/scancopies/EditFileMetadata/',array('parent_id'=>$parent_document));
echo CHtml::link(CHtml::image('/images/add.png').'Добавить файл', '#', array(
   'onclick'=>'$("#dog_select").dialog("open").load(\''.$url.'\'); return false;',
));
            ?>
        </div>
        <?
        $this->widget('zii.widgets.CListView',array('dataProvider'=>$attachments,'itemView'=>'_listitem','emptyText'=>'Ни одного прикрепленного файла не найдено'));
        ?>
    </div>
</div>
