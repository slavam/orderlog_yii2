<?php
/*
	$this->widget('application.extensions.MTreeView.MTreeView',array(
		'collapsed'=>true,
		'animated'=>'fast',
		//---MTreeView options from here
		'table'=>'places',//what table the menu would come from
		'hierModel'=>'adjacency',		//hierarchy model of the table
		'conditions'=>array('visible=:visible',array(':visible'=>1)),//other conditions if any                                    
		'fields'=>array(//declaration of fields
			'text'=>'title',//no `text` column, use `title` instead
			'alt'=>false,//skip using `alt` column
			'id_parent'=>'parent_id',//no `id_parent` column,use `parent_id` instead
			'task'=>false,
			'icon'=>false,
			'position'=>'title',
			'options'=>'options',
			'url'=>'url'
//			'url'=>array('/site/branches',array('id'=>'id'))
//			'url'=>array('/menuAdjacency/view',array('id'=>'id'))
			//'url'=>"CONCAT('/',title,'/id',id)"
		),
	));
*/
?>
<h1>Расположение</h1>

<div id="mtreeview" style="width: 235px;float:left">
<?php 
	$this->widget('application.extensions.MTreeView.MTreeView',array(
		'collapsed'=>true,
		'animated'=>'fast',
		//---MTreeView options from here
		'table'=>'places',//what table the menu would come from
		'hierModel'=>'adjacency',//hierarchy model of the table
		'conditions'=>array('visible=:visible',array(':visible'=>1)),//other conditions if any                                    
		'fields'=>array(//declaration of fields
			'text'=>'title',//no `text` column, use `title` instead
			'alt'=>'title',//skip using `alt` column
			'id_parent'=>'parent_id',//no `id_parent` column,use `parent_id` instead
			'position'=>'title',
			'task'=>false,
			'options'=>'options',
			'url'=>array('place/add',array('id_add'=>'id'))
		),
//		'template'=>'{icon}&nbsp;{text}',
		'ajaxOptions'=>array('update'=>'#mtreeview-target')
	));
?>
</div>
<div id="mtreeview-target" style="border: 1px solid gray; padding: 10px; margin-left: 240px;min-height: 100px">
Click on any link of the tree at the left...
</div>



<?php echo CHtml::link(CHtml::encode('Списком'), array('index')); ?>
