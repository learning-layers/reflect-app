<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - New stack';
$this->breadcrumbs = array(
    'New stack',
);
?>


<h1><?php echo CHtml::image('images/stack_48.png', ''); ?> New stack</h1>

<p>Here you can add a new stack</p>

<hr>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'newstack-form',
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
        'label' => 'Create Stack',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>