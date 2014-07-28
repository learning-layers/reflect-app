<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/users_48.png', ''); ?> Create User </h1>
<hr>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>