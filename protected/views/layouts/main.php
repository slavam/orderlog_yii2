
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/dropdown.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/default.ultimate.css" />
	<!--         <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl.'/js/jquery.form.js'?>"></script>  -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div class="menu">
		<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'dropdown'),
			'items'=>array(
				array('label'=>'Главная', 'url'=>array('/site/index'),),
				array('label'=>'Документы', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
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
                                array('label'=>'Отчеты', 'url'=>array('/claimLine/getClaimParams'),'linkOptions'=>array('class'=>'dir'),
                                        'items'=>array(
//                                                        array('label'=>'Контроль лимитов', 'url'=>array('#')),
//                                                        array('label'=>'Заказы по отделениям', 'url'=>array('#')),
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
                            array('label'=>'Каталоги и справочники', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
                                        'items'=>array(
                                                        array('label'=>'Глобальные', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
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
                                                        array('label'=>'Внешние классификаторы', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
                                                            'items'=>array(
//                                                              
                                                                array('label'=>'Расположения', 'url'=>array('/place/tree')),
                                                                array('label'=>'Характеристики', 'url'=>array('/feature/index')),
                                                                array('label'=>'Продукты', 'url'=>array('/product/index')),
                                                                )
                                                            ),
                                                        array('label'=>'Фин. контур', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
                                                                        'items'=>array(
//                                                                            array('label'=>'ЦФО', 'url'=>array('#')),
//                                                                            array('label'=>'Статьи бюджета', 'url'=>array('#')),
//                                                                            array('label'=>'Товары', 'url'=>array('#')),
                                                                            array('label'=>'Комплекты', 'url'=>array('/complect/index')),
                                                                            
                                                                            
                                                                            )
                                                                        ),
                                             array('label'=>'Логистика', 'url'=>array('#'),'linkOptions'=>array('class'=>'dir'),
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
        <div class="clear"></div>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> ВСЕУКРАИНСКИЙ БАНК РАЗВИТИЯ.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>