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
                        <h1><small><?php echo _("list"); ?></small> <?php echo _("Assign User to Project"); ?></h1>
                    </div>
                </div>
            </div>

            <section>
                <div id="headerwrap-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <script type="text/javascript">
                                    $(function() {
                                        $('#table-assign').dynatable({
                                            features: {
                                                pushState: true
                                            },
                                            readers: {
                                                /*'project': function(el, record) {
                                                 return Number(el.innerHTML) || 0;
                                                 }, */
                                                'number': function (el, record) {
                                                    return Number(el.innerHTML.replace(/,/g, ''));
                                                }
                                            },
                                            writers: {
                                                /*'project': function(record) {
                                                 return record['project'] ? record['project'].toString() : '-';
                                                 }, */
                                                'number': function (record) {
                                                    return record['number'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (isset($_GET['key'])) {
                                    echo getNotification($_GET['key'], $_GET['type'] );
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dynatable-demo">
                                    <table id="table-assign" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="dynatable-head" data-dynatable-column="name_project">
                                                <?php echo _("Name Project"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="name_user">
                                                <?php echo _("Name user"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="email_user">
                                                <?php echo _("Email user"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="arena_user">
                                                <?php echo _("Hub Project"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="date_from">
                                                <?php echo _("From"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="date_to">
                                                <?php echo _("To"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="date_create">
                                                <?php echo _("Created"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="user_create">
                                                <?php echo _("Created By"); ?>
                                            </th>
                                            <th class="dynatable-head" style="text-align: center;" data-dynatable-column="status">
                                                <?php echo _("Status"); ?>
                                            </th>
                                            <th class="dynatable-head" style="text-align: center;" data-dynatable-column="actions">
                                                <?php echo _("Actions"); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($allassign as $assign) {?>
                                            <tr>
                                                <td style='text-align: left;'>
                                                    <?php echo $assign->getNameProject(); ?>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <?php echo $assign->getNameUser(); ?>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <?php echo $assign->getEmail(); ?>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <?php echo $assign->getNameHub(); ?>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <?php echo date(FORMAT_DATE, strtotime($assign->getDateFrom())); ?>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <?php echo date(FORMAT_DATE, strtotime($assign->getDateTo())); ?>
                                                </td>
                                                <td style='text-align: left;'><?php echo date(FORMAT_DATE, strtotime($assign->getDateCreate())); ?></td>
                                                <td style='text-align: left;'>
                                                    <?php echo $assign->getUserCreate(); ?>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <select name="snactive" id="snactive" disabled>
                                                        <?php
                                                        echo $combo->getStatus($assign->getSnActive(), true);
                                                        ?>
                                                    </select>
                                                    <span style="display: none;"><?php echo $assign->getSnActive(); ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($assign->getSnActive() == 'S') {
                                                        $send_status = "&status=N";
                                                        $icon_class = "glyphicon glyphicon-thumbs-down";
                                                    }else {
                                                        $send_status = "&status=S";
                                                        $icon_class = "glyphicon glyphicon-thumbs-up";
                                                    }
                                                    ?>
                                                    <a href="<?php echo $helper->url("assign","chstatus"); ?><?php echo $send_status; ?>&id_assign=<?php echo $assign->getId(); ?>&param=id_<?php echo htmlentities($_SESSION['id_user']); ?>_type_<?php echo htmlentities($_SESSION['type']); ?>" title="Autorice" alt="Autorice">
                                                        <span class="<?php echo $icon_class; ?>"></span>
                                                    </a>
                                                    <a href="<?php echo $helper->url("assign","modify"); ?>&id_assign=<?php echo $assign->getId(); ?>" title="Modify" alt="Modify">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a>
                                                    <?php if ($_SESSION['type'] == 2) { ?>
                                                        <a href="<?php echo $helper->url("assign","delete"); ?>&id_assign=<?php echo $assign->getId(); ?>" title="Delete" alt="Delete">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><a class="btn btn-primary btn-md" role="button" href="<?php echo $helper->url("assign","add"); ?>"><?php echo _("Assign Project"); ?></a></p>
                            </div>
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
