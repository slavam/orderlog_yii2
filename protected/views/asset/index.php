<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jqModal.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jqDnR.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');

?>
<style type="text/css">
      th.ui-th-column div {
            /* see http://stackoverflow.com/a/7256972/315935 for details */
            word-wrap: break-word;      /* IE 5.5+ and CSS3 */
            white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
            white-space: -pre-wrap;     /* Opera 4-6 */
            white-space: -o-pre-wrap;   /* Opera 7 */
            white-space: pre-wrap;      /* CSS3 */
            overflow: hidden;
            height: auto !important;
            vertical-align: middle;
        }
        .ui-jqgrid tr.jqgrow td {
            white-space: normal !important;
            height: auto;
            vertical-align: middle;
            padding-top: 2px;
            padding-bottom: 2px;
        }
        .ui-jqgrid .ui-jqgrid-htable th.ui-th-column {
            padding-top: 2px;
            padding-bottom: 2px;
        }
        .ui-jqgrid .frozen-bdiv, .ui-jqgrid .frozen-div {
            overflow: hidden;
        }
</style>


<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>

<div id="create_dialog" style="display:none;">
<table id="create_dialog_table"></table>
</div>

<div id="create_del_dialog" style="display:none">
</div>
<div id="error_del_dialog" style="display:none; border: 4px solid red; font-weight: bold; color:red">Нельзя удалить объект заявки (товар):, так как он используется в строках заявки!
</div>


<div id="firstLoad"></div>

<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var lastSel;
    var id_;
    var grid=$("#list");
    var pager_selector = "#pager";
    var firstLoad=true;
    grid.jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '1160',
        height : '600',
        mtype : 'GET',
//        colNames : [ 'ID','Тип Записи','Тип','Группа','Подгруппа','Наименование','Код','Прайс','Комментарий','Статья Затрат','Код Статьи' ],
        colNames : [ 'ID','Тип','Группа','Подгруппа','Наименование','Код','Прайс','Комментарий','Статья Затрат','Код Статьи', 'Совпадение шаблонов'],
        colModel : [
        { name : 'id', index : 'id', width : 20, hidden:true },
//        { name : 'rtype', index : 'supergroup', width : 20, sortable:true, hidden:true },  		/*Тип записи 		(Иконка) – Объект заявки\ Набор объектов заявки\ Комплект объектов заявки.*/
        { name : 'type', index : 'type', width : 20, sortable:true },				/*Тип		  		(Данные) – Тип объекта: МЦ или Усл. */
        { name : 'supergroup', index : 'supergroup', width : 130, sortable:true }, /*Группа			(Список) – Функциональные группы\ подгруппы. Для каждого направления определяются индивидуально. */
        { name : 'group', index : 'group', width : 130, sortable:true },           /* --//-- */
        { name : 'name', index : 'name', width : 250, sortable:true },             /*Наименование  		(Данные) - Наименование объекта заявки. */
        { name : 'part_number', index : 'part_number', width : 50, sortable:true },             /*Код  				(Данные) - Уникальный номер объекта. */
        { name : 'cost', index : 'cost', width : 50, sortable:true, editable:true }, 			/*Прайс-лист			(Редактируемое поле) - Редактируемое поле, для указания текущей актуальной цены.*/
        { name : 'comment', index : 'comment', width : 100, sortable:true, editable:true },		/*Примечание			(Редактируемое поле) - Редактируемое поле, для пометок и примечаний.*/
        { name : 'article', index : 'article', width : 150, sortable:true }, 		/*Статья затрат		(Список) - Статья затрат для отнесения в бюджет.*/
        { name : 'article_code', index : 'article_code', width : 50, sortable:true }, 		/*Kод статьи			(Данные) - Уникальный код статьи бюджета.*/
        { name : 'cell_red', index : '$cell_red', width : 5, sortable:true, hidden:true  }, 		/*Красить или нет			(Данные) - Уникальный код статьи бюджета.*/
        ],
        pager : '#pager',
        rowNum : 1000000,
        sortname : 'name',
        sortorder : 'asc',
        caption : 'Товары',
        toppager:true,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,         // disable pager text like 'Page 0 of 10'
        viewrecords: false,   // disable current view record text like 'View 1-10 of 100'    
        loadonce: true,       // to enable sorting on client side
    
afterInsertRow: function(row_id, row_data){
    if (row_data.cell_red) {
        $('#list').jqGrid('setCell',row_id,'article_code','',{'color':'red'});
    }
},

