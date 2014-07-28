<?php
$this->breadcrumbs=array(
	'Trash Mail Providers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TrashMailProvider','url'=>array('index')),
	array('label'=>'Create TrashMailProvider','url'=>array('create')),
	array('label'=>'View TrashMailProvider','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TrashMailProvider','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> Update TrashMailProvider #<?php echo $model->id; ?></h1>
<hr>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>