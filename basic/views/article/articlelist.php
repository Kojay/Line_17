<?php
    \yii\widgets\Pjax::begin();
?>
    <div class="col-md-2">
        <!-- CONTENT LEFT SIDEBAR START --------------------------------------------------------------------------------------->
        <?php include 'articlelist_subfiles/articlelist_sidebar_left.php'; ?>
        <!-- CONTENT LEFT SIDEBAR END ----------------------------------------------------------------------------------------->
    </div>
    <div class="col-md-8">
        <!-- CONTENT MAIN START ----------------------------------------------------------------------------------------------->
        <?php include 'articlelist_subfiles/articlelist_maincontent.php'; ?>
        <!-- CONTENT MAIN END ------------------------------------------------------------------------------------------------->
    </div>
    <div class="col-md-2">
        <!-- OPTIONAL CONTENT RIGHT SIDEBAR START ----------------------------------------------------------------------------->
        <?php include 'articlelist_subfiles/articlelist_sidebar_right.php'; ?>
        <!-- OPTIONAL CONTENT RIGHT SIDEBAR END ------------------------------------------------------------------------------->
    </div>
<?php
    \yii\widgets\Pjax::begin();
?>