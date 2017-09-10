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
        <title>FoTRRIS Assign User to Project </title>
        <?php include("section/sincl_html.php"); ?>
        <link rel="stylesheet" href="css/util.css" />
        <link href="css/jquery-ui.min.css" rel="stylesheet" />
        <script src="js/jquery-ui.min.js"></script>

        <script>
            $(function() {
                $( "#date_from" ).datepicker({
                    defaultDate: "+1w",
                    dateFormat: '<?php echo FORMAT_DATE_CALENDAR; ?>',
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#date_to" ).datepicker( "option", "minDate", selectedDate );
                    }
                });
                $( "#date_to" ).datepicker({
                    defaultDate: "+1w",
                    dateFormat: '<?php echo FORMAT_DATE_CALENDAR; ?>',
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
                    }
                });
            });
        </script>
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
                        <h1><small><?php echo _($action); ?></small> <?php echo _("Assign User to Project"); ?></h1>
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
                            <form data-toggle="validator" class="form-horizontal" action="<?php if ($action == 'Create') { echo $helper->url('assign','create');} else {echo $helper->url('assign','update');} ?>" method="post" role="form">
                                <div class="form-group">
                                    <label for="id_project" class="control-label col-xs-3"><?php echo _("Select Project"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select required name="id_project" id="id_project" tabindex="1">
                                            <?php echo $combo->getProjects($assign->getIdProject(), true, true, $_SESSION['type'], $_SESSION['id_user']); ?>
                                        </select>
                                        <input type="hidden" id="id" name="id" value="<?php echo $assign->getId(); ?>"/>
                                        <input type="hidden" id="id_user_log" name="id_user_log" value="<?php echo htmlentities($_SESSION['id_user']); ?>"/>
                                        <input type="hidden" id="type" name="type" value="<?php echo htmlentities($_SESSION['type']); ?>"/>
                                        <input type="hidden" id="userapp" name="userapp" value="<?php echo htmlentities($_SESSION['username']); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_user" class="control-label col-xs-3"><?php echo _("Select User"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select required name="id_user" id="id_user" tabindex="2">
                                            <?php echo $combo->getUser($assign->getIdUser(), true); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"><?php echo _("Duration"); ?> </label>
                                    <div class="col-xs-9">
                                        <div class="col-xs-4">
                                            <label for="date_from" class="control-label col-xs-4"><?php echo _("From"); ?>:*</label>
                                            <div class="input-group date">
                                                <input required type="text" class="form-control" id="date_from" name="date_from" tabindex="5" value="<?php echo ($assign->getDateFrom()!='')?date(FORMAT_DATE, strtotime($assign->getDateFrom())):""; ?>" data-error="The start date and end date are necessary!"/>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="date_to" class="control-label col-xs-4"><?php echo _("To"); ?>:*</label>
                                            <div class="input-group date">
                                                <input required type="text" class="form-control" id="date_to" name="date_to" tabindex="6" value="<?php echo ($assign->getDateTo()!='')?date(FORMAT_DATE, strtotime($assign->getDateTo())):""; ?>" data-error="The start date and end date are necessary!"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sn_active" class="control-label col-xs-3"><?php echo _("Status"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select required name="sn_active" id="sn_active" tabindex="3">
                                            <?php echo $combo->getStatus($assign->getSnActive(), false); ?>
                                        </select>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="7" class="btn btn-primary" 
                                               value="<?php echo $action; ?>"
                                               onclick="return regformassigne(this.form,
                                                               this.form.id_project,
                                                               this.form.id_user,
                                                               this.form.date_from,
                                                               this.form.date_to,
                                                               this.form.sn_active,
                                                               this.form.id,
                                                               this.form.userapp);"
                                               />
                                        <input type="reset" class="btn btn-default" value="<?php echo _("Clear"); ?>" />
                                    </div>
                                    <div class="col-xs-offset-10">
                                        <a class="btn btn-default " role="button" href="<?php echo $helper->url('assign', 'index'); ?>&param=id_<?php echo htmlentities($_SESSION['id_user']); ?>_type_<?php echo htmlentities($_SESSION['type']); ?>"><?php echo _("Back"); ?></a>
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
