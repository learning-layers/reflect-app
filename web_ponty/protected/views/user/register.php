<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Registration';
$this->breadcrumbs = array(
    'Registration',
);
?>


<h1><?php echo CHtml::image('images/register_48.png', ''); ?> Registration</h1>

<p>Please fill in your email. A password will be send to your email afterwards:</p>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'register-form',
    'enableAjaxValidation' => true,
    'type' => 'horizontal',
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 250)); ?>

<small><span class="required">*</span> are required fields.</small>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Regsiter',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
