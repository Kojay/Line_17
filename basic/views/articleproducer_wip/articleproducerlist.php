<?php
    \yii\widgets\Pjax::begin();


    echo '<h1>test</h1>';
?>
    <div class="col-md-2">
        <!-- CONTENT LEFT SIDEBAR START --------------------------------------------------------------------------------------->
        <?php include 'articleproducerlist_subfiles/articleproducerlist_sidebar_left.php'; ?>
        <!-- CONTENT LEFT SIDEBAR END ----------------------------------------------------------------------------------------->
    </div>
    <div class="col-md-8">
        <!-- CONTENT MAIN START ----------------------------------------------------------------------------------------------->
        <?php include 'articleproducerlist_subfiles/articleproducerlist_maincontent.php'; ?>
        <!-- CONTENT MAIN END ------------------------------------------------------------------------------------------------->
    </div>
    <div class="col-md-2 bodyright">
        <!-- OPTIONAL CONTENT RIGHT SIDEBAR START ----------------------------------------------------------------------------->
        <?php include 'articleproducerlist_subfiles/articleproducerlist_sidebar_right.php'; ?>
        <!-- OPTIONAL CONTENT RIGHT SIDEBAR END ------------------------------------------------------------------------------->
    </div>
<?php
    \yii\widgets\Pjax::begin();
?>