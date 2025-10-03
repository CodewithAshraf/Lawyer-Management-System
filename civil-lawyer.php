<?php
session_start();
$isLoggedIn = isset($_SESSION['users']); // check if user is logged in
?>








<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Lawyer HTML-5 Template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="/Doc/css/main.css">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    


</head>
<style>
    a.links{
        text-decoration: none;
    }
    .header-btn{
        text-decoration: none;
        /* margin-left:30px;
        padding-left:-20px */
            position: relative;
    left: -60px;
    }
    .nav-item {
        margin-top: -40px;
    }
    #navigation li{
        margin-left:60px
    }
    li a{
        margin-left:-40px
    }
    #navigation{
        margin-left:50px
    }
    .submenu{
        margin-left: -100px;
    }
    .menu-main{
        margin-left:-500px
    }
   /* Nav links style */
/* Flex Layout */
.menu-main {
  padding: 10px 20px;
}
.header-right-btn{
    margin-top:-25px;
    margin-left:-30px;
    /* padd */
}
.tn{
    text-decoration:none;
    margin-left:-70px;
}
/* Nav Links */
#navigation {
  display: flex;
  /* gap: 10px; */
  list-style: none;
  padding: 0;
  /* margin: 0; */
}

#navigation .links {
  text-decoration: none;
  color: #000;
  font-weight: 500;
  position:relative;
  left:-80px
}
.rounded-circle{
    position: relative;
    left:-40px
}


/* Right Side */
.right-side {
  display: flex;
  align-items: center;
  /* gap: 20px; */
}

/* Button Style */
.header-btn {
  background-color: #2f4fff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  display: inline-block;
  margin-bottom: 20px;
}
.nav-link.dropdown-toggle i {
    font-size: 14px;
    margin-right: 5px;
    margin-left:-20px;
}
.submenu {
    white-space: nowrap; /* Prevents text from wrapping */
    /* overflow-x: auto;    Adds horizontal scroll if needed/ */
    display: inline-block; Keeps items in a single line
    /* width: 300px;         Ensures full width */
}
.header-area .main-header .main-menu ul ul.submenu{
    width:250px;
}
.submenu li {
    /* display: inline-block; Displays items side by side */
    /* margin-right: 15px;   Adds spacing between items */
       /* background: #f5f5f5;   Light gray background (optional) */
    border-radius: 5px;    /* Rounded corners */
    padding: 5px 70px;    /* Inner spacing (adjust as needed) */
    min-width: 150px;      /* Minimum width for consistency */
    text-align: center;    /* Centers text */
    white-space: nowrap;   /* Prevents text from breaking */
    position: relative;
    left: -100px;
}
.sub{
    text-decoration:none;
}
.slider-height2 {
    height: 250px;
    background-size: cover;
}
.center-side{
    justify-self: center;
    margin-bottom:40px;
    margin-left:120px;
}
</style>
<body class="body-bg">
<!--? Preloader Start -->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="assets/img/logo/loder.jpg" alt="">
            </div>
        </div>
    </div>
</div>
<header>
    <!--? Header Start -->
    <div class="header-area">
        <div class="main-header  header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2 col-md-1">
                        <div class="logo">
                            <a href="index.html"><img src="../bbbb.png" height="75" width="auto" alt=""></a>
                        </div>
                        <!-- <h2>Sentinel Advocates</h2> -->
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10">
 <!-- Main-menu -->
<!-- Main-menu (inside col-xl-10 or your layout container) -->
<div class="menu-main d-flex justify-content-end align-items-center">

  <!-- Left: Navigation -->
  <div class="main-menu d-none d-lg-block">
    <nav>
      <ul id="navigation">
        <li><a class="links" href="index.php">Home</a></li>
        <li><a class="links" href="about.php">About</a></li>
        <li><a class="links" href="services.php">Services</a>
        <ul class="submenu">
                                                    <li><a class="sub" href="health-law.php">Health Lawyer</a></li>
                                                    <li><a class="sub" href="insurance-law.php">Insurance Lawyer</a></li>
                                                    <li><a class="sub" href="vehical-accident law.php">Vehical Accident Lawyer</a></li>
                                                    <li><a class="sub" href="criminal-lawyer.php">Criminal Lawyer </a></li>
                                                    <li><a class="sub" href="divorce-lawyer.php">Divorce Lawyer</a></li>
                                                    <li><a class="sub" href="civil-lawyer.php">Civil Lawyer </a></li>
                                            </ul>
    </li>
        <li><a class="links" href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </div>
  

  <!-- Right: Dropdown + Button -->
  <div class="right-side d-flex align-items-center gap-3">
    
    <!-- Single Dropdown -->
    <?php if ($isLoggedIn): ?>
    <a href="appointment.php" class="header-btn">BOOK AN APPOINTMENT</a>
