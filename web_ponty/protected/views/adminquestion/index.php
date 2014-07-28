<?php
$this->breadcrumbs=array(
	'Questions',
);

$this->menu=array(
	array('label'=>'Create Question','url'=>array('create')),
	array('label'=>'Manage Question','url'=>array('admin')),
);
?>

<h1>Questions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
