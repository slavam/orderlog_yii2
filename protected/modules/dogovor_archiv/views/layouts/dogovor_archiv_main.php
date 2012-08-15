<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dogovor_archiv_style.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" media="screen, projection" />
</head>
<body>    
    
    
    
<div id="wrapper">
    <div id="header">
        <div class="logo-container">
                        <img src="/images/logo.gif"  class="site-logo"/>
                        <h1 class="site-slogan colored"><?php echo CHtml::encode(Yii::app()->modules['dogovor_archiv']['modulename']); ?></h1>
        </div>
        <div class="header-topmenu"> 
          <?php $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                        array('label'=>'Home', 'url'=>array('/site/index')),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Добавить документ', 'url'=>array('/dogovor_archiv/documents/add')),
                        array('label'=>'Список документов', 'url'=>array('/dogovor_archiv/documents/view')),
                        array('label'=>'Сравочники', 'url'=>array('/dogovor_archiv/reference/view')),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                ),
                'htmlOptions'=>array('class'=>'sf-menu'),
                'lastItemCssClass'=>'last',
            )); ?>
        </div>
    </div><!-- header -->
    <div id="middle">
        <div id="container">
            
            <div id="content-block">
                <?php 
                //Yii::app()->user->getFlash('notice');
                if(isset($this->breadcrumbs))
                {
                    $this->widget('zii.widgets.CBreadcrumbs', array('links'=>$this->breadcrumbs)); 
                }
                
                ?><!-- breadcrumbs -->
                               
                <?php echo $content; ?>
            </div>                  
        </div><!-- #container-->
            <div class="sidebar" id="sideLeft">
                   <!--<div class="block">
				<h3>Поиск</h3>
				<form id="search-form" method="get" action="">
				<input type="text" onblur="if(this.value=='') this.value='Search...'" onfocus="if(this.value=='Search...') this.value=''" value="Search..." name="search">
				</form>
			</div>-->
			<div class="block">
                            <h3>Меню</h3>
			 <?php $this->widget('zii.widgets.CMenu',array(
                            'items'=>array(
                                array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                array('label'=>'Добавить документ', 'url'=>array('/dogovor_archiv/documents/add')),
                                array('label'=>'Список документов', 'url'=>array('/dogovor_archiv/documents/view')),
                                array('label'=>'Шаблоны', 'url'=>array('/dogovor_archiv/template/view')),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                                ),
                            'htmlOptions'=>array('class'=>'sidebar-menu'),
                            'lastItemCssClass'=>'last'
                             )); ?>
			</div>
            </div><!-- .sidebar#sideLeft -->
    </div><!-- #middle-->
</div><!-- #wrapper -->
<div id="footer">
  
</div><!-- #footer -->

</body>
</html>