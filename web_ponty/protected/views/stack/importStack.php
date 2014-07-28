<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Import stack';
$this->breadcrumbs = array(
    'Import stack',
);
?>


<h1><?php echo CHtml::image('images/import_48.png', ''); ?> Import stack</h1>

<p>Here you can import a Stack via input a public stack key.</p>

<hr>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'stackimport-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'publickey', array('class' => 'span5', 'maxlength' => 250)); ?>

<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Import Stack',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>