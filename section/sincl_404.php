<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 18/06/16
 * Time: 16:05
 */
?>
<section>
    <!-- Body Main -->
    <div id="headerwrap">
        <div class="container">
            <div class="row">
                <h1></h1>
            </div>
            <div class="row">
                <h1></h1>
            </div>
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 himg">
                    <img src="img/FoTRRIs_Logo.jpg" class="img-responsive" width="55%" height="55%">
                </div>
                <div class="col-lg-10 col-lg-offset-1 himg">
                    <h5><?php echo _("Fostering Transition into Responsible Research and Innovation Systems"); ?></h5>
                </div>
                <div class="col-lg-10 col-lg-offset-1">
                    <h3>
                        <?php echo _("Welcome to the FoTRRIS web Platform"); ?>
                        <!--button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#infoFoTRRIS">
                            <img src="img/summary.png" alt="Info" title="More Information of FoTRRIS" />
                        </button-->
                    </h3>

                    <h1><?php echo _("Platform for co-creation of Project ideas"); ?></h1>
                    <h4><a href="guideline.php" target="_blank"><?php echo _("Usage Guidelines"); ?></a></h4>
                    <h4><a href="description.php" target="_blank"><?php echo _("General Information of web Platform"); ?></a></h4>
                    <h4><?php if (!login_check($mysqli) == true) { ?>
                            <a href="login.php" ><?php echo _("Please Login"); ?> </a>
                        <?php } ?>
                    </h4>
                    <h4><?php echo _("This project has received funding from the European Union’s Horizon 2020 Research & Innovation programme under Grant Agreement no. 665906."); ?></h4>
                    <h4><?php echo _("More information at"); ?>&nbsp;<a href="http://fotrris-h2020.eu/" target="_blank">http://fotrris-h2020.eu/</a></h4>
                </div>
                <div class="col-lg-10 col-lg-offset-1">&nbsp;
                </div>
            </div><!-- /row -->
        </div> <!-- /container -->
    </div><!-- /headerwrap -->
    <!-- Modal -->
    <div class="modal fade" id="infoFoTRRIS" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">co-RRI Platform</h4>
                </div>
                <div class="modal-body">
                    <p>The co-RRI platform is a web based platform that fulfils several functions, utilities and services to support the co-RRI hubs. To start with, it fulfils some innovation services. It embodies a process architecture, i.e. a well-structured process consisting of various phases and supported by appropriate tools and methods, which guide the participation of innovation actors through the process of co-designing RRI project concepts. This process architecture reflects the co-RRI-concept and the web platform facilitates the process via online dialogues between participating stakeholders. It is based on accessible and transparent documentation of the intermediary and final process results. The process, consisting of both virtual/online phases and real life workshops, will support knowledge actors to gradually design, together with other stakeholders, a co-RRI project concept. The platform will also provide tools for checking the compliances to co-RRI principles along the process.</p>
                    <p>
                        As a web service to foster Co-RRI, the web platform is meant to support stakeholders to address glocal challenges. It defines several services,  to support the conceptual framework for Co-RRI. More specifically, the platform will provide:
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item">Innovation services to facilitate interactions between stakeholders and to support knowledge actors to co-design RRI-projects in order to realize co-projected visions of solutions to local manifestations of global societal challenges according to RRI methods and standards by following the Co-RRI process architecture.</li>
                        <li class="list-group-item">Communication and dissemination of Co-RRI activities and results.</li>
                        <li class="list-group-item">Storage of lessons learnt from past RRI projects, best cases examples and data on sustainability challenges.</li>
                    </ul>
                    <p>
                        This co-RRI platform is based on state-of-the-art collaborative platforms reviewed in the project. The general technical prerequisites of the platform are the following:
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item">Support for online communication (discuss, comment).</li>
                        <li class="list-group-item">Support for online collaboration (in order to reach a common solution)</li>
                        <li class="list-group-item">Providing some means of dissemination for the general public.</li>
                        <li class="list-group-item">Searchable storage of past projects.</li>
                    </ul>
                    <p>
                        <span style="font-style: italic;">UCM-GRASIA</span> from the Universidad Complutense de Madrid, Spain has developed the co-RRI web platform, a collaborative tool for FoTRRIS project. This platform is using for the transition experiments at each FoTRRIS co-RRI hub, by presenting the interface and functionality of the web application. The FoTRRIS Co-RRI web platform allows creating projects to work together when looking for solutions for the problems presented in the different topics addressed by each transition experiment. Following this idea, one or more projects could be created in the platform for each hub, for mapping solutions to the problem presented.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _("Close"); ?></button>
                </div>
            </div>

        </div>
    </div>
</section>
