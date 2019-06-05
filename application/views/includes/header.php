<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        ANW Learning
        <?php
            if (isset($title)) {
                echo $title;
            }
        ?>
    </title> 
    
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/materialize/css/materialize.min.css" media="screen,projection" />
    <!-- Bootstrap Styles-->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="<?php echo base_url(); ?>assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="<?php echo base_url(); ?>assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/Lightweight-Chart/cssCharts.css"> 

    <!--script src="<?php // echo base_url(); ?>assets/js/moment.js"></script-->
	
	<link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	
    <script>
        var baseurl = '<?php echo base_url(); ?>';
    </script>
    
    <link rel='stylesheet' href='<?php echo base_url()."style/global.style.css" ?>'/>
    <?php 
        if (isset($headscript) && isset($headscript['style'])) {
            foreach($headscript['style'] as $st) {
                echo "<link rel='stylesheet' href='".$st."'/>";
            }
        }
    ?>
</head>
<body>
 <div id="wrapper">
    <div id="root" style='color:#fff;'></div>