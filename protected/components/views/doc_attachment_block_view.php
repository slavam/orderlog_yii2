<div id="scancopies" class="block_wrapper">
    <p class="block-head"><?php echo $title ?></p>
    <div class="block-content">
        <div>
            <?$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'file_select',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Выберите родительский договор',
        'autoOpen'=>false,
        'width'=>'300',
        'buttons' => array
        (
             'Ok'=>'js:function()
                 {
             var options = { 
                url: \''.Yii::app()->createUrl('/dogovor_archiv/scancopies/EditFile',array('id'=>'')).'\',
                type: \'post\',
                dataType: \'json\',
                error: function(res, status, exeption) {
                                      alert("error:"+res.responseText);
                                      },
                success:  function(data) {

                            var status=data[\'status\'];
                			
                			if(status=="ok"){
	                	 		//alert("ok:"+data[\'message\']);
                                                $(location).attr(\'href\',"");
	                			  $("#file_select").dialog(\'close\');
                			}
                			else if(status=="err"){
	                				alert("error:"+data[\'message\']);
	                			}
                			else
                                            {
                                                var response= jQuery.parseJSON (data);

                                                $.each(response, function(key, value) { 
                                                $("#"+key+"_em_").show();
                                                $("#"+key+"_em_").append(value[0]);
                                            }
                                        );
	                        }
                    },

            }; 
                //alert(\'ok\');
                $(\'#fileedit_form\').ajaxSubmit(options); 

                       
                    }',
             'Cancel'=>'js:function(){$("#file_select").dialog("close")}',
        ),
    ),
    
));
?>

<?                
//Заканчиваем виджет
$this->endWidget('zii.widgets.jui.CJuiDialog');

$url = Yii::app()->createUrl('dogovor_archiv/scancopies/EditFileMetadata/',array('parent_id'=>$parent_document));
echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/add.png').'Добавить файл', '#', array(
   'onclick'=>'$("#file_select").dialog("open").load(\''.$url.'\'); return false;',
));
            ?>
        </div>
        <?
        $this->widget('zii.widgets.CListView',array('dataProvider'=>$attachments,'itemView'=>'_listitem','emptyText'=>'Ни одного прикрепленного файла не найдено'));
        ?>
    </div>
</div>
