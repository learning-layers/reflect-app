<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Change password';
$this->breadcrumbs = array(
    'Change password',
);
?>


<h1><?php echo CHtml::image('images/password_48.png', ''); ?> Change Password</h1>

<p>You can change your password here. It will be changed immediately.</p>

<hr>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'changepassword-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php //echo Yii::app()->user->getState('email'); ?> </br>

<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span5', 'maxlength' => 250)); ?>

<?php echo $form->passwordFieldRow($model, 'repeat_password', array('class' => 'span5', 'maxlength' => 250)); ?>

<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Change password',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>