<?php
$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Question','url'=>array('index')),
	array('label'=>'Create Question','url'=>array('create')),
	array('label'=>'Update Question','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Question','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Question','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> View Question #<?php echo $model->id; ?></h1>
<hr>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'public',
		'name',
		'blocked',
		'stack_id',
		'category_id',
		'rating',
		'created',
	),
)); ?>
