<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Add question';
$this->breadcrumbs = array(
    'Add question',
);
?>

<h1><?php echo CHtml::image('images/question_48.png', ''); ?> Add question
<div class="pull-right"><?php echo CHtml::link('<button class="btn btn-large" type="button">'.CHtml::image('images/publicquestion_48.png', '').' &nbsp;&nbsp;Public Questions</button>', array('question/publicQuestions')) ?></div> </h1>

</h1>

<p>Here you can add to the selected stack a question</p>

<hr>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'questionadd-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaRow($model, 'name', array('class' => 'span8', 'maxlength' => 250, 'rows' => 5)); ?>

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
        'label' => 'Add Question',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>