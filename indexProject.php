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
        <title>FoTRRIS Projects </title>
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
                        <h1><small><?php echo _("list"); ?></small> <?php echo _("Projects"); ?></h1>
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
                                        $('#table-project').dynatable({
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
                                    <table id="table-project" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="dynatable-head" data-dynatable-column="name">
                                                    <?php echo _("Name"); ?>
                                                </th>
                                                <th class="dynatable-head" data-dynatable-column="arena">
                                                    <?php echo _("Hubs"); ?>
                                                </th>
                                                <th class="dynatable-head" data-dynatable-column="ubication">
                                                    <?php echo _("Ubication"); ?>
                                                </th>
                                                <!--th class="dynatable-head" data-dynatable-column="descproject">
                                                    Description
                                                </th-->
                                                <th class="dynatable-head" data-dynatable-column="datefrom">
                                                    <?php echo _("From"); ?>
                                                </th>
                                                <th class="dynatable-head" data-dynatable-column="dateto">
                                                    <?php echo _("To"); ?>
                                                </th>
                                                <th class="dynatable-head" style="text-align: center;" data-dynatable-column="num_user">
                                                    <?php echo _("Pads"); ?>
                                                </th>
                                                <th class="dynatable-head" style="text-align: center;" data-dynatable-column="num_pad">
                                                    <?php echo _("Keywords"); ?>
                                                </th>
                                                <th class="dynatable-head" style="text-align: center;" data-dynatable-column="num_keywords">
                                                    <?php echo _("Users"); ?>
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
                                                foreach($allproject as $project) {?>
                                                    <tr>
                                                        <td style='text-align: left;'>
                                                            <?php echo $project->getName(); ?>
                                                        </td>
                                                        <td style='text-align: left;'>
                                                            <?php echo $project->getNameArena(); ?>
                                                        </td>
                                                        <td style='text-align: left;'><?php echo $project->getUbication(); ?></td>
                                                        <!--td style='text-align: left;'>< ?php echo $project->getDescProject(); ?></td-->
                                                        <td style='text-align: left;'>
                                                            <?php echo ($project->getDateFrom()!='')?date(FORMAT_DATE, strtotime($project->getDateFrom())):""; ?>
                                                        </td>
                                                        <td style='text-align: left;'>
                                                            <?php echo ($project->getDateTo()!='')?date(FORMAT_DATE, strtotime($project->getDateTo())):""; ?>
                                                        </td>
                                                        <td style='text-align: left;'>
                                                            <?php echo $project->getNumPad(); ?>
                                                        </td>
                                                        <td style='text-align: left;'>
                                                            <?php echo $project->getNumKeywords(); ?>
                                                        </td>
                                                        <td style='text-align: left;'>
                                                            <?php echo $project->getNumUser(); ?>
                                                        </td>
                                                        <td style='text-align: left;'>
                                                            <select name="snactive" id="snactive" disabled>
                                                                <?php
                                                                echo $combo->getStatus($project->getSnActive(), true);
                                                                ?>
                                                            </select>
                                                            <span style="display: none;"><?php echo $project->getSnActive(); ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if ($project->getSnActive() == 'S') {
                                                                $send_status = "&status=N";
                                                                $icon_class = "glyphicon glyphicon-trash";
                                                            }else {
                                                                $send_status = "&status=S";
                                                                $icon_class = "glyphicon glyphicon-thumbs-up";
                                                            }
                                                            ?>
                                                            <a href="<?php echo $helper->url("project","chstatus"); ?><?php echo $send_status; ?>&id_project=<?php echo $project->getId(); ?>&param=id_<?php echo htmlentities($_SESSION['id_user']); ?>_type_<?php echo htmlentities($_SESSION['type']); ?>" >
                                                                <span class="<?php echo $icon_class; ?>"></span>
                                                            </a>
                                                            <a href="<?php echo $helper->url("project","modify"); ?>&id_project=<?php echo $project->getId(); ?>" >
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
                                <p><a class="btn btn-primary btn-md" role="button" href="<?php echo $helper->url("project","add"); ?>"><?php echo _("Create Project"); ?></a></p>
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
