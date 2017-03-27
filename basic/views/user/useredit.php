<?php
\yii\widgets\Pjax::begin();
?>
    <div class="col-md-2">
        <!-- CONTENT LEFT SIDEBAR START --------------------------------------------------------------------------------------->
        <?php include 'useredit_subfiles/useredit_sidebar_left.php'; ?>
        <!-- CONTENT LEFT SIDEBAR END ----------------------------------------------------------------------------------------->
    </div>
    <div class="col-md-8">
        <!-- CONTENT MAIN START ----------------------------------------------------------------------------------------------->
        <?php include 'useredit_subfiles/useredit_maincontent.php'; ?>
        <!-- CONTENT MAIN END ------------------------------------------------------------------------------------------------->
    </div>
    <div class="col-md-2">
        <!-- OPTIONAL RIGHT SIDEBAR START ------------------------------------------------------------------------------------->
        <?php include 'useredit_subfiles/useredit_sidebar_right.php'; ?>
        <!-- OPTIONAL RIGHT SIDEBAR END --------------------------------------------------------------------------------------->
    </div>
<?php
\yii\widgets\Pjax::begin();
?>