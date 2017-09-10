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
        <title>FoTRRIS Hubs </title>
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
                        <h1><small><?php echo _($action); ?></small> <?php echo _("Hubs"); ?></h1>
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
                            <form data-toggle="validator" class="form-horizontal" action="<?php if ($action == 'Create') { echo $helper->url('arena','create');} else {echo $helper->url('arena','update');} ?>"  method="post" role="form">

                                <div class="form-group">
                                    <label class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" id="name" name="name" placeholder="<?php echo _("Name"); ?>" tabindex="1" value="<?php echo $arena->getName(); ?>"/>
                                        <input type="hidden" id="id" name="id" value="<?php echo $arena->getId(); ?>"/>
                                        <input type="hidden" id="userapp" name="userapp" value="<?php echo htmlentities($_SESSION['username']); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"><?php echo _("Place"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" id="place" name="place" placeholder="<?php echo _("Place"); ?>" tabindex="2" value="<?php echo $arena->getPlace(); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"><?php echo _("Address"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" id="address" name="address" placeholder="<?php echo _("Address"); ?>" tabindex="3" value="<?php echo $arena->getAddress(); ?>"/>
                                    </div>
                                </div>
                                <!--div class="form-group">
                                    <label class="control-label col-xs-3">Responsable:*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" placeholder="Responsable" id="responsable" name="responsable" tabindex="4" value="<?php echo $arena->getResponsable(); ?>"/>
                                    </div>
                                </div-->
                                <div class="form-group">
                                    <label for="id_user" class="control-label col-xs-3"><?php echo _("Manager"); ?>:</label>
                                    <div class="col-xs-9">
                                        <select name="id_user" id="id_user" tabindex="6" multiple="multiple">
                                            <?php echo $combo->getUserManagerArena($arena->getIdUserList(), false); ?>
                                        </select>
                                        <input type="hidden" id="id_user_list" name="id_user_list"/>
                                        <input type="hidden" id="responsable" name="responsable" value="UCM"/>
                                        <script>
                                            $(function () {
                                                $('#id_user').multiselect({
                                                    includeSelectAllOption: true
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sn_active" class="control-label col-xs-3"><?php echo _("Status"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select required name="sn_active" id="sn_active" tabindex="6">
                                            <?php echo $combo->getStatus($arena->getSnActive(), false); ?>
                                        </select>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="7" class="btn btn-primary" 
                                               value="<?php echo $action; ?>"
                                               onclick="return regformarena(this.form,
                                                               this.form.name,
                                                               this.form.place,
                                                               this.form.address,
                                                               this.form.responsable,
                                                               this.form.sn_active,
                                                               this.form.id,
                                                               this.form.userapp,
                                                               this.form.id_user,
                                                               this.form.id_user_list);"
                                               />
                                        <input type="reset" class="btn btn-default" value="<?php echo _("Clear"); ?>" tabindex="8"/>
                                    </div>
                                    <div class="col-xs-offset-10">
                                        <a class="btn btn-default " role="button" href="<?php echo $helper->url('arena', 'index'); ?>"><?php echo _("Back"); ?></a>
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