gridComplete: function () {
    grid.setGridParam({datatype:'local'});
    $("#firstLoad").data('firstLoad', firstLoad);
},

onPaging : function(which_button) {
    grid.setGridParam({datatype:'json'});
},

ondblClickRow: function(id) {                                                                                  
   if (id && id != lastSel) { 
       grid.restoreRow(lastSel);
       grid.setGridParam({editurl:'updateRow'});
       grid.setGridParam({datatype:'json'});
       grid.editRow(id, true);
       lastSel = id;
   }
},

}).navGrid('#pager',{refresh:false,view:false,del:false,add:false,edit:false,cloneToTop:true},
    {}, // default settings for edit
    {}, // default settings for add
    {}, // delete
    {closeOnEscape: true, multipleSearch: true, 
       sopt:['cn','eq','ne','bw','bn'],
         closeAfterSearch: true },          // search options
    {}
);                   // end grid

top_bottom_pager_ButtonAdd = function(options) {
    grid.jqGrid('navButtonAdd',pager_selector,options);
    grid.jqGrid('navButtonAdd','#'+grid[0].id+"_toppager",options);
};
    
top_bottom_pager_ButtonAdd ({
    caption: '',
    title: 'Добавить объект заявки (товар)',
    buttonicon: 'ui-icon-plus',
    onClickButton: function()
    {
          var id_ = '';
          
          $("#create_dialog").load('editAssetDialog?id='+id_);
          $("#create_dialog").dialog({
             title: 'Добавить объект заявки (товар)',
             modal:true,
             width:1100,
             height:390,
             buttons: {
               'OK': function(){                  
                     var values = {};

                     $.each($('#asset-form').serializeArray(), function(i, field) {
                              values[field.name.substr(6,field.name.length-7)] = field.value;
                     });
                     $.ajax({
                             'data': {'Asset[]':values}, 
                             'url': "editAsset?id="+id_,
                             'type': "POST",
                             'dataType': "json",
                             'error': function(res, status, exeption) {
                                    alert("error:"+res.responseText);
                             },
                             'success':  function(data) {
                              if (data.status == 'error')
                                 {
                                   var message='';
                                   $.each(data.message, function(i, field) {
                                          message += field+'\n';
                                    });
                                         alert(message);                                            
                                    }
                                    else
                                    {
                                        var sel_id = data['id_add'];
                                        var sel_row = data['row_add'];
                                        var rt = data['rows'][sel_row]['cell'];
                                        var row = {'id':rt[0],
                                                   'type':rt[1],
                                                   'supergroup':rt[2],
                                                   'group':rt[3],
                                                   'name':rt[4],
                                                   'part_number':rt[5],
                                                   'cost':rt[6],
                                                   'comment':rt[7],
                                                   'article':rt[8],
                                                   'article_code':rt[9],
                                                   'cell_red':rt[10]};
                                               
                                       grid.addRowData(sel_id,row,"last");
                                       grid.setSelection(sel_id, true);
                                        
                                       $("#create_dialog").dialog('close');
                                         
                                     }
                                    }
                            }); 

               },
               'Отмена': function(){
               $(this).dialog('close');
                }
             }
          })
        }
     });
        
