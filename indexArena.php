<?php

    //require_once 'includes/register.inc.php';
    require_once 'includes/functions.php';
    //require_once 'includes/combo.php';

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
                        <h1><small><?php echo _("list"); ?></small> <?php echo _("Hubs"); ?></h1>
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
                                        $('#table-arenas').dynatable({
                                            features: {
                                                pushState: true,
                                                paginate: true,
                                                sort: true,
                                                search: true,
                                                recordCount: true,
                                                perPageSelect: true
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
                                    <table id="table-arenas" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="dynatable-head" data-dynatable-column="name">
                                                <?php echo _("Name"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="place">
                                                <?php echo _("Place"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="address">
                                                <?php echo _("Address"); ?>
                                            </th>
                                            <!--th class="dynatable-head" data-dynatable-column="responsable">
                                                Responsable
                                            </th-->
                                            <th class="dynatable-head" data-dynatable-column="managers">
                                                <?php echo _("Managers"); ?>
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
                                        foreach($allarena as $arena) {?>
                                            <tr>
                                                <td style='text-align: left;'><?php echo $arena->getName(); ?></td>
                                                <td style='text-align: left;'><?php echo $arena->getPlace(); ?></td>
                                                <td style='text-align: left;'><?php echo $arena->getAddress(); ?></td>
                                                <!--td style='text-align: left;'>< ?php echo $arena->getResponsable(); ?></td-->
                                                <td style='text-align: center;'><?php echo $arena->getManagers(); ?></td>
                                                <td style='text-align: left;'>
                                                    <select name="snactive" id="snactive" disabled>
                                                        <?php
                                                        echo $combo->getStatus($arena->getSnActive(), true);
                                                        ?>
                                                    </select>
                                                    <span style="display: none;"><?php echo $arena->getSnActive(); ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($arena->getSnActive() == 'S') {
                                                        $send_status = "&status=N";
                                                        $icon_class = "glyphicon glyphicon-trash";
                                                    }else {
                                                        $send_status = "&status=S";
                                                        $icon_class = "glyphicon glyphicon-thumbs-up";
                                                    }
                                                    ?>
                                                    <a href="<?php echo $helper->url("arena","chstatus"); ?><?php echo $send_status; ?>&id_arena=<?php echo $arena->getId(); ?>" >
                                                        <span class="<?php echo $icon_class; ?>"></span>
                                                    </a>
                                                    <a href="<?php echo $helper->url("arena","modify"); ?>&id_arena=<?php echo $arena->getId(); ?>" >
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a>
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
                                <p><a class="btn btn-primary btn-md" role="button" href="<?php echo $helper->url("arena","add"); ?>"><?php echo _("Create Hubs"); ?></a></p>
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
