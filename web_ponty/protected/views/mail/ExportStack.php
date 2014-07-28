<?php
echo $model->body;

echo "</br></br></br>The exported answers are below: </br></br></br>";

echo $model->stack;
?>
</br>
--------------------------------------------------------------------------</br>
This E-Mail was sent by <?php echo Yii::app()->user->getState('email') ?>
