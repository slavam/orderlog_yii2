<?php 
$deleteaction = array(1 => "/advplace/deleteall/?id=", 2 =>  "/advplace/delete/?id=");

if ($this->parent_type != 2) {
    echo "<h3>".$this->parent_model->title."</h3>";  
    } else {
        echo "<h3>".$this->parent_model->tooltip."</h3>";
        echo "<b>Изменить место расположения:</b><br>";
    }
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
                               'id'=>'advplace-form',
//                               'action' => array('/advplace/add'),
                               'enableAjaxValidation'=>true,
                               'enableClientValidation' => true,
                               'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'validateOnChange' => false,
                                ),
        )); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязяательны для заполнения.</p>

	<?php // echo $form->errorSummary($model); ?>

       <?php if ($this->parent_type == 0) {?>

	<div class="row">
		<?php echo $form->labelEx($model,'town'); ?>
		<?php echo $form->textField($model,'town',array('size'=>45,'maxlength'=>125)); ?>
                <?php // echo $form->hiddenField($model,'town', array('value'=>TRUE, 'style'=>'display: none;')); ?>

		<?php echo $form->error($model,'town'); ?>
	</div>
     <?php } else {
                 echo $form->hiddenField($model,'town', array('value'=>$this->parent_model->title, 'style'=>'display: none;'));      
     }?>

	<div class="row">
		<?php echo $form->labelEx($model,'place'); ?>
		<?php echo $form->textField($model,'place',array('size'=>45,'maxlength'=>125)); ?>
		<?php echo $form->error($model,'place'); ?>
                <?php echo $form->hiddenField($model,'add_record', array('value'=>$this->parent_type, 'style'=>'display: none;')); ?>
	</div>

	<div class="row submit">
		<?php echo CHtml::submitButton('Submit'); ?>
            <?php 
/*
            echo CHtml::ajaxSubmitButton('Обработать', '',
                    array(
                        'type' => 'POST',
                        'update' => '#advplace-form',

                    ),
                    array('live'=>false, 'type' => 'submit')
//                    array('type' => 'submit')
                    );
 * 
 */
            ?>
	</div>

<?php $this->endWidget(); ?>
        
<?php if ($this->parent_type != 0) {?>

<?php $form=$this->beginWidget('CActiveForm', array(
//                               'id'=>'place-delete-form',
//                               'action' => array('/site/contact/'.$this->parent_model->id),
//                               'action' => array($deleteaction[$this->parent_type].$this->parent_model->id),
                               'action' => array('/place/delete/?id='.$this->parent_model->id),
      )); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Delete this record'); ?>
	</div>

<?php $this->endWidget(); ?>
<?php }?>

         
</div><!-- form -->

