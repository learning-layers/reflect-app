<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Category','url'=>array('index')),
	array('label'=>'Manage Category','url'=>array('admin')),
);
?>

  <h1> <?php echo CHtml::image('images/categories_48.png', ''); ?> Create Category </h1>
<hr>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>