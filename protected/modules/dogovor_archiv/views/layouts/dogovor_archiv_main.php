<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dogovor_archiv_style.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/dropdown.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/default.ultimate.css" />
</head>
<body>    
    
    
    
<div id="wrapper">
    <div id="header">
        <div class="logo-container">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.gif"  class="site-logo"/>
                        <h1 class="site-slogan colored"><?php echo CHtml::encode(Yii::app()->modules['dogovor_archiv']['modulename']); ?></h1>
                       <div class="menu">
		<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'dropdown'),
			'items'=>array(
				array('label'=>'Главная', 'url'=>array('/site/index'),),
				array('label'=>'Документы', 'linkOptions'=>array('class'=>'dir'),
                                    'items'=>array(
                                                    array('label'=>'Первичные заявки', 'url'=>array('/claim/indexJqgrid')),
//                                                    array('label'=>'Консолидированная заявка', 'url'=>array('/claimLine/getClaimParams')),
//                                                    array('label'=>'Проект бюджета', 'url'=>array('#')),
//                                                    array('label'=>'Бюджет', 'url'=>array('#')),
                                                    ////
//                                                    array('label'=>''),
                                                    array('label'=>'Договора', 'url'=>array('/dogovor_archiv/documents')),
//                                                    array('label'=>'Счета', 'url'=>array('#')),
//                                                    array('label'=>'Доверенности', 'url'=>array('#')),
                                                  )
                                    ),
                                array('label'=>'Отчеты','linkOptions'=>array('class'=>'dir'),
                                        'items'=>array(
                                                        array('label'=>'Контроль лимитов', 'url'=>array('/claimLine/getClaimParams')),
                                                        array('label'=>'Экспорт заявок в Excel-формат', 'url'=>array('/claim/claimsExportToExcel')),
//                                                        array('label'=>''),
//                                                        array('label'=>'Исполнение договоров', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
//                                                            'items'=>array(
//                                                                array('label'=>'Оплаты', 'url'=>array('#')),
//                                                                array('label'=>'Поставки', 'url'=>array('#')),
//                                                            )
//                                                            ),
//                                                        ////
//                                                        array('label'=>'Треб. пролонгации договора','url'=>array('#')),
//                                                        array('label'=>'Счета к оплате', 'url'=>array('/#')),
//                                                        array('label'=>'Сопровождающие документы', 'url'=>array('#')),
                                                    )
                                        ),
                            array('label'=>'Каталоги и справочники', 'linkOptions'=>array('class'=>'dir'),
                                        'items'=>array(
                                                        array('label'=>'Глобальные', 'linkOptions'=>array('class'=>'dir'),
                                                            'items'=>array(
//                                                                array('label'=>'Отделения', 'url'=>array('#')),
//                                                                array('label'=>'Подразделения', 'url'=>array('#')),
//                                                                array('label'=>'Бизнесы', 'url'=>array('#')),
//                                                                array('label'=>'Сотрудники', 'url'=>array('#')),
                                                                array('label'=>'Группы', 'url'=>array('/assetGroup/index')),
                                                                array('label'=>'Шаблоны', 'url'=>array('/assetTemplate/indexJqgrid')),
                                                                 array('label'=>'Объекты заявки (товары)', 'url'=>array('/asset/index')),
                                                                )
                                                            ),
                                                        array('label'=>'Внешние классификаторы', 'linkOptions'=>array('class'=>'dir'),
                                                            'items'=>array(
//                                                              
                                                                array('label'=>'Расположения', 'url'=>array('/place/tree')),
                                                                array('label'=>'Характеристики', 'url'=>array('/feature/index')),
                                                                array('label'=>'Продукты', 'url'=>array('/product/index')),
                                                                )
                                                            ),
                                                        array('label'=>'Фин. контур', 'linkOptions'=>array('class'=>'dir'),
                                                                        'items'=>array(
//                                                                            array('label'=>'ЦФО', 'url'=>array('#')),
//                                                                            array('label'=>'Статьи бюджета', 'url'=>array('#')),
//                                                                            array('label'=>'Товары', 'url'=>array('#')),
                                                                            array('label'=>'Комплекты', 'url'=>array('/complect/index')),
                                                                            
                                                                            
                                                                            )
                                                                        ),
                                             array('label'=>'Логистика', 'linkOptions'=>array('class'=>'dir'),
                                                                        'items'=>array(
                                                                           
//                                                                            array('label'=>'Единицы измерения', 'url'=>array('#')),
//                                                                            array('label'=>'Места хранения', 'url'=>array('#')),
                                                                            )
                                                                        ),
                                                    )
                                        )
//				array('label'=>'Заявки', 'url'=>array('/claim/indexJqgrid')),
//                                array('label'=>'К-заявки', 'url'=>array('/claimLine/getClaimParams')),
//                                array('label'=>'Расположение', 'url'=>array('/place/tree')),
//                                array('label'=>'Продукты', 'url'=>array('/product/index')),
//                                array('label'=>'Характеристики', 'url'=>array('/feature/index')),
//                                array('label'=>'Шаблоны', 'url'=>array('/assetTemplate/indexJqgrid')),
//                                array('label'=>'Комплекты', 'url'=>array('/complect/index')),
//				array('label'=>'Товары', 'url'=>array('/asset/index')),
//                                array('label'=>'Группы', 'url'=>array('/assetGroup/index')),
////                                array('label'=>'Супергруппы', 'url'=>array('/block/index')),
//                                array('label'=>'Модуль Договора', 'url'=>array('/dogovor_archiv/')),
//				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
//				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
		)));
                ?>
	</div><!-- mainmenu -->
        </div>
       
    </div><!-- header -->
    
        <div class="clear"></div>
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
<!--			<div class="block">
                            <h3>Меню</h3>-->
			 <?php 
//                         $this->widget('zii.widgets.CMenu',array(
//                            'items'=>array(
//                                array('label'=>'Home', 'url'=>array('/site/index')),
//				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
//                                array('label'=>'Добавить документ', 'url'=>array('/dogovor_archiv/documents/add')),
//                                array('label'=>'Список документов', 'url'=>array('/dogovor_archiv/documents/view')),
//                                array('label'=>'Шаблоны', 'url'=>array('/dogovor_archiv/template/view')),
//				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
//                                ),
//                            'htmlOptions'=>array('class'=>'sidebar-menu'),
//                            'lastItemCssClass'=>'last'
//                             )); 
                         ?>
<!--			</div>-->
            </div><!-- .sidebar#sideLeft -->
    </div><!-- #middle-->
</div><!-- #wrapper -->
<div id="footer">
  
</div><!-- #footer -->

</body>
</html>