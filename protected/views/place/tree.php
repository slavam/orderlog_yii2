<?php
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
?>
<?php echo CHtml::link(CHtml::encode('Списком'), array('index')); ?>