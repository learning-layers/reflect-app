<?php
if ($category == null || $category == 'TOP10') {
    $tablename = 'TOP 10 - Questions';
} else if ($category == "nocat") {
    $tablename = "No Category";
} else {
    $tablename = Category::model()->findByPk($category)->name;
}
?>

<h1><?php echo CHtml::image('images/publicquestion_48.png', ''); ?> Public Questions </h1>

<hr>

<form method='get' class="form-search" action="<?php echo CController::createUrl("question/publicQuestions"); ?>">
    <input type="hidden" name="r" value="question/publicQuestions">
    <div class="input-prepend input-append">
        <span class="add-on">Category </span><select name='category' class="span5" onChange="this.form.submit()">
            <?php
            if ($category == null || $category == 'TOP10') {
                echo "<option value='TOP10' selected='selected'>TOP 10</option>";
            } else {
                echo "<option value='TOP10'>TOP 10</option>";
            }
            $categories = Category::model()->findAll();
            foreach ($categories as $cat) {
                if ($cat->id == $category) {
                    $selected = "selected='selected'";
                } else {
                    $selected = '';
                }
                echo "<option value='" . $cat->id . "'" . $selected . ">" . $cat->name . "</option>";
            }
            if ($category == "nocat") {
                echo "<option value='nocat' selected='selected'>No Category</option>";
            } else {
                echo "<option value='nocat'>No Category</option>";
            }
            ?>
        </select>
    </div>
</form>



<div class="well well-large" style="padding-top: 0px; padding-left: 0px ; padding-right: 0px; margin-bottom: 50px">
    <div class="alert alert-info" style="margin: 0px; margin-bottom: 10px">
        <b><a  rel="tooltip" data-container="body" data-placement="right" title="<?php echo $tablename ?>"><?php echo CHtml::image('images/question_16.png', ''); ?><?php echo ' ' . $tablename ?></a></b>
    </div>
    <div style="margin: 10px;">
        <?php if (count($questions) == 0) { ?>
            <h6>There are no questions!</h6>
        <?php } else { ?>
            <table class="table table-striped">
                <tr>
                    <th width='70%'>Question</th>
                    <th style="text-align:left">Rating</th>
                    <?php if (Yii::app()->user->getState('stackid') > 0) { ?>
                        <th style="text-align:right">Actions</th>
                    <?php } ?>
                </tr>
                <?php foreach ($questions as $question) { ?>
                    <tr>
                        <td style="word-break:break-all;word-wrap:break-word">

                            <?php
                            echo $question->name;
                            ?>
                        </td> 


                        <td style="align:center">

                            <?php
                            // rating
                            $this->widget('CStarRating', array(
                                'name' => 'rating' . $question->id, // an unique name
                                'starCount' => 5,
                                'readOnly' => Yii::app()->user->isGuest,
                                'allowEmpty' => false,
                                'resetText' => '',
                                'value' => round($question->rating, 0), // this makes the widget shows the current rating rounded to //closest number(1,2,3,4,5,6,7,8,9 or 10)
                                'callback' => ' // updates the div with the new rating info, displays a message for 5 seconds and makes the //widget readonly
        function(){
                url = "index.php?r=question/rating";
                        jQuery.getJSON(url, {id: ' . $question->id . ', val: $(this).val()}, function(data) {
                                if (data.status == "success"){
                                        $("#rating_success_' . $question->id . '").html(data.div);
                                        $("#rating_success_' . $question->id . '").fadeIn("slow");               
                                        var pause = setTimeout("$(\"#rating_success_' . $question->id . '\").fadeOut(\"slow\")",3000);
                                        $("#rating_info_' . $question->id . '").html(data.info);
                                        $("input[id*=' . $question->id . '_]").rating("readOnly",true);
                                        }
                                });}'
                            ));
                            ?>      

                            <div  id="rating_info_<?= $question->id ?>">
                                <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $question->rating_count . ' votes' ?>
                            </div>

                            <div id="rating_success_<?= $question->id; ?>" style="display:none"></div>

                        </td>
                        <?php if (Yii::app()->user->getState('stackid') > 0) { ?>
                            <td style="text-align:right">
                                <?php
                                if (Yii::app()->user->getState('stackid') > 0) {
                                    echo CHtml::link(
                                            '<button class="btn btn-mini" type="button"><i class="icon-share-alt"></i> use</button>', array('question/addQuestion', 'stackId' => Yii::app()->user->getState('stackid'), 'questionid' => $question->id));
                                }
                                ?>

                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php } ?>

            </table>
        <?php } ?>
    </div>



