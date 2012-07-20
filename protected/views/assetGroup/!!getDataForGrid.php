<?php
ini_set("display_errors","1"); 
require_once 'C:/Sites/yii/demos/ordertest/jqgrid/jq-config.php'; 
require_once ABSPATH."php/jqAutocomplete.php"; 
require_once ABSPATH."php/jqCalendar.php"; 
require_once ABSPATH."php/jqGrid.php"; 
require_once ABSPATH."php/jqGridPdo.php"; 
// Connection to the server 
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD); 
// Tell the db that we use utf-8 
$conn->query("SET NAMES utf8"); 
// Create the jqGrid instance 
$grid = new jqGridRender($conn); 
// Write the SQL Query 
$grid->SelectCommand = 'SELECT * FROM asset_groups'; 
// set the ouput format to json 
//$grid->dataType = 'json'; 
$grid->table ="asset_groups"; 
$grid->setPrimaryKeyId("id"); 
$grid->serialKey = false; 
// Let the grid create the model 
$grid->setColModel(); 
// Set the url from where we obtain the data 
//$grid->setUrl('protected/views/assetGroup/index.php'); 
$grid->setUrl($this->createUrl('assetGroup/getDataForGrid')); 
//$grid->url = $this->createUrl('protected/views/assetGroup/getDataForGrid.php'); 
$grid->cacheCount = true; 
// Set grid caption using the option caption 
$grid->setGridOptions(array( 
    "caption"=>"Группы товаров", 
    "rowNum"=>10, 
    "sortname"=>"id", 
    "hoverrows"=>true, 
    "rowList"=>array(10,20,50), 
    "postData"=>array("grid_recs"=>776) 
    )); 
// Change some property of the field(s) 
//$grid->setColProperty("id", array("label"=>"ID", "width"=>60, "editable"=>false)); 
//$grid->setColProperty('name', array("edittype"=>"select", "editoptions"=>array("value"=>" :Select")));
//$grid->setColProperty("OrderDate", array( 
//    "formatter"=>"date", 
//    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y") 
//    ) 
//); 
//$grid->setAutocomplete("id",false,"SELECT * FROM blocks WHERE name LIKE ? ORDER BY name",null,true,true);
//$grid->setColProperty("name", array("label"=>"Группа", "width"=>260, "editable"=>true)); 
//$grid->setDatepicker("OrderDate",array("buttonOnly"=>false)); 
//$grid->datearray = array('OrderDate'); 
// Enjoy 
$grid->navigator = true; 
$grid->setGridEvent('onSelectRow', "
function(rowid, selected) 
{ 
    if(rowid && rowid !== lastSelection) { 
        $(\"#grid\").jqGrid('restoreRow', lastSelection); 
        $(\"#grid\").jqGrid('editRow', rowid, true); 
        lastSelection = rowid; 
    } 
} 
"); 

//$grid->addCol(array( 
//    "name"=>"actions", 
//    "formatter"=>"actions", 
//    "editable"=>false, 
//    "sortable"=>false, 
//    "resizable"=>false, 
//    "fixed"=>true, 
//    "width"=>60, 
//    "formatoptions"=>array("keys"=>true) 
//    ), "first"); 
//$grid->setColProperty('id', array("editable"=>false)); 
//$grid->setColProperty("name", array("label"=>"Группа", "width"=>160, "editable"=>true)); 
////$grid->setColProperty('BirthDate',  
////        array("formatter"=>"date","formatoptions"=>array("srcformat"=>"Y-m-d H:i:s", "newformat"=>"Y-m-d"))); 
//// Set some grid options 
//$grid->setGridOptions(array( 
//    "rowNum"=>10, 
//    "rowList"=>array(10,20,30), 
//    "sortname"=>"id" 
//)); 
//// Date formatting and settings - editing 
//$grid->setDbDate('Y-m-d'); 
//$grid->setDbTime('Y-m-d H:i:s'); 
//
////User date see formatter data. Birthdate is a defined as datetime 
//$grid->setUserDate('Y-m-d'); 
//// the same as formatter 
//$grid->setUserTime('Y-m-d'); 
//// serching date 
//$grid->datearray = array('id'); 
// Enjoy 
$grid->renderGrid('#grid','#pager',true, null, null, true,true); 
$conn = null;             
?>