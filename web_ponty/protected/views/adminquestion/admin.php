<?php
$this->breadcrumbs = array(
    'Questions' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Question', 'url' => array('index')),
    array('label' => 'Create Question', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('question-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> Manage Public Questions </h1>
<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<hr>
<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'question-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
        array('name' => 'public', 'value' => '($data->public)? "Yes" : "No"'),
        array('name' => 'blocked', 'value' => '($data->blocked)? "Yes" : "No"'),
        array('name'=>'category_id','value' => '($data->category_id!=null)? Category::model()->findByPk($data->category_id)->name : "No Category"'),
        
            'rating',
         
          'created',
         
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
