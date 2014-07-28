<?php
$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Question','url'=>array('index')),
	array('label'=>'Create Question','url'=>array('create')),
	array('label'=>'View Question','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Question','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> Update Question #<?php echo $model->id; ?></h1>
<hr>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>