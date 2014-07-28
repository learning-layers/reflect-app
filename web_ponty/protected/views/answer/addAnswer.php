<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Add answer';
$this->breadcrumbs = array(
    'Add answer',
);
?>

<h1><?php echo CHtml::image('images/answer_48.png', ''); ?> Add answer</h1>

<p>Here you can add to the selected question a answer</p>

<hr>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'answeradd-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaRow($model, 'text', array('class' => 'span8', 'rows' => 8)); ?>


<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Add Answer',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>