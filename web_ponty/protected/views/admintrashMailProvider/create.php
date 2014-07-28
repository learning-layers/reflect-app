<?php
$this->breadcrumbs=array(
	'Trash Mail Providers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TrashMailProvider','url'=>array('index')),
	array('label'=>'Manage TrashMailProvider','url'=>array('admin')),
);
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> Add TrashMailProvider</h1>
<hr>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>