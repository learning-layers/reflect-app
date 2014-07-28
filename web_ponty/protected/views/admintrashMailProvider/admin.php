<?php
$this->breadcrumbs=array(
	'Trash Mail Providers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TrashMailProvider','url'=>array('index')),
	array('label'=>'Create TrashMailProvider','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trash-mail-provider-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo CHtml::image('images/trashmail_48.png', ''); ?> Manage Trash Mail Providers <div class="pull-right"><?php echo CHtml::link('<button class="btn btn-large" type="button">'.CHtml::image('images/add_32.png').' &nbsp;&nbsp;New Trashmailprovider</button>', array('admintrashMailProvider/create')) ?></div></h1>
<br>
<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<hr>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'trash-mail-provider-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'address',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
