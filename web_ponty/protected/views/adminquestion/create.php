<?php
$this->breadcrumbs=array(
	'Questions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Question','url'=>array('index')),
	array('label'=>'Manage Question','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> Create Question</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>