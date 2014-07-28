<?php
$this->breadcrumbs=array(
	'Trash Mail Providers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TrashMailProvider','url'=>array('index')),
	array('label'=>'Create TrashMailProvider','url'=>array('create')),
	array('label'=>'Update TrashMailProvider','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TrashMailProvider','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TrashMailProvider','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> View TrashMailProvider #<?php echo $model->id; ?></h1>
<hr>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'address',
	),
)); ?>
