<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Edit stack';
$this->breadcrumbs = array(
    'Edit stack',
);
?>


<h1><?php echo CHtml::image('images/stack_48.png', ''); ?> Edit stack</h1>

<p>Here you can edit the selected stack</p>

<hr>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'stackedit-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 250)); ?>

<?php echo $form->textAreaRow($model, 'description', array('class' => 'span5', 'rows' => 5)); ?>

<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Update Stack',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>