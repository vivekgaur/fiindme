<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php
	echo $this->renderPartial('/contact/_form',array('model'=> new Contact));
	  /*<div class="row">
		<?php echo $form->labelEx($model,'contact_id_fk'); ?>
		<?php echo $form->textField($model,'contact_id_fk'); ?>
		<?php echo $form->error($model,'contact_id_fk'); ?>
		</div>*/
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'deals_id_fk'); ?>
		<?php echo $form->textField($model,'deals_id_fk'); ?>
		<?php echo $form->error($model,'deals_id_fk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'default_zipcode_id_fk'); ?>
		<?php echo $form->textField($model,'default_zipcode_id_fk'); ?>
		<?php echo $form->error($model,'default_zipcode_id_fk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_update'); ?>
		<?php echo $form->textField($model,'last_update'); ?>
		<?php echo $form->error($model,'last_update'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->