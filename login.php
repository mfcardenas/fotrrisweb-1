<?php

require_once 'includes/register.inc.php';
require_once 'includes/functions.php';
require_once 'core/Combo.php';
require_once 'includes/translate.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
<head>

    <title>FoTRRIS Login </title>
    <?php include("section/sincl_html.php"); ?>
    <link rel="stylesheet" href="css/util.css"/>

    <script>
        $(function () {
            $('#login-form-link').click(function (e) {
                $("#login-form").delay(100).fadeIn(100);
                $("#registration_form").fadeOut(100);
                $('#register-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
            $('#register-form-link').click(function (e) {
                $("#registration_form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                $('#login-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
        });
    </script>
</head>
<body>

<header>
    <?php include("section/sincl_header.php"); ?>
</header>

<section>
    <div id="headerwrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <?php if (isset($_GET['sec'])) { ?>
                                    <?php if ($_GET['sec'] == 'register') { ?>
                                        <script>
                                            $(document).ready(function () {
                                                $('#register-form-link').click();
                                            });
                                        </script>
                                    <?php } ?>

                                    <?php if ($_GET['sec'] == 'login') { ?>
                                        <script>
                                            $(document).ready(function () {
                                                $('#login-form-link').click();
                                            });
                                        </script>
                                    <?php } ?>
                                <?php } ?>
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link"><?php echo _("Login"); ?> </a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link"><?php echo _("Register"); ?> </a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" action="includes/process_login.php" method="post" role="form" style="display: block;">
                                        <?php if (isset($_GET['key'])) { ?>
                                            <div class="form-group">
                                                <?php echo getNotification($_GET['key'], $_GET['type']); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <input type="text" name="email" id="email" tabindex="1" class="form-control"
                                                   placeholder="<?php echo _("email"); ?>" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2"
                                                   class="form-control" placeholder="<?php echo _("Password"); ?>">
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> <?php echo _("Remember Me"); ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login-submit" id="login-submit"
                                                           tabindex="4" class="form-control btn btn-login"
                                                           value="<?php echo _("LOG IN"); ?>"
                                                           onclick="formhash(this.form, this.form.password);">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <!--<a href="#" tabindex="5" class="forgot-password">Forgot
                                                            Password?</a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="registration_form" action="login.php" method="POST" role="form"
                                          style="display: none;" enctype="multipart/form-data">
                                        <?php if (isset($_GET['key'])) { ?>
                                            <div class="form-group">
                                                <?php echo getNotification($_GET['key'], $_GET['type']); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="<?php echo _("Full Name"); ?>" value=""/>
                                            <input type="hidden" id="sn_active" name="sn_active" value="S"/>
                                            <input type="hidden" id="gaction" name="gaction" value="Create"/>
                                            <input type="hidden" id="userapp" name="userapp" value="userweb"/>
                                            <input type="hidden" id="id" name="id" value=""/>

                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="2"
                                                   class="form-control" placeholder="<?php echo _("Username"); ?>" value=""/>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" tabindex="3"
                                                   class="form-control" placeholder="<?php echo _("Email Address"); ?>" value=""/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="5"
                                                   class="form-control" placeholder="<?php echo _("Password"); ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirmpwd" id="confirmpwd" tabindex="6"
                                                   class="form-control" placeholder="<?php echo _("Confirm Password"); ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="imgpicture"><?php echo _("Picture?"); ?> </label>
                                            <input type="file" name="imgpicture" id="imgpicture" tabindex="7" alt="Upload a picture (1MB Max.)"
                                                   title="Upload a picture (1MB Max.)" />
                                            <p class="help-block"> <?php echo _("Upload a picture"); ?> (1MB Max.)</p>
                                            <input type="hidden" name="perfil" id="perfil" value="1"/>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit"
                                                           tabindex="7" class="form-control btn btn-register"
                                                           value="<?php echo _("Register Now"); ?>"
                                                           onclick="return regformhash(this.form,
                                                                                   this.form.name,
                                                                                   this.form.username,
                                                                                   this.form.email,
                                                                                   this.form.password,
                                                                                   this.form.confirmpwd,
                                                                                   this.form.imgpicture,
                                                                                   this.form.perfil,
                                                                                   this.form.sn_active,
                                                                                   this.form.gaction,
                                                                                   this.form.id,
                                                                                   this.form.userapp);"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                if (!empty($error_msg)) {
                    echo $error_msg;
                }
                ?>
            </div>
        </div>
    </div>
</section>
<footer>
    <?php include("section/sincl_footer.php"); ?>
</footer>
</body>
</html>
