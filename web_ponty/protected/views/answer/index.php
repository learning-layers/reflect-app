<?php
$this->breadcrumbs = array(
    'Answers',
);
?>

<h1><?php echo CHtml::image('images/answer_48.png', ''); ?> Answers  <div class="pull-right"><?php echo CHtml::link('<button class="btn btn-large" type="button">'.CHtml::image('images/add_32.png').' &nbsp;&nbsp;New Answer</button>', array('answer/addAnswer', 'questionId' => $question->id)) ?></div> </h1>
<hr>
<br>

<div class="well well-large">
    <?php echo $question->name ?>   
</div>



<table class="table table-striped">
    <tr>
        <th>Answer</th>
        <th width="20%" style="text-align:center">Created</th>
        <th width="20%">Actions</th>
    </tr>
    <?php foreach ($answers as $answer) { ?>
        <tr>
            <td style="word-break:break-all;word-wrap:break-word"><?php echo $answer->text ?></td> 
            <td style="text-align:center;word-break:break-all;word-wrap:break-word"><?php echo $answer->created; ?></td>

            <td>
                <?php
                echo CHtml::link(
                        '<button class="btn btn-mini" type="button"><i class="icon-edit"></i> edit</button>', array('answer/editAnswer', 'id' => $answer->id))
                ?>
                <?php
                echo CHtml::link(
                        '<button class="btn btn-mini" type="button"><i class="icon-remove-sign"></i> remove</button>', array('answer/deleteAnswer', 'id' => $answer->id), array('confirm' => 'Would you like to perforam removing the selected answer?"'. "\n" . 'There is no way back!'))
                ?>

            </td>
        </tr>
    <?php } ?>

</table>

