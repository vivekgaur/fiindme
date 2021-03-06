<?php
/* @var $this DealController */
/* @var $model Deal */

$this->breadcrumbs=array(
	'Deals'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Deal', 'url'=>array('index')),
	array('label'=>'Create Deal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#deal-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Deals</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'deal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'deal_id',
		array('name'=>'merchant_id_fk', 'header'=>'Merchant', 'value'=>'$data->merchantIdFk->contactIdFk->addressIdFk->company'),
		'title',
		'description',
		/*'create_time',
		'last_update',
		*/
		'start_time',
		'end_time',
		'quantity',
		'status',
		'discount',
                /*
		'user_analytics_id_fk',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
