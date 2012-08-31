<table id="<?echo $widget->gridId;?>"></table>
<?
if ($widget->options['pager']):
?>
<div id="<?echo $widget->gridId.'-pager';?>"></div>
<?endif;?>
    
    <?php

echo $grid;
?>
