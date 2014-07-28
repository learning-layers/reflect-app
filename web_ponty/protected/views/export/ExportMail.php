<?php
$this->breadcrumbs = array(
    'Export Mail',
);
?>

<h1><?php echo CHtml::image('images/mail_48.png', ''); ?> Export via sending a mail</h1>
<hr>
<br>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'mailnow',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 250)); ?>

<?php echo $form->textFieldRow($model, 'subject', array('class' => 'span5', 'maxlength' => 250)); ?>

<?php echo $form->textAreaRow($model, 'body', array('class' => 'span8', 'rows' => 10)); ?>

<?php echo $form->textAreaRow($model, 'stack', array('class' => 'span8', 'rows' => 10, 'disabled' => true)); ?>

<?php echo '<input type=hidden id="stackid" name="stackid" value="">' ?>


<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Send now',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

