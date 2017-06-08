<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?= $base_info[site_title] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
<link href="<?= _WEB_BASE_DIR ?>/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= _WEB_BASE_DIR ?>/css/font-awesome.min.css">
<link href="<?= _WEB_BASE_DIR ?>/css/style.css" rel="stylesheet">

<link href="<?= _WEB_BASE_DIR ?>/css/prettyPhoto.css" rel="stylesheet" media="screen">
<link href="<?= _WEB_BASE_DIR ?>/css/portfolio.css" rel="stylesheet">
<link rel="stylesheet" href="<?= _WEB_BASE_DIR ?>/layerslider/css/layerslider.css" type="text/css">
<link rel="stylesheet" href="<?= _WEB_BASE_DIR ?>/layerslider/css/layersliderstyle.css" type="text/css">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!-- fav -->
<link rel="shortcut icon" href="assets/ico/favicon.ico">
</head>
<body>
<!-- Header Start -->
<header>
<div class="headerstrip">
    <div class="container">
		<? if($_SESSION['member_id']): ?>
        <div class="pull-left welcometxt"> Welcome <b><?= $_SESSION['member_first_name'] ?></b> <a class="orange" href="<?= _WEB_BASE_DIR ?>/logoff.php">Sign out</a></div>
		<? else: ?>
        <div class="pull-left welcometxt"> Welcome to <?= $base_info[site_name] ?>, <a class="orange" href="<?= _WEB_BASE_DIR ?>/login.php">Login</a> or <a class="orange" href="<?= _WEB_BASE_DIR ?>/join.php">Create new account</a> </div>
		<? endif; ?>
        <!-- Top Nav Start -->
        <div class="pull-right">
            <div class="navbar" id="topnav">
                <div class="navbar-inner">
                    <ul class="nav" >
                        <li><a class="home active" href="<?= _WEB_BASE_DIR ?>/index.php"><i class="icon-home"></i> Home </a> </li>
                        <li><a class="myaccount" href="<?= _WEB_BASE_DIR ?>/myaccount.php"><i class="icon-user"></i> My Account </a> </li>
                        <li><a class="shoppingcart" href="<?= _WEB_BASE_DIR ?>/cart.php"><i class="icon-shopping-cart"></i> Shopping Cart </a> </li>
                        <li><a class="checkout" href="<?= _WEB_BASE_DIR ?>/checkout.php"><i class="icon-ok-circle"></i> CheckOut </a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Top Nav End -->
        
        <!-- <div class="pull-right">
            <ul class="nav language pull-left">
                <li class="dropdown hover"> <a href="#" class="dropdown-toggle" data-toggle="">US Doller <b class="caret"></b></a>
                    <ul class="dropdown-menu currency">
                        <li><a href="#">US Doller</a> </li>
                        <li><a href="#">Euro </a> </li>
                        <li><a href="#">British Pound</a> </li>
                    </ul>
                </li>
                <li class="dropdown hover"> <a href="#" class="dropdown-toggle" data-toggle="">English <b class="caret"></b></a>
                    <ul class="dropdown-menu language">
                        <li><a href="#">English</a> </li>
                        <li><a href="#">Spanish</a> </li>
                        <li><a href="#">German</a> </li>
                    </ul>
                </li>
            </ul>
        </div> -->
    </div>
</div>
<div class="container">
    <div class="headerdetails"> <a class="logo pull-left" href="<?= _WEB_BASE_DIR ?>/index.php"><img title="Stylebynewyork" alt="Stylebynewyork" src="<?= _WEB_BASE_DIR ?>/img/stylebyny02_1.jpg" ></a>
        <div class="pull-left">
            <form class="form-search top-search">
                <input type="text" class="input-medium search-query" placeholder="Search Here…">
                <button class="btn btn-orange btn-small tooltip-test" data-original-title="Search"> <i class="icon-search icon-white"></i> </button>
            </form>
        </div>
        <div class="pull-right">
            <ul class="nav topcart pull-left">
                <li class="dropdown hover carticon "> <a href="#" class="dropdown-toggle" > <i class="icon-shopping-cart font18"></i> Shopping Cart <span class="label label-orange font14">1 item(s)</span> - $<?= $cart_sum_tmp ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu topcartopen ">
                        <li>
                            <table>
                                <tbody>
                                    <?= $top_limit_contents ?>
                                </tbody>
                            </table>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="textright"><b>Sub-Total:</b></td>
                                        <td class="textright">$<?= $cart_sum_tmp ?></td>
                                    </tr>
                                    <tr>
                                        <td class="textright"><b>Discount:</b></td>
                                        <td class="textright">$<?= $discount ?></td>
                                    </tr>
                                    <tr>
                                        <td class="textright"><b>Total:</b></td>
                                        <td class="textright">$<?= $cart_sum_tmp ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="well pull-right buttonwrap"> <a class="btn btn-orange" href="cart.php">View Cart</a> <a class="btn btn-orange" href="checkout.php">Checkout</a> </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="categorymenu">
<nav class="subnav">
<ul class="nav-pills categorymenu container">
<li> <a class="active home" href="index.php"><i class="icon-home icon-white font18"></i> <span> Home</span></a></li>
<?= printTopcategory(); ?>
</ul>
</nav>
</div>
</header>
<!-- Header End -->