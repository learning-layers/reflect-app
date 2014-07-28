<?php
$this->breadcrumbs=array(
	'Trash Mail Providers',
);

$this->menu=array(
	array('label'=>'Create TrashMailProvider','url'=>array('create')),
	array('label'=>'Manage TrashMailProvider','url'=>array('admin')),
);
?>

<h1>Trash Mail Providers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
