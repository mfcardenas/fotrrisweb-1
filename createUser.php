<?php

    require_once 'includes/functions.php';

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
        <title>FoTRRIS User </title>
        <?php include("section/sincl_html.php"); ?>
        <link rel="stylesheet" href="css/util.css" />
    </head>
    <body>
        
        <header>
            <?php include("section/sincl_header.php"); ?>
        </header>

        <?php if (login_check($mysqli) == true) : ?>
            <div id="bar_top">
                <div class="container">
                    <div class="row">
                        <h1></h1>
                    </div>
                    <div class="row">
                        <h1><small><?php echo _($action); ?></small> <?php echo _("User"); ?></h1>
                    </div>
                </div>
            </div>
            <section>
                <div id="headerwrap-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                foreach ($keys as $key){
                                    echo getNotification($key, null )."<br/>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <form data-toggle="validator" class="form-horizontal" action="<?php if ($action == 'Create') { echo $helper->url('user','create');} else {echo $helper->url('user','update');} ?>" method="post" role="form" enctype="multipart/form-data">
                                <input type="hidden" id="gaction" name="gaction" value="<?php echo $action;?>"/>
                                <div class="form-group">
                                    <label for="name" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input type="hidden" id="id" name="id" value="<?php echo $user->getId();?>"/>
                                        <input type="hidden" id="userapp" name="userapp" value="<?php echo htmlentities($_SESSION['username']); ?>"/>
                                        <input required type="text" class="form-control" id="name" name="name" placeholder="<?php echo _("Name"); ?>" value="<?php echo $user->getName(); ?>" tabindex="1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="control-label col-xs-3"><?php echo _("Username"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" id="username" name="username" placeholder="<?php echo _("Username"); ?>" value="<?php echo $user->getUsername(); ?>" tabindex="2" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label col-xs-3"><?php echo _("email"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="email" class="form-control" id="email" name="email" placeholder="<?php echo _("email"); ?>" value="<?php echo $user->getEmail(); ?>" tabindex="3" data-error="This email address is invalid"/>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <?php if ($action == 'Create') { ?>
                                    <div class="form-group">
                                        <label for="password" class="control-label col-xs-3"><?php echo _("Password"); ?>:*</label>
                                        <div class="col-xs-9">
                                            <input required data-minlength="6" type="password" class="form-control" placeholder="<?php echo _("Password"); ?>" id="password" name="password" value="<?php echo $user->getPassword(); ?>" tabindex="4"/>
                                            <div class="help-block"><?php echo _("Minimum of 6 characters"); ?></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpwd" class="control-label col-xs-3"><?php echo _("Confirm Password"); ?>:*</label>
                                        <div class="col-xs-9">
                                            <input required type="password" name="confirmpwd" id="confirmpwd" class="form-control" placeholder="<?php echo _("Confirm Password"); ?>" tabindex="5" value="<?php echo $user->getPassword(); ?>" data-match="#password" data-match-error="Whoops, these don't match"/>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="id_perfil" class="control-label col-xs-3"><?php echo _("Profile"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select name="id_perfil" id="id_perfil" tabindex="6">
                                            <?php echo $combo->getPerfiles($user->getIdPerfil(), false); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sn_active" class="control-label col-xs-3"><?php echo _("Status"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select name="sn_active" id="sn_active" tabindex="6">
                                            <?php echo $combo->getStatus($user->getSnActive(), false); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php if ($action == 'Create') { ?>
                                        <label for="image" class="control-label col-xs-3"><?php echo _("Picture?"); ?></label>
                                        <div class="col-xs-9">
                                            <input type="file" name="image" id="image" tabindex="7" alt="Upload a picture about you... (1MB Max.)"
                                                   title="Upload a picture about you... (1MB Max.)" class="form-control"/>
                                            <p class="help-block"><?php echo _("Upload a picture about you..."); ?>(1MB Max.)</p>
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" id="image" name="image" value="" />
                                    <?php } ?>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="10" class="btn btn-primary" value="<?php echo $action; ?>"
                                               onclick="return regformhash(this.form,
                                                               this.form.name,
                                                               this.form.username,
                                                               this.form.email,
                                                               this.form.password,
                                                               this.form.confirmpwd,
                                                               this.form.image,
                                                               this.form.id_perfil,
                                                               this.form.sn_active,
                                                               this.form.gaction,
                                                               this.form.id,
                                                               this.form.userapp);"
                                               />
                                        <input type="reset" class="btn btn-default" value="<?php echo _("Clear"); ?>" tabindex="11"/>
                                    </div>
                                    <div class="col-xs-offset-10">
                                        <a class="btn btn-default " role="button" href="<?php echo $helper->url('user', 'index'); ?>"><?php echo _("Back"); ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <?php include("section/sincl_404.php"); ?>
        <?php endif; ?>
        <footer>
            <?php include("section/sincl_footer.php"); ?>
        </footer>
    </body>
</html>
