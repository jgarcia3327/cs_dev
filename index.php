<?php 
session_start();
//Global variables
$IS_IN = empty($_SESSION['uid'])? false : true;

//Functions
function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

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

<body class="<?php echo !$IS_IN?"homepage":"loggedin" ?>" >

<?php if(!$IS_IN): //Start Homepage?>

    <!-- Navigation Homepage-->
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
                <a class="navbar-brand" href="<?php echo url(); ?>"><strong>[ Team CS ]</strong> <i>Cebu Shopping</i></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#about">About</a>
                    </li>
                    <li>
                        <a href="#services">Services</a>
                    </li>
                    <li>
                        <a href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header -->
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <!-- Login -->
                <div id='view-login' class="col-lg-12">
                    <form id="frm-login" action="" method="POST">
                        <div class="intro-message">
                            <h1>Login</h1>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">Email</span>
                                <input name="uname" type="text" class="form-control" placeholder="Email Address" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">Password</span>
                                <input name="pass" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                            </div>
                            <hr class="intro-divider">
                            <ul class="list-inline intro-social-buttons">
                                <li>
                                    <a href="#" class="btn btn-primary btn-lg"> <span class="network-name">Login</span></a>
                                </li>
                                <li>
                                    <a href="#" id="reg-link" class="btn btn-default btn-lg"> <span class="network-name">Register &gt;&gt;</span></a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-success btn-lg"> <span class="network-name">Login with FB</span></a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>

                <!-- Registration -->
                <div id='view-reg' class="col-lg-12" style="display: none;">
                    <form id="frm-reg" action="" method="POST">
                        <div class="intro-message">
                            <h1>Register</h1>
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">Team/Company</span>
                                        <input name="team" type="text" class="form-control" placeholder="Team/Company Name" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">First Name</span>
                                        <input name="fname" type="text" class="form-control" placeholder="E.g John" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">Last Name</span>
                                        <input name="fname" type="text" class="form-control" placeholder="E.g Smith" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">Email</span>
                                        <input name="uname" type="text" class="form-control" placeholder="Email Address" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">Password</span>
                                        <input name="pass" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">Confirm Password</span>
                                        <input name="cpass" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline intro-social-buttons">
                                <li>
                                    <a href="#" id="login-link" class="btn btn-default btn-lg"> <span class="network-name">&lt;&lt; Login</span></a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-primary btn-lg"> <span class="network-name">Register</span></a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-success btn-lg"> <span class="network-name">Login with FB</span></a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>

            </div>
              

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content Homepage-->

    <a  name="about"></a>
        <div class="content-section-b">

            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-sm-6">
                        <hr class="section-heading-spacer">
                        <div class="clearfix"></div>
                        <h2 class="section-heading">Cebu Shopping <i>[CS]</i></h2>
                        <p class="lead"><i><strong>Team CS</strong></i> is creating a free web based IT team management utility.</p>
                        <div class="alert alert-danger" role="alert"><strong>!</strong> The site is currently in development and it will be releasing its free products the soonest.</div>
                        <p class="lead"><i>From the <a href="/author/">founder</a>:</i><br/>Special thanks to <a href="http://www.sourcemake.com" target="_blank">Source Make</a> for instilling and believing the capabilities I possess to create something.</p>
                    </div>
                    <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                        <img class="img-responsive" src="img/ipad.png" alt="">
                    </div>
                </div>

            </div>
            <!-- /.container -->

        </div>
        <!-- /.content-section-b -->


        <a  name="services"></a>
        <div class="content-section-a">

            <div class="container">

                <div class="row">
                    <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                        <hr class="section-heading-spacer">
                        <div class="clearfix"></div>
                        <h2 class="section-heading">Products and Services<br>by <i>[ Team CS ]</i></h2>
                        <p class="lead">-Build website from ground up.
                        <br/>-Maintain/fix websites both back-end and front-end.
                        <br/>-Manage clouds.</p>
                    </div>
                    <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                        <img class="img-responsive" src="img/dog.png" alt="">
                    </div>
                </div>

            </div>
            <!-- /.container -->

        </div>
        <!-- /.content-section-a -->


        <a  name="contact"></a>
        <div class="content-section-b">

            <div class="container">

                <div class="row">
                    <div class="col-lg-5 col-sm-5">
                        <hr class="section-heading-spacer">
                        <div class="clearfix"></div>
                        <h2 class="section-heading">Contact <i>[ Team CS ]</i> &gt;&gt;</h2>
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
                            <a href="javascript:void(0)" id="contact-send-btn" class="btn btn-default btn-lg"> <span class="network-name">Send <span class="glyphicon glyphicon-comment"></span></a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container -->

        </div>
        <!-- /.content-section-b -->

<?php else: //Start Logged-in //end Homepage?>
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
                <a class="navbar-brand" href="<?php echo url(); ?>"><strong>[ Team CS ]</strong> <i>Cebu Shopping</i></a>
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div id="page-container" class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group">
                    <a href="#" class="list-group-item">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
                </div>
            </div>

            <div class="col-md-9">

                <div class="row">

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$24.99</h4>
                                <h4><a href="#">First Product</a>
                                </h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">15 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$64.99</h4>
                                <h4><a href="#">Second Product</a>
                                </h4>
                                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">12 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$74.99</h4>
                                <h4><a href="#">Third Product</a>
                                </h4>
                                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">31 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$84.99</h4>
                                <h4><a href="#">Fourth Product</a>
                                </h4>
                                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">6 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$94.99</h4>
                                <h4><a href="#">Fifth Product</a>
                                </h4>
                                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">18 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <h4><a href="#">Like this template?</a>
                        </h4>
                        <p>If you like this template, then check out <a target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">this tutorial</a> on how to build a working review system for your online store!</p>
                        <a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">View Tutorial</a>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <!-- Modals -->
    <div id="modals" />
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
                                        <h2 class="section-heading">Death to the Stock Photo:<br>Special Thanks</h2>
                                        <p class="lead">A special thanks to <a target="_blank" href="http://join.deathtothestockphoto.com/">Death to the Stock Photo</a> for providing the photographs that you see in this template. Visit their website to become a member.</p>
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
                                        <h2 class="section-heading">3D Device Mockups<br>by PSDCovers</h2>
                                        <p class="lead">Turn your 2D designs into high quality, 3D product shots in seconds using free Photoshop actions by <a target="_blank" href="http://www.psdcovers.com/">PSDCovers</a>! Visit their website to download some of their awesome, free photoshop actions!</p>
                                    </div>
                                    <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                                        <img class="img-responsive" src="img/dog.png" alt="">
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
                                    <div class="col-lg-5 col-sm-6">
                                        <hr class="section-heading-spacer">
                                        <div class="clearfix"></div>
                                        <h2 class="section-heading">Google Web Fonts and<br>Font Awesome Icons</h2>
                                        <p class="lead">This template features the 'Lato' font, part of the <a target="_blank" href="http://www.google.com/fonts">Google Web Font library</a>, as well as <a target="_blank" href="http://fontawesome.io">icons from Font Awesome</a>.</p>
                                    </div>
                                    <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                                        <img class="img-responsive" src="img/phones.png" alt="">
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
    </div>
    <!-- /end Modals -->

<?php endif; //end Logged-in?>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="<?php echo url(); ?>">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#services">Services</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy; <i>[ CS Team ]</i> <?php echo date('Y');?>. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Main JavaScript -->
    <script src="js/main.js"></script>

</body>

</html>
