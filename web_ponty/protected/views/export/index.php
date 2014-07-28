<?php
$this->breadcrumbs = array(
    'Export',
);
?>

<h1><?php echo CHtml::image('images/export_48.png', ''); ?> Export wizard </h1>
<hr>
<br>

<table class="table table-striped">
    <tr>
        <th><?php echo CHtml::image('images/stack_16.png', ''); ?> Stack</th>
        <th width="20%" style="text-align:center"><?php echo CHtml::image('images/question_16.png', ''); ?>  Questions</th>
        <th width="20%" style="text-align:right">Export as</th>
    </tr>
    <?php foreach ($stacks as $stack) { ?>
        <tr>
            <td style="word-break:break-all;word-wrap:break-word"><?php echo $stack->name ?></td> 
            <td style="text-align:center;word-break:break-all;word-wrap:break-word"><span class="badge badge-info"><?php echo Question::model()->count('stack_id=:stack_id', array('stack_id' => $stack->id)) ?></span></td>

            <td style="text-align:right">
                <?php
                echo CHtml::link(
                        '<button class="btn btn-mini" type="button">' . CHtml::image('images/txt_16.png', '') . ' *.txt</button>', array('export/exporttxt', 'id' => $stack->id))
                ?>
                <?php
                echo CHtml::link(
                        '<button class="btn btn-mini" type="button">' . CHtml::image('images/mail_16.png', '') . ' E-Mail</button>', array('export/exportMail', 'stackID' => $stack->id))
                ?>
            </td>
        </tr>
    <?php } ?>

</table>

