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
                <h1>
                    <small><?php echo _($action); ?></small>
                    <?php echo _("User Profile"); ?>
                </h1>
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
                    <form data-toggle="validator" class="form-horizontal"
                          action="<?php echo $helper->url('user', 'upsetting'); ?>" method="post" role="form"
                          enctype="multipart/form-data">
                                <input type="hidden" id="gaction" name="gaction" value="<?php echo $action;?>"/>
                                <div class="form-group">
                                    <label for="email" class="control-label col-xs-3"></label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                        <ol class="pinned-repos-list  mb-4 js-pinned-repos-reorder-list">
                                            <li class="pinned-repo-item  p-3 mb-3 border border-gray-dark rounded-1 js-pinned-repo-list-item ">
                                                <div class="pinned-repo-item-content">
                                            <span
                                                class="vcard-fullname d-block"><?php echo ucwords($user->getName()); ?></span>
                                            <span
                                                class="vcard-username d-block"><?php echo $user->getUsername(); ?></span>
                                                    <span class="vcard-username d-block"><?php echo $user->getEmail(); ?></span>
                                                    <hr>
                                            <span
                                                class="vcard-username d-block"><?php echo $user->getInstitution(); ?></span>
                                                </div>
                                            </li>
                                   <!-- <li class="pinned-repo-item  p-3 mb-3 border border-gray-dark rounded-1 js-pinned-repo-list-item ">
                                        <span class="btn_ btn-block_ mb-3"><?php echo _("Edit profile"); ?></span>
                                    </li>-->
                                        </ol>
                                    </div>
                                    <div class="col-xs-3 col-md-2">
                                        <img src="includes/image_user.php?id=<?php echo htmlentities($_SESSION['id_user']);?>"
                                             alt="<?php echo htmlentities($_SESSION['username']); ?>"
                                             title="<?php echo htmlentities($_SESSION['username']); ?>"
                                             width="200" height="200"
                                        />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                        <input type="hidden" id="id" name="id" value="<?php echo $user->getId();?>"/>
                                <input type="hidden" id="userapp" name="userapp"
                                       value="<?php echo htmlentities($_SESSION['username']); ?>"/>
                                <input required type="text" class="form-control" id="name" name="name"
                                       placeholder="<?php echo _("Name"); ?>" value="<?php echo $user->getName(); ?>" tabindex="1"/>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="control-label col-xs-3"><?php echo _("Username"); ?>:*</label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                <input required type="text" class="form-control" id="username" name="username"
                                       placeholder="<?php echo _("Username"); ?>" value="<?php echo $user->getUsername(); ?>" tabindex="2"/>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <div class="form-group">
                                    <label for="institution" class="control-label col-xs-3"><?php echo _("Institution"); ?>:*</label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                <input required type="text" class="form-control" id="institution" name="institution"
                                       placeholder="<?php echo _("Institution"); ?>"
                                               value="<?php echo $user->getInstitution(); ?>" tabindex="3" size="70"/>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <div class="form-group">
                                    <label for="location" class="control-label col-xs-3"><?php echo _("Location"); ?>:*</label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                <input required type="text" class="form-control" id="location" name="location"
                                       placeholder="<?php echo _("Location"); ?>"
                                               value="<?php echo $user->getLocation(); ?>" tabindex="4" size="70"/>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label col-xs-3"><?php echo _("New Password"); ?>:</label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                <input data-minlength="6" type="password" class="form-control" placeholder="<?php echo _("Passwords must be at least 6 characters long"); ?>"
                                       id="password" name="password" value="" tabindex="5"/>
                                        <div class="help-block"><?php echo _("Passwords must be at least 6 characters"); ?></div>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmpwd" class="control-label col-xs-3"><?php echo _("Confirm Password"); ?>:</label>
                                    <div class="col-xs-6 col-sm-4 col-md-6">
                                <input type="password" name="confirmpwd" id="confirmpwd" class="form-control"
                                       placeholder="<?php echo _("Confirm Password"); ?>" tabindex="6" value="" data-match="#password"
                                       data-match-error="Whoops, these don't match"/>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <div class="form-group">
                                    <label for="image" class="control-label col-xs-3"><?php echo _("Change your picture"); ?></label>
									 <div class="col-xs-9">
										<input type="file" name="image" id="image" tabindex="7" alt="Upload a picture about you... (1MB Max.)"
                                               title="Upload a picture about you... (1MB Max.)" class="form-control"/>
                                        <p class="help-block"><?php echo _("Upload a picture about you..."); ?>(1MB Max.)</p>
                                    </div>
                                    <div class="col-xs-3 col-md-2"></div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-3">
                                <input type="submit" name="register-submit" id="register-submit" tabindex="10"
                                       class="btn btn-primary" value="<?php echo _($action); ?>"
                                               onclick="return settingformhash(this.form,
                                                               this.form.name,
                                                               this.form.username,
                                                               this.form.password,
                                                               this.form.confirmpwd,
                                                               this.form.image,
                                                               this.form.gaction,
                                                               this.form.id,
                                                               this.form.userapp);"
                                               />
                                    </div>
                                    <div class="col-xs-offset-10">
                                <a class="btn btn-default " role="button"
                                   href="<?php echo $helper->url('project', 'show'); ?>"><?php echo _("Back"); ?></a>
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
