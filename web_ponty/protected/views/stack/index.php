<?php
$this->breadcrumbs = array(
    'Stacks',
);
?>

<h1><?php echo CHtml::image('images/stack_48.png', ''); ?>
    Stacks  <div class="pull-right">
        <?php echo CHtml::link('<button class="btn btn-large" type="button">' . CHtml::image('images/import_32.png') . ' &nbsp;&nbsp;Import Stack</button>', array('stack/importStack')) ?>
        <?php echo CHtml::link('<button class="btn btn-large" type="button">' . CHtml::image('images/add_32.png') . ' &nbsp;&nbsp;New Stack</button>', array('stack/newStack')) ?></div> </h1>
<hr>
<br>

<?php
foreach ($stacks as $stack) {
    ?>
    <div class="well well-large" style="padding-top: 0px; padding-left: 0px ; padding-right: 0px; margin-bottom: 50px">
        <div class="alert alert-info" style="margin: 0px; margin-bottom: 10px">
            <b><a  rel="tooltip" data-container="body" data-placement="right" title="<?php echo $stack->description ?>"><?php echo $stack->name ?></a></b>
            <div class="pull-right">
                <?php
                if ($stack->public) {
                    echo "Share your stack with this code: ". $stack->publickey. "&nbsp;&nbsp;&nbsp;   ";
                    echo CHtml::link('<span class="label label-info">Unshare</span>', array('stack/switchStackPublicPrivate', 'id' => $stack->id));
                } else {
                    echo CHtml::link('<span class="label label-info">Share now</span>', array('stack/switchStackPublicPrivate', 'id' => $stack->id));
                }
                ?>
            </div>
        </div>
        <div style="margin: 10px;">
            <?php if (count($stack->questions) == 0) { ?>
                <h6>There are no questions!</h6>
            <?php } else { ?>
                <table class="table table-striped">
                    <tr>
                        <th>Question</th>
                        <th style="text-align:center">Category</th>
                        <th style="text-align:center">Visibility</th>
                        <th style="text-align:center">Answers</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                    <?php foreach ($stack->questions as $question) { ?>
                        <tr>
                            <td style="word-break:break-all;word-wrap:break-word">
                                <?php
                                echo CHtml::link($question->name, array('answer/index', 'questionID' => $question->id));
                                // echo $question->name
                                ?>
                            </td> 

                            <td style="text-align:center;word-break:break-all;word-wrap:break-word"><?php echo (is_null($question->category)) ? '-' : $question->category->name ?></td>
                            <td style="text-align:center"><?php
                                ($question->public == 1) ? $label = 'public' : $label = 'private';
                                $this->widget('bootstrap.widgets.TbLabel', array(
                                    'type' => 'default', // 'success', 'warning', 'important', 'info' or 'inverse'
                                    'label' => $label,
                                ));
                                ?></td>
                            <td style="text-align:center">
                                <?php
                                $this->widget('bootstrap.widgets.TbBadge', array(
                                    'type' => 'success', // 'success', 'warning', 'important', 'info' or 'inverse'
                                    'label' => $question->answerCount(),
                                ));
                                ?>
                            </td>
                            <td style="text-align:right">
                                <?php
                                echo CHtml::link(
                                        '<button class="btn btn-mini" type="button"><i class="icon-edit"></i></button>', array('question/editQuestion', 'id' => $question->id))
                                ?>
                                <?php
                                echo CHtml::link(
                                        '<button class="btn btn-mini" type="button"><i class="icon-remove-sign"></i></button>', array('question/deleteQuestion', 'id' => $question->id), array('confirm' => 'Would you like to perforam removing the Queston from Stack "' . $stack->name . '"?' . "\n" . 'There is no way back!'))
                                ?>

                            </td>
                        </tr>
                    <?php } ?>

                </table>
            <?php } ?>
        </div>
        <div class="pull-right">
            <div class="btn-toolbar" style="margin: 10px">
                <div class="btn-group">

                    <?php
                    echo CHtml::link(
                            '<button class="btn">' . CHtml::image('images/add_16.png') . ' Add Question</button>', array('question/addQuestion', 'stackId' => $stack->id))
                    ?>

                    <?php
                    echo CHtml::link(
                            '<button class="btn">' . CHtml::image('images/edit_16.png') . ' Edit Stack</button>', array('stack/editStack', 'id' => $stack->id))
                    ?>
                    <?php
                    echo CHtml::link(
                            '<button class="btn">' . CHtml::image('images/delete_16.png') . ' Delete Stack</button>', array('stack/deleteStack', 'id' => $stack->id), array('confirm' => 'Would you like to perforam removing "' . $stack->name . '"?' . "\n" . 'Please keep in mind that all questions and answers will be also delted!'))
                    ?>
                    );

                </div>
            </div>
        </div>
    </div> 
    <?php
}
?>
