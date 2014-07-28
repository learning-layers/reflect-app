<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'question-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaRow($model, 'name', array('class'=>'span8', 'rows'=>8)); ?>

<?php

$cCategory = new CDbCriteria;
$cCategory->select = 'id,name';
$cCategory = Category::model()->findAll($cCategory);
echo $form->dropDownListRow($model, 'category_id', CHtml::listData($cCategory, 'id', 'name'), array('prompt' => 'no category', 'class' => 'span5'));

?>



<?php echo $form->checkboxRow($model, 'public'); ?>

<?php echo $form->checkboxRow($model, 'blocked'); ?>

<?php echo $form->textFieldRow($model, 'created', array('class' => 'span5','readonly'=>true)); ?>

        <p class="help-block"> <span class="required">*</span> are required fields</p> 


<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
