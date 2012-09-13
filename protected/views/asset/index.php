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

/*
$this->breadcrumbs=array(
	'Товары',
);
*/
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
//        rowList : [ 50, 100, 500, 1000 ],
        sortname : 'name',
        sortorder : 'asc',
//        recordtext: 'Товар(ы) {0} - {1}',
//        viewrecords : true,
        caption : 'Товары',
        toppager:true,

//        rowList: [],        // disable page size dropdown
    pgbuttons: false,     // disable page control like next, back button
    pgtext: null,         // disable pager text like 'Page 0 of 10'
    viewrecords: false,    // disable current view record text like 'View 1-10 of 100'

/*
  grouping:true, 
  groupingView : { 
     groupField : ['supergroup','group'],
     groupOrder : ['asc','asc'],
     groupText : ['<b>{0}</b>','<b>{0}</b>'],
     groupColumnShow : [false,false],
     groupCollapse : true,
     groupSummary: [false,false]
  },
*/  
  

    
    loadonce: true, // to enable sorting on client side
    
afterInsertRow: function(row_id, row_data){
    if (row_data.cell_red) {
        $('#list').jqGrid('setCell',row_id,'article_code','',{'color':'red'});
    }
},

//	sortable: true, //to enable sorting
//

gridComplete: function () {
    grid.setGridParam({datatype:'local'});
    $("#firstLoad").data('firstLoad', firstLoad);
},
//
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



    }).navGrid('#pager',{refresh:false,search:false,view:false,del:false,add:false,edit:false,cloneToTop:true}); 

	top_bottom_pager_ButtonAdd = function(options) {
        grid.jqGrid('navButtonAdd',pager_selector,options);
        grid.jqGrid('navButtonAdd','#'+grid[0].id+"_toppager",options);
    };

    top_bottom_pager_ButtonAdd ({
            caption: '',//'Подгруппа',
            title: 'Редактировать',
            buttonicon: 'ui-icon-pencil',
            onClickButton: function()
            {
             	//alert("!");
//             	$("#create_dialog").load('create');
            	var sel_ = grid.getGridParam('selrow');
            	if(sel_) id_ = grid.getCell(sel_, 'id');

	           	if(id_) {

                
        //        var firstLoad = $("#firstLoad").data("firstLoad");
                //if(!firstLoad) {
//                    alert('resurect!');
                    //$("#create_multiple_dialog_table").jqGrid('clearGridData');
                    
                    //$("#create_multiple_dialog_table").jqGrid('GridUnload');
                    //$("#create_multiple_dialog_table").empty();
                    //$("#create_multiple_dialog_table").remove();
                    //$('#resurection').append("<table id='create_multiple_dialog_table'></table>");
  //                  firstLoad=true;
    //                $("#firstLoad").data("firstLoad",firstLoad);
                    
      //          }
                
                $("#create_dialog").load('editAssetDialog?id='+id_);
                $("#create_dialog").data('parent_id', id_);

                        $("#create_dialog").dialog({
             			title: 'Редактировать товар',
                        modal:true,
                        width:1160,
                        height:540,
                        //stack: false,
                        buttons:{
                            'OK': function(){
                                //alert($("#supergroups-list").val());
//                                $response = $("#asset-form").submit();

var options = {
//                success: function(data){alert(data);},
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
//	                	 			grid.setGridParam({url:'getDataForGrid'}); //?id='+id_}); 
							rd = data['rows'][0]['cell']; //row data
									//!!! OMG, why it uses only associated array!?
									//TODO: try to make for cycle...
//									grid.jqGrid('setRowData',sel_,{'rtype':rd[1],'type':rd[2],'supergroup':rd[3],'group':rd[4],'name':rd[5],'part_number':rd[6],'cost':rd[7],'comment':rd[8],'article':rd[9],'article_code':rd[10]});
									grid.jqGrid('setRowData',sel_,{'type':rd[1],'supergroup':rd[2],'group':rd[3],'name':rd[4],'part_number':rd[5],'cost':rd[6],'comment':rd[7],'article':rd[8],'article_code':rd[9],'cell_red':rd[10]});
	                			  $("#create_dialog").dialog('close');

//								    grid.trigger("reloadGrid");

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
//            if ($("#asset-form").validate().form() == true) {
                $('#asset-form').ajaxSubmit(options); 
//            }

//                                $(this).dialog('close');
                                },


                 'Отмена': function(){
//                               $("#create_multiple_dialog_table").empty();
//                                $("#create_multiple_dialog_table").jqGrid('GridUnload');
//                                $("#create_multiple_dialog_table").jqGrid('clearGridData');
//   alert('From index:' + parseInt($("#create_multiple_dialog_table").getGridParam("records"),10));

                                $(this).dialog('close');
                            }
                        },


                    });
			    } else alert('Выберите товар!');
/*
$.ajax({
          url: 'addAssetDialog', // вообще, не люблю такой мешанины js и php, надобно конечно url получать из тега, так универсальнее
          context: $('#create_dialog'),
          success: function(data){
            $(this).html(data); // тут важно обратить внимание на то, что вставляется полностью ответ. Если брать только какой-то див из ответа, не будут срабатывать скрипты формы.
          }
        });

        return false;*/

            },
        });

    /*
       grid.jqGrid('navButtonAdd','#pager',{
            caption: '',//'Подгруппа',
            title: 'Добавить подгруппу',
            buttonicon: 'ui-icon-plus',
            onClickButton: function()
            {
             	alert("!");
            },
        });
        */


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

<?php //echo CHtml::link('Добавить товар', Yii::app()->createUrl("asset/create"))?>
<br>
<?php echo CHtml::link('Добавить товар по шаблону', Yii::app()->createUrl("assetTemplate/getTemplate"))?>
