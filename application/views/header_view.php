<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>MD</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dashboard for monit servers">
        <meta name="author" content="R.P. Neeleman">
		<?php if (strpos(uri_string(), 'servers/overview') || strpos(uri_string(), 'logbook/view') !== false ) { ?>
		<meta http-equiv="refresh" content="30">
		<?php } ?>

        <!-- Bootstrap -->
        <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

        <style>
        body {
            padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
        }
        </style>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.png">

    </head>

<body>