top_bottom_pager_ButtonAdd ({
            caption: '', 
            title: 'Редактировать объект заявки (товар)',
            buttonicon: 'ui-icon-pencil',
            onClickButton: function()
            {
            	var sel_ = grid.getGridParam('selrow');
            	if(sel_) id_ = grid.getCell(sel_, 'id');

	           	if(id_) {
                $("#create_dialog").load('editAssetDialog?id='+id_);
                $("#create_dialog").data('parent_id', id_);

                        $("#create_dialog").dialog({
             	        title: 'Редактировать объект заявки (товар)',
                        modal:true,
                        width:1160,
                        height:390,
                        buttons:{
                            'OK': function(){
       var options = {
                url: 'editAsset/?id='+id_,
                type: 'post',
                dataType: 'json',
                error: function(res, status, exeption) {
                                      alert("error:"+res.responseText);
                                    },
                success:  function(data) {

                          var status=data['status'];
                			
          		  if(status=="ok"){
          	 	     grid.setGridParam({datatype:'json'});
			     rd = data['rows'][0]['cell'];    //row data
 			     //!!! OMG, why it uses only associated array!?
			     //TODO: try to make for cycle...
//  			     grid.jqGrid('setRowData',sel_,{'rtype':rd[1],'type':rd[2],'supergroup':rd[3],'group':rd[4],'name':rd[5],'part_number':rd[6],'cost':rd[7],'comment':rd[8],'article':rd[9],'article_code':rd[10]});
			     grid.jqGrid('setRowData',sel_,{
                                 'type':rd[1],
                                 'supergroup':rd[2],
                                 'group':rd[3],
                                 'name':rd[4],
                                 'part_number':rd[5],
                                 'cost':rd[6],
                                 'comment':rd[7],
                                 'article':rd[8],
                                 'article_code':rd[9],
                                 'cell_red':rd[10]});
              		     $("#create_dialog").dialog('close');

                	    }
                	    else if(status=="err"){
	                	alert("error:"+data['message']);
	                    }
                	    else
                            {
                                var response= jQuery.parseJSON (data);
                                $.each(response, function(key, value) { 
                                      $("#"+key+"_em_").show();
                                      $("#"+key+"_em_").html(value[0]);
                                });
                                        }
                    },

            }; 

            // Manually trigger validation
            $('#asset-form').ajaxSubmit(options); 
            },

            'Отмена': function(){
                      $(this).dialog('close');
             }
           },

        });
                  
     } else alert('Выберите товар!');

   },
 });             // end edit button
        
top_bottom_pager_ButtonAdd ({
        caption: '',
        title: 'Удалить объект заявки (товар)!',
        buttonicon: 'ui-icon-trash',
        onClickButton: function()
        {
            var sel_ = grid.getGridParam('selrow');
            if(sel_) {
                var id_ = grid.getCell(sel_, 'id');
                var name_ = grid.getCell(sel_, 'name');

            if(id_) {
                $("#create_del_dialog").dialog({
                    title: 'Удалить объект заявки (товар): '+name_+'?',
                    modal:true,
                    width:300,
                    height:100,
                    buttons:{
                        'Да': function(){
                            
                            var error_str = document.getElementById("error_del_dialog").innerHTML;
                            var tagList = error_str.split(',');
                            document.getElementById("error_del_dialog").innerHTML = tagList[0]+" "+
                                                                                    name_+","+
                                                                                    tagList[1];
                            var options = { 
                                url: '<?php  echo Yii::app()->createUrl('asset/delete',array('id'=>''))?>'+id_,
                                type: 'post',
                                dataType: 'json',
                                error: function(res, status, exeption) {
                                $("#error_del_dialog").dialog({
                                    title: 'Ошибка удаления!',
                                    modal:true,
                                    width:300,
                                    height:150,
                                    buttons:{
                                        'Ok': function(){
                                             $(this).dialog('close')
                                        }
                                       }
                                })
//                                    alert("error from index:"+exeption+' status:'+status);
                                },
                                success:  function(data) {
                                   
                                    if (data.state =="ok")
                                     {   
                                        grid.collapseSubGridRow(sel_)
                                        grid.jqGrid('delRowData',sel_);
                                     }

                                    alert(data.responce);
                                    
                                }
                            };
                            $.ajax(options);
                            $(this).dialog('close');
                        },
                        'Нет': function(){
                            $(this).dialog('close');
                        }
                    }
                });

                };          // if id
            } else  alert('Выберите товар!');              // if sel
       }                   // onclick
 }); // end delete


 $("#list_toppager_right").append ( 
   '<div align="right"><lable>Направление: </lable><select class="dir_selector" id="dir_selector_top"></select></div>');

  $("#pager_right").append ( // here 'pager' part or #pager_left is the id of the pager
   '<div align="right"><lable>Направление: </lable><select class="dir_selector" id="dir_selector_bottom"></select></div>');


      $(".dir_selector").load('getDirectionsForSelect');
      $(".dir_selector").change(function(){
	      	var selected_index=$(this).prop("selectedIndex");
	      	var selected_value=$(this).val();
//	      	alert(selected_index);
	      	//may not work on some bworsers - in FF10 - works well
	      	$("#dir_selector_top").get(0).selectedIndex=selected_index;
	      	$("#dir_selector_bottom").get(0).selectedIndex=selected_index;
	      	grid.setGridParam({datatype:'json'});
			grid.setGridParam({url:'getDataForGrid?dir_selector='+selected_value}); 
		    grid.trigger("reloadGrid");

      });
});

//-------------------------------------------------------------------------------------------------      

</script>
