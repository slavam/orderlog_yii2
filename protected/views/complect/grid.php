<?php 
//require_once '../../../jq-config.php'; 
require_once 'C:/Sites/yii/demos/ordertest/jqgrid/jq-config.php'; 
// include the jqGrid Class 
require_once ABSPATH."php/jqGrid.php"; 
// include the driver class 
require_once ABSPATH."php/jqGridPdo.php"; 
// Connection to the server 
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD); 
// Tell the db that we use utf-8 
$conn->query("SET NAMES utf8"); 

// Create the jqGrid instance 
$grid = new jqGridRender($conn); 
// Write the SQL Query 
$grid->SelectCommand = 'SELECT * FROM complects';
// Set the table to where you update the data 
$grid->table = 'complects'; 
// Set output format to json 
$grid->dataType = 'json'; 
// Let the grid create the model 
$grid->setPrimaryKeyId('id'); 
$grid->setColModel(); 
// Set the url from where we obtain the data 
$grid->setUrl("C:/Sites/yii/demos/ordertest/protected/views/complect/grid.php"); 
// Set some grid options 
$grid->setGridOptions(array( 
    "rowNum"=>10, 
    "height"=>250, 
//    "gridview"=>false, 
    "rowList"=>array(10,20,30), 
    "sortname"=>"id" 
)); 
$grid->setColProperty('id', array("label"=>"ID", "width"=>50)); 
// Set the parameters for the subgrid 
$grid->setSubGrid("C:/Sites/yii/demos/ordertest/protected/views/complect/subgrid.php");
//        array('id', 'complect_id', 'asset_id', 'amount'), 
//        array(60,120,150,70), 
//        array('left','left','left','right')); 
// Enable navigator 
$grid->navigator = true; 
// Enable only editing 
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Enjoy 
$grid->renderGrid('#grid','#pager',true, null, null, true,true); 
$conn = null; 
?> 