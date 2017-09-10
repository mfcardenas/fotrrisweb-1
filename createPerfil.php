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
        <meta charset="UTF-8">
        <title>FoTRRIS Profiles </title>
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
                        <h1><small><?php echo $action; ?></small> <?php echo _("Profile"); ?></h1>
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
                            <form data-toggle="validator" class="form-horizontal" action="<?php if ($action == 'Create') { echo $helper->url('perfil','create');} else {echo $helper->url('perfil','update');} ?>" method="post" role="form">
                                <div class="form-group">
                                    <label for="name" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" size="30" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $perfil->getName(); ?>"/>
                                        <input type="hidden" id="id" name="id" value="<?php echo $perfil->getId(); ?>"/>
                                        <input type="hidden" id="userapp" name="userapp" value="<?php echo htmlentities($_SESSION['username']); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="control-label col-xs-3"><?php echo _("Type"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <?php if (!in_array($perfil->getId(), [1,2,3] )){ ?>
                                            <input type="text" class="form-control" id="type" name="type" placeholder="Type" value="<?php echo $perfil->getType(); ?>"/>
                                        <?php } else { ?>
                                            <input type="text" class="form-control" id="dtype" name="dtypeh" placeholder="Type" disabled value="<?php echo $perfil->getType(); ?>"/>
                                            <input type="hidden" id="type" name="type" value="<?php echo $perfil->getType(); ?>"/>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sn_active" class="control-label col-xs-3"><?php echo _("Status"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <?php if (!in_array($perfil->getId(), [1,2,3] )){ ?>
                                            <select name="sn_active" id="sn_active" tabindex="6">
                                                <?php echo $combo->getStatus($perfil->getSnActive(), false); ?>
                                            </select>
                                        <?php } else { ?>
                                            <select name="dsn_active" id="dsn_active" tabindex="6" disabled>
                                                <?php echo $combo->getStatus($perfil->getSnActive(), false); ?>
                                            </select>
                                            <input type="hidden" id="sn_active" name="sn_active" value="<?php echo $perfil->getSnActive(); ?>"/>
                                        <?php } ?>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="7" class="btn btn-primary" 
                                               value="<?php echo $action; ?>"
                                               onclick="return regformperfil(this.form,
                                                               this.form.name,
                                                               this.form.type,
                                                               this.form.sn_active,
                                                               this.form.id,
                                                               this.form.userapp);"
                                               />
                                        <input type="reset" class="btn btn-default" value="<?php echo _("Clear"); ?>" />
                                    </div>
                                    <div class="col-xs-offset-10">
                                        <a class="btn btn-default " role="button" href="<?php echo $helper->url('perfil', 'index'); ?>"><?php echo _("Back"); ?></a>
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
