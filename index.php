<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE );
session_start();
require 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cebu Shopping</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/yeti.bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="img/favicon36.png">

</head>
<body ng-app="devCS">
<!--TODO <pre><?php print_r($_SESSION); ?></pre> -->

    <!-- Navigation Logged-in-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo url(); ?>"><strong>[ Dev CS ]</strong> <i>Cebu Shopping</i></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#mod-about">About</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#mod-services">Services</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#mod-contact">Contact</a>
                    </li>
                    <?php if(!empty($_SESSION['uid'])) : ?>
                    <li class="dropdown" ng-controller="Account">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" data-toggle="modal" data-target="#mod-account">My Profile</a></li>
                            <li><a href="#" ng-click="logout()">Logout</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<<?php echo empty($_SESSION['uid'])?'homepage':'dashboard';?>>
        <span class="ajax-loader"><img src="img/ajax-loader-blue.gif" /></span>   
    </<?php echo empty($_SESSION['uid'])?'homepage':'dashboard';?>>

    <!-- Modal About -->
    <div id="mod-about" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="content-section-b">

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <hr class="section-heading-spacer">
                                    <div class="clearfix"></div>
                                    <h2 class="section-heading">Cebu Shopping <i>[CS]</i></h2>
                                    <p class="lead"><i><strong>Dev CS</strong></i> is creating a free web based IT team management utility. <br/><br/>From Daniel Ally: <br/><i>A dull pencil is better than a sharp mind</i><br/><br/>This will be your pencil realizing your IT projects...</p>
                                    <div class="alert alert-danger" role="alert"><strong>!</strong> The site is currently in development and it will be releasing its free products the soonest.</div>
                                    <p class="lead sub-text"><i>From the <a href="/author/">founder</a>:</i><br/>Special thanks to <a href="http://www.sourcemake.com" target="_blank">Source Make</a>, <a href="http://www.cebuessentialrealty.com" target="_blank">Cebu Essential Realty</a> and <a href="http://www.cebushopping.com/cbms" target="_blank">Community-Based Monitoring System(CBMS)</a> for instilling and believing the capabilities I possess to create something.</p>
                                </div>
                                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                                    <img class="img-responsive" src="img/ipad.png" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- /.container -->
                    </div>
                    <!-- /.content-section-b -->
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal About -->

    <!-- Modal Services -->
    <div id="mod-services" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="content-section-a">

                        <div class="container">

                            <div class="row">
                                <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                                    <hr class="section-heading-spacer">
                                    <div class="clearfix"></div>
                                    <h2 class="section-heading">Products and Services<br>by <i>[ Dev CS ]</i></h2>
                                    <p class="lead">-Build website from ground up.
                                    <br/>-Maintain/fix websites both back-end and front-end.
                                    <br/>-Manage clouds.</p>
                                </div>
                                <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                                    <img class="img-responsive" src="img/path.png" alt="">
                                </div>
                            </div>

                        </div>
                        <!-- /.container -->

                    </div>
                    <!-- /.content-section-a -->
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal Services -->

    <!-- Modal Contact -->
    <div id="mod-contact" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="content-section-b">

                        <div class="container">

                            <div class="row">
                                <div class="col-lg-5 col-sm-5">
                                    <hr class="section-heading-spacer">
                                    <div class="clearfix"></div>
                                    <h2 class="section-heading">Contact <i>[ Dev CS ]</i> &gt;&gt;</h2>
                                    <p class="lead"></p>
                                </div>
                                <div class="col-lg-7 col-sm-7">
                                    <div class="input-group input-group-lg contact-email-container">
                                      <span class="input-group-addon">Email</span>
                                      <input type="text" class="form-control contact-email" placeholder="Email Address" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="input-group input-group-lg contact-msg-container">
                                      <span class="input-group-addon">Message</span>
                                      <textarea class="form-control contact-msg" placeholder="Your Message" aria-describedby="sizing-addon1"></textarea>
                                    </div>
                                    <div class="input-group input-group-lg contact-send">
                                        <a href="javascript:void(0)" id="contact-send-btn" class="btn btn-default btn-lg"> Send <span class="glyphicon glyphicon-comment"></span></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.container -->

                    </div>
                    <!-- /.content-section-b -->
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal Contact -->

	<!-- Footer -->
    <footer>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="footer-content">
                <div class="footer-left">
                    <ul class="list-inline">
                        <li>
                            <a href="<?php echo url(); ?>">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#mod-about">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#mod-services">Services</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#mod-contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">&copy;<copyright></copyright> <i>[ Dev CS ]</i>. All Rights Reserved</p>
                </div>
                <div class="footer-right powered-by">
                    <span>Powered by:</span>
                    <img title="PHP" src="img/logo/php.png" />
                    <img title="PHP PDO" src="img/logo/pdo.png" />
                    <img title="MySQL" src="img/logo/mysql.png" />
                    <img title="JQuery" src="img/logo/jquery.png" />
                    <img title="AngularJS" src="img/logo/angularjs.png" />
                    <img title="NPM" src="img/logo/npm.png" />
                    <img title="Gulp JS" src="img/logo/gulp.png" />
                    <img title="GIT Bash" src="img/logo/git.png" />
                </div>
            </div>
        </div>
    </footer>

	<!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Angular -->
    <script src="js/angular.min.js"></script>
    <!-- Main JavaScript -->
    <script src="js/main.js"></script>
</body>
</html>