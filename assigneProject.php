<?php
require_once "includes/functions.php";
require_once 'includes/gerror.php';

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
    <title>FoTRRIS Assigne Project User </title>
    <?php include("section/sincl_html.php"); ?>
    <link href="css/util.css" rel="stylesheet"/>
    <link href="css/jquery-ui.min.css" rel="stylesheet"/>
    <script src="js/jquery-ui.min.js"></script>

    <script>
        $(function () {
            $("#date_from").datepicker({
                defaultDate: "+1w",
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    $("#date_to").datepicker("option", "minDate", selectedDate);
                }
            });
            $("#date_to").datepicker({
                defaultDate: "+1w",
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    $("#date_from").datepicker("option", "maxDate", selectedDate);
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
    <section>
        <div id="headerwrap-form">
            <div class="container">
                <div class="row">
                    <div class="page-header">
                        <h1>
                            <small>Assign</small>
                            User Project
                        </h1>
                    </div>
                    <?php if (isset($_GET['key'])) {
                        echo  getNotification($_GET['key'],$_GET['type']);
                    }
                    ?>
                    <form class="form-horizontal" action="includes/assigne_project.php" method="post" role="form">
                        <div class="form-group">
                            <label class="control-label col-xs-3">Project:*</label>
                            <div class="col-xs-9">
                                <select name="id_project" id="id_project" tabindex="6" class="form-control">
                                    <?php echo $combo->getProjects(null, true, true, $_SESSION['type'], $_SESSION['id_user']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">User:*</label>
                            <div class="col-xs-9">
                                <select name="id_user" id="id_user" tabindex="6" class="form-control">
                                    <?php echo $combo->getUser(null, true); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Linking Project:</label>
                            <div class="col-xs-9">
                                <div class="col-xs-4">
                                    <label class="control-label col-xs-4">From:*</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="date_from" name="date_from"/>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label col-xs-4">To:*</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="date_to" name="date_to"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Operative:*</label>
                            <div class="col-xs-2">
                                <label class="radio-inline">
                                    <input type="radio" name="sn_active" id="sn_active" value="S" checked="checked"/>
                                    Yes
                                </label>
                            </div>
                            <div class="col-xs-2">
                                <label class="radio-inline">
                                    <input type="radio" name="sn_active" id="sn_active" value="N"/> No
                                </label>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-xs-offset-3 col-xs-9">
                                <input type="submit" name="register-submit" id="register-submit" tabindex="7"
                                       class="btn btn-primary"
                                       value="Add User"
                                       onclick="return regformassigne(this.form,
                                                               this.form.id_project,
                                                               this.form.id_user,
                                                               this.form.date_from,
                                                               this.form.date_to,
                                                               this.form.sn_active);"
                                />
                                <input type="reset" class="btn btn-default" value="Clear"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <!-- ?php echo $error_msg; ?-->
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