<?php else: ?>
    <a href="#" class="header-btn" onclick="alert('Please sign in to book an appointment.')">BOOK AN APPOINTMENT</a>
<?php endif; ?>

    <div class="nav-item dropdown">
      <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
       <!-- <i class="fa fa-caret-down"></i> -->

        <img class="rounded-circle me-lg-2" src="assets/img/pngwing.com.png" alt="" style="width: 30px; height: 30px;">
        <span class="d-none d-lg-inline-flex">
         <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
        </span>
      </a>
      <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0">
        <?php if ($isLoggedIn): ?>
          <a href="user_dashboard.php" class="dropdown-item">My Dashboard</a>
          <!-- <a href="settings.php" class="dropdown-item">Settings</a> -->
          <a href="logout.php" class="dropdown-item">Log Out</a>
        <?php else: ?>
          <a href="Signin.php" class="dropdown-item">Sign In</a>
          <a href="SignUp.php" class="dropdown-item">Signup</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Appointment Button -->
    

  </div>
</div>


  <!-- Dropdown Menu -->
  <div class="nav-item dropdown ml-40">
    <!-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
      <img class="rounded-circle me-lg-2" src="assets/img/pngwing.com.png" alt="" style="width: 30px; height: 30px;">
      <span class="d-none d-lg-inline-flex">

        
} ?>
      </span>
    </a>
     -->
  
</nav>

                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
<main>
        <!--? Hero Start -->
        <div class="slider-area2">
            <div class="slider-height2  d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 text-center">
                                <h2>Civil Lawyer</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-img"><img src="civil-lawyer(1).jpg" alt="" width="100%"></div>
       <div style="margin: 30px;">
        <h1><center>Neal Ramee</center></h1>
        <p> <center> Civil law systems rely on comprehensive, codified statutes created by legislatures, contrasting with common law systems that develop through judicial precedent. <br> In civil law, judges primarily apply the law as written in codes, while in common law, judges interpret and apply existing legal principles based on prior court decisions. <br> Civil law aims for a unified and coherent legal framework, often codified in comprehensive documents like the Napoleonic Code, while common law relies on case law to establish legal precedents. </center> </p>
        </div>
      <div class="center-side d-flex align-items-center gap-3">
    
    <!-- Single Dropdown -->
    <?php if ($isLoggedIn): ?>
    <a href="appointment.php" class="header-btn">BOOK AN APPOINTMENT</a>
<?php else: ?>
    <a href="#" class="header-btn" onclick="alert('Please sign in to book an appointment.')">BOOK AN APPOINTMENT</a>
<?php endif; ?>

                

                 </main>
<footer>
    <!--? Footer Start-->
    <div class="footer-area section-bg" data-background="assets/img/gallery/footer_bg.jpg">
        <div class="container">
            <div class="footer-top footer-padding">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-8">
                        <div class="single-footer-caption mb-50">
                            <!-- logo -->
                            <div class="footer-logo">
                                <a href="index.php"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                            </div>
                            <div class="footer-tittle">
                                <div class="footer-pera">
                                    <p class="info1">Receive updates and latest news direct from Simply enter.</p>
                                </div>
                            </div>
                            <div class="footer-number">
                                <h4><span>+564 </span>7885 3222</h4>
                                <p>youremail@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Our Support</h4>
                                <ul>
                                    <li><a href="#">Advanced</a></li>
                                    <li><a href="#"> Management</a></li>
                                    <li><a href="#">Corporate</a></li>
                                    <li><a href="#">Customer</a></li>
                                    <li><a href="#">Information</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Quick Link</h4>
                                <ul>
                                    <li><a href="#">New Law</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Licenses</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Newslatter</h4>
                                <div class="footer-pera">
                                    <p class="info1">Subscribe now to get daily updates</p>
                                </div>
                            </div>
                            <!-- Form -->
                            <div class="footer-form">
                                <div id="mc_embed_signup">
                                    <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative mail_part" novalidate="true">
                                        <input type="email" name="EMAIL" id="newsletter-form-email" placeholder=" Email Address " class="placeholder hide-on-focus" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your email address'">
                                        <div class="form-icon">
                                            <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm">
                                                Send
                                            </button>
                                        </div>
                                        <div class="mt-10 info"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-xl-9 col-lg-8">
                        <div class="footer-copy-right">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <!-- Footer Social -->
                        <div class="footer-social f-right">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.facebook.com/sai4ull"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fas fa-globe"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>

    <!-- JS here -->
    
    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>

    <!-- Nice-select, sticky -->
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>

    <!-- counter , waypoint -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src="./assets/js/jquery.counterup.min.js"></script>
    
    <!-- contact js -->
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/mail-script.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
    
    <!-- Jquery Plugins, main Jquery -->	
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>