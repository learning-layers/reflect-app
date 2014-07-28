<?php
$this->breadcrumbs = array(
    'Admin Menu',
);
?>

<h1>Admin Dashboard</h1>
<hr>
<br>

<table class="table table-bordered">
    <tr>
        <td ><i class="icon-user"></i> <span class="badge badge-info"><?php echo User::model()->count() ?></span> User</td>
        <td ><i class="icon-th-list"></i> <span class="badge badge-info"><?php echo Stack::model()->count() ?></span> Stacks</td>
        <td><i class="icon-question-sign"></i> <span class="badge badge-info"><?php echo Question::model()->count() ?></span> Questions</td>
        <td><i class="icon-list"></i> <span class="badge badge-info"><?php echo Answer::model()->count() ?></span> Answers</td>
    </tr>
</table>