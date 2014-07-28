<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>250)); ?>

	<?php //echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->checkboxRow($model,'is_admin'); ?>

	<?php echo $form->checkboxRow($model,'blocked'); ?>

<?php echo $form->textFieldRow($model, 'created', array('class' => 'span5','readonly'=>true)); ?>

        <p class="help-block"> <span class="required">*</span> are required fields</p> 


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
