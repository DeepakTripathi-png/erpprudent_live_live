<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Login | <?php echo project_name; ?></title>
    <base href="<?php echo base_url(); ?>" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/pages/css/login-3.min.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
</head>
<body class="login">
	<div class="logo">
        <img src="<?php echo base_url(); ?>uploads/images/logo2.png" alt="" style="width:250px;"> 
    </div>
	<div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="chk_login" id="chk_login" method="post">
            <h3 class="form-title">Login to your account</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter username and password. </span>
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
            </div>
            <div class="form-actions" style="border-bottom: 0px solid #eee;">
                <label class="rememberme mt-checkbox mt-checkbox-outline"></label>
                <button type="submit" class="btn green pull-right chk_login"> Login <i class='fa fa-arrow-circle-right'></i></button>
            </div>
        </form>
    </div>
	<div class="copyright" style="color: #fff;">
		 <?php echo date('Y')?> &copy; Prudent EPC 
	</div>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/common.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
</body>
</html>