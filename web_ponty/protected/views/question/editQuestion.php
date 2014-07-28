<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Edit question';
$this->breadcrumbs = array(
    'Edit question',
);
?>


<h1><?php echo CHtml::image('images/question_48.png', ''); ?> Edit question</h1>

<p>Here you can edit to the selected question</p>

<hr>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'editquestion-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaRow($model, 'name', array('class' => 'span8', 'maxlength' => 250, 'rows'=> 5)); ?>

<?php
//echo $form->textFieldRow($model, 'freistich_id', array('prepend' => '#', 'class' => 'span1')); 
// START CC
$cCategory = new CDbCriteria;
$cCategory->select = 'id,name';
$cCategory = Category::model()->findAll($cCategory);
echo $form->dropDownListRow($model, 'category_id', CHtml::listData($cCategory, 'id', 'name'), array('prompt' => 'no category', 'class' => 'span5'));
// END CC
?>

<?php echo $form->checkboxRow($model, 'public'); ?>

<p class="help-block"><span class="required">*</span> are required fields.</p>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Update Question',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>