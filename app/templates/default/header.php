<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $data['title'].' - '.SITETITLE; //SITETITLE defined in index.php?></title>
    <link href="<?php echo \helpers\url::get_template_path();?>css/foundation/normalize.css" rel="stylesheet">
    <link href="<?php echo \helpers\url::get_template_path();?>css/foundation/foundation.min.css" rel="stylesheet">
    <link href="<?php echo \helpers\url::get_template_path();?>css/jqueryui/jquery-ui.min.css" rel="stylesheet">
	<link href="<?php echo \helpers\url::get_template_path();?>css/style.css?<?php // echo 'a' . rand(1,100000); ?>" rel="stylesheet">
	<link href="<?php echo \helpers\url::get_template_path();?>css/atari2600.css?<?php // echo 'a' . rand(1,100000); ?>" rel="stylesheet">
	<link href="<?php echo \helpers\url::get_template_path();?>css/font-awesome.min.css" rel="stylesheet">

    <script src="<?php echo \helpers\url::get_template_path();?>js/vendor/jquery.js"></script>
    <script src="<?php echo \helpers\url::get_template_path();?>js/jqueryui/jquery-ui.min.js"></script>
    <script src="<?php echo \helpers\url::get_template_path();?>js/vendor/modernizr.js"></script>
    <script src="<?php echo \helpers\url::get_template_path();?>js/vendor/placeholder.js"></script>
    <script src="<?php echo \helpers\url::get_template_path();?>js/foundation/foundation.js"></script>
    <script src="<?php echo \helpers\url::get_template_path();?>js/main.js"></script>

</head>
<body>

<header class="layout-header">
    <div class="row">
        <div class="small-12 medium-4 columns">
            <h1><a href="<?php echo DIR ?>"><?php echo SITETITLE; ?></a></h1>
        </div><div class="small-12 medium-8 columns">
            <?php
                $navigation = new \core\view;
                $navigation->rendertemplate('navigation');
            ?>
        </div>
    </div>
</header>

<section class="layout-content">
    <div class="row">
        <div class="small-12 columns">
