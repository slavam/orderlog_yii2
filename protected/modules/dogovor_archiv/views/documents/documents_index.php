<?php
 
//$this->widget('zii.widgets.grid.CGridView', array(
//	'dataProvider'=>$model->search(),
//        'rowCssClassExpression'=>'(Document::checkExpiredDate($data)? "expired" : "unexpired"." ".(($row%2)?"even":"odd"))',
//        'enableSorting'=>true,
//        'filter'=>$model,
//	'columns'=>array(
//		array(
//			'name'=>'dog_kind',
//                        'type'=>'text',
//                        'header'=>$model->getAttributeLabel('dog_kind'),
//                        'value'=> 'Document::checkDogKind($data)'
//		),
//		array(
//			'name'=>'provider',
//                        'type'=>'text',
//                        'header'=>$model->getAttributeLabel('provider'),
//                        'value'=>'$data->provider'
//		),
//		array(
//			'name'=>'okpo',
//                        'type'=>'text',
//                        'header'=>$model->getAttributeLabel('okpo')
//		),
//                array(
//			'name'=>'dog_number',
//			'type'=>'text',
//                        'header'=>$model->getAttributeLabel('dog_number'),
//		),
//                array(
//			'name'=>'dog_date',
//			'type'=>'text',
//                        'header'=>$model->getAttributeLabel('dog_date'),
//		),
//              
//                array(
//			'name'=>'start_date',
//			'type'=>'text',
//                        'header'=>$model->getAttributeLabel('start_date'),
//		),
//                array(
//			'name'=>'stop_date',
//			'type'=>'text',
//                        'header'=>$model->getAttributeLabel('stop_date'),
//		),
//                array(
//			'name'=>'branch',
//			'type'=>'text',
//                        'header'=>$model->getAttributeLabel('branch'),
//		),
//                array(
//			'name'=>'author_login',
//			//'type'=>'raw',
//                        //'value'=>'CHtml::textField(\'Document[author_login]\',$data->author_login)',
//                        'filter'=>false,
//                        'header'=>$model->getAttributeLabel('author_login'),
//		),
//                array(
//			'name'=>'status',
//			'type'=>'text',
//                        'filter'=>$model->getStatuses(),
//                        'header'=>$model->getAttributeLabel('status'),
//                        'value'=> 'Document::checkStatus($data)'
//		),
//                array(
//			'name'=>'pay_system',
//			'type'=>'text',
//                        'filter'=>false,
//                        'header'=>$model->getAttributeLabel('pay_system'),
//                        'value'=> 'Document::checkPaySystems($data)'
//		),
//		array(
//			'class'=>'CButtonColumn',
//                        'buttons'=>array(
//                            'delete'=>array(
//                                'visible'=>'in_array($data->status,array(0,1))',
//                            )
//                        )
//		),
//	),
//));

?>

<script type="text/javascript">
    $.jgrid.no_legacy_api = true;
    $.jgrid.useJSON = true;
</script>
<h1>Журнал регистрации договоров</h1>
<table id="jqgrid">

</table>
<div id="pager"></div>
<p class="result"></p>
<script type="text/javascript">
    $(function() {
        jQuery("#jqgrid").jqGrid( {
            url : '/index.php/dogovor_archiv/documents/Jqgrid/',
            datatype : 'json',
            mtype : 'GET',
            width:'100%',
            height:'auto',
            hoverrows:false,
            sortable:true,
            autowidth:true,
            ignoreCase:true,
            colNames : <? echo $cols; ?>,
            colModel : <? echo $colModel; ?>,
            //        colNames : ['id','11'],
            //        colModel : [{name:'id'},{name:'22'}],
            pager : '#pager',
            rowNum : 0,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: '',         // disable pager text like 'Page 0 of 10'
            viewrecords: false,
            sortname : 'dog_date',
            sortorder : 'asc',
            caption : 'Документы',
            subGrid: true,
    subGridRowExpanded: 
        function(subgrid_id, row_id) {
	    var subgrid_table_id;
            
	    subgrid_table_id = subgrid_id+'_t';
	    $('#'+subgrid_id).html('<table id="'+subgrid_table_id+'"></table><div id="'+subgrid_table_id+'_pager"></div>');
	    $('#'+subgrid_table_id).jqGrid({
	        url: '/index.php/dogovor_archiv/documents/jqgrid/?action=sub',
	        datatype: 'json',
	        mtype: 'POST',
	        postData: {'get':'subgrid','id':row_id},
	        colNames : <? echo $cols; ?>,
                colModel : <? echo $colModel; ?>,
	        height: 'auto',
	        autowidth: true,
	        rownumWidth: 40,
	        rowNum: 10,
	        sortname: 'name',
	        sortorder: 'asc',
                pgbuttons: false,     // disable page control like next, back button
                pgtext: '',         // disable pager text like 'Page 0 of 10'
                viewrecords: false,
	        pager: $('#'+subgrid_table_id+'_pager'),
	        rowNum:10,
                caption : 'Доп. соглашения'
//                editurl:"/dogovor_archiv/reference/addreferenceitem?pid="+row_id
	    }).jqGrid('navGrid', '#'+subgrid_table_id+'_pager',{add: false, del: false, edit: false, search: false},
        {
            closeAfterEdit: true
           // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
           closeAfterAdd:true
          // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
          // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
            closeOnEscape:true,
            multipleSearch:true,
            closeAfterSearch:true,
            
        }
    );
    },
    gridComplete:function(){
             var rows = $('#jqgrid').jqGrid('getDataIDs');
             var cl;
             var t1,t2,row;
             t2=new Date().getTime();
                for( i=0; i < rows.length; i++){
                  row = $('#jqgrid').jqGrid('getRowData',rows[i]);
                  //t2 = d2.getTime();
                    var strDate = row['stop_date'];
                    var dateParts = strDate.split(".");

                  t1 = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]).getTime();

                  if( parseInt(Math.abs(t2-t1)/(24*3600*1000)) > 30 ) cl="";
                  else cl="red";
                  /*
                  $.post('/documents/checkexpireddate',{stop_date:row['stop_date']}, function(data) {
                    if (data=="0") cl="green";
                    else cl="red";
                    
                 });
                 */    
                    $('#jqgrid').jqGrid('setRowData',rows[i],false, {color:cl});
                }
            },
            editurl: '/index.php/dogovor_archiv/documents/Update'
        }).jqGrid('navGrid', '#pager',{add: false, del: false, edit: false, search: true},
        {},{},{},
        {closeOnEscape:true, multipleSearch:true, closeAfterSearch:true,sopt:['eq','cn'],groupOps: false});//search settings
        
        $('#jqgrid').jqGrid('navSeparatorAdd','#pager');
        $('#jqgrid').jqGrid('navButtonAdd','#pager',{
            caption: 'Добавить',
            title: 'Создать документ',
            buttonicon: 'ui-icon-plus',
            onClickButton: function()
            {
              
                //                 $('#jqgrid').dialog({
                //			height: 140,
                //			modal: true
                //		})
                $(location).attr('href','/index.php/dogovor_archiv/documents/add');
            },
            position:'last'
        })
        $('#jqgrid').jqGrid('navButtonAdd','#pager',{
            caption: 'Редактировать',
            title: 'Редактировать запись',
            buttonicon: 'ui-icon-wrench',
            onClickButton: function()
            {
                var gsr = jQuery("#jqgrid").jqGrid('getGridParam','selrow'); 
                if(gsr){
                    $(location).attr('href','/index.php/dogovor_archiv/documents/update/?id='+gsr);
                } else { alert("Выберите запись") }
            },
            position:'last'
        })
    });
    

</script>