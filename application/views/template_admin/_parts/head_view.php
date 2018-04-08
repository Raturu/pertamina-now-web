<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_title; ?></title>

  <!--Favicon-->

  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/dist/img/favicon/icon.png');?>"/>
  <meta property="og:url" content="<?=base_url();?>" />
  <meta property="og:image" content="<?=base_url();?>assets/dist/img/nokia_logo_white.png" />
  <meta name="theme-color" content="#ffffff">


  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css')?>">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/flat/blue.css')?>"> 
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/select.dataTables.min.css')?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .dataTables_filter input { height: 23px }
    .dataTables_length select { height: 25px }
    .box-header {height: 32px; margin-top: -5px;}
    .inner-container::-webkit-scrollbar { /*google chrome*/
     display: none;
    }
    .inner-container { -ms-overflow-style: none; } /*internet explorer*/
    .inner-container { overflow: -moz-scrollbars-none; }
  </style>
</head>