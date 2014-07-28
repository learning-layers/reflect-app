<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Forgot password';
$this->breadcrumbs = array(
    'Forgot password',
);
?>


<h1><?php echo CHtml::image('images/forgot_48.png', ''); ?> Forgot Password</h1>

<p>You can reset your password by sending a new random password to you e-mail account.</p>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'register-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 250)); ?>

<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Reset password',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

