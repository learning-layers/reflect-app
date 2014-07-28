<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Category','url'=>array('index')),
	array('label'=>'Create Category','url'=>array('create')),
	array('label'=>'Update Category','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Category','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Category','url'=>array('admin')),
);
?>
  <h1> <?php echo CHtml::image('images/categories_48.png', ''); ?> View Category #<?php echo $model->id; ?> </h1>
<hr>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'visible',
		'description',
		'created',
	),
)); ?>
