<?php
session_start();
$isLoggedIn = isset($_SESSION['lawyer_id']);

include("../conn.php");

$lawyerName = 'Guest'; // Default name
$lawyerImage = 'assets/img/pngwing.com.png'; // Default image

if (isset($_SESSION['lawyer_id'])) {
    $lawyer_id = $_SESSION['lawyer_id'];

    // Prepare and execute query
    $query = "SELECT u_name, p_img FROM lawyer WHERE u_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $lawyer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $lawyerName = $data['u_name']; // Correct column for name

        if (!empty($data['p_img']) && file_exists('uploads/' . $data['p_img'])) {
            $lawyerImage = 'uploads/' . $data['p_img'];
        }
    }
}
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
    .header-right-btn{
    margin-top:-25px;
    margin-left:-30px;
    
}
.header-right-btn{
    margin-top:-25px;
    margin-left:-30px;
    
}
.sub{
    text-decoration:none;
    font-size: 5px;
    margin-left:-15px
}
.submenu li{
    position: relative;
    left:-10px
}
.submenu{
    margin-left:-80px;
    width:100px;
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



.right-side {
  display: flex;
  align-items: center;

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
  /* margin-top:-20px; */
}
.nav-link.dropdown-toggle i {
    font-size: 14px;
    margin-right: 5px;
    margin-left:-20px;
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
                            <a href="index.php"><img src="../bbbb.png" height="75" width="auto" alt=""></a>
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
        <li><a class="links" href="../services.php">Services</a>
        <ul class="submenu">
                                                    <li><a class="sub" href="../health-law.php">Health Lawyer</a></li>
                                                    <li><a class="sub" href="../insurance-law.php">Insurance Lawyer</a></li>
                                                    <li><a class="sub" href="../vehical-accident law.php">Vehical Accident Lawyer</a></li>
                                                    <li><a class="sub" href="../criminal-lawyer.php">Criminal Lawyer </a></li>
                                                    <li><a class="sub" href="../divorce-lawyer.php">Divorce Lawyer</a></li>
                                                    <li><a class="sub" href="../civil-lawyer.php">Civil Lawyer </a></li>
                                            </ul>
    </li>
        <li><a class="links" href="../contact.php">Contact</a></li>
      </ul>
    </nav>
  </div>
  

  <!-- Right: Dropdown + Button -->
  <div class="right-side d-flex align-items-center gap-3">
    
    <!-- Single Dropdown -->
    <?php if ($isLoggedIn): ?>
    <a href="lawyer_dashboard.php" class="header-btn">My Dashboard</a>
<?php else: ?>
    <a href="#" class="header-btn" onclick="alert('Please sign in to view the Dashboard.')">My Dashboard</a>
<?php endif; ?>
<!-- Replace your current dropdown code with this: -->
<div class="nav-item dropdown">
  <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-user-circle"></i> <!-- Font Awesome user icon -->
    <span class="d-none d-lg-inline-flex">
      <?php echo htmlspecialchars($lawyerName); ?>
    </span>
  </a>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <?php if ($isLoggedIn): ?>
      <a href="lawyer_dashboard.php" class="dropdown-item">My Dashboard</a>
      <a href="logout.php" class="dropdown-item">Log Out</a>
    <?php else: ?>
      <a href="lawyerSignin.php" class="dropdown-item">Sign In</a>
      <a href="lawyersignup.php" class="dropdown-item">Signup</a>
    <?php endif; ?>
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
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 text-center">
                                <h2>About</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        <!--? About Area start -->
        <section class="about-details-area about1 section-padding30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-10">
                    <div class="about-caption2 mb-50">
                        <h3>Haw we deal Our Cases</h3>
                        <div class="send-cv">
                            <a href="#">youremail@colorlib.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-10">
                    <div class="about-caption mb-50">
                        <h3>You can’t use up creativity. The more you use, the
                            more you have in your signifant mind.</h3>
                        <div class="experience">
                            <div class="year">
                                <span>05</span>
                            </div>
                            <div class="year-details"><p>YEARS OF<br> DIGITAL EXPERIENCE</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
         <!--? About Area Start-->
        <div class="about-area fix">
            <!--Right Contents  -->
            <div class="about-img"></div>
            <!-- left Contents -->
            <div class="about-details">
                <div class="right-caption">
                    <!-- Section Tittle -->
                    <div class="section-tittle section-tittle2 mb-50">
                        <span>About Our Law agency</span>
                        <h2>We are commited for<br> better service</h2>
                    </div>
                    <div class="about-more">
                        <p class="pera-top">Mollit anim laborum duis adseu dolor iuyn voluptcate velit ess <br>cillum dolore egru lofrre dsu.</p>
                        <p class="mb-65 pera-bottom">Mollit anim laborum.Dvcuis aute serunt  iruxvfg dhjkolohr indd re voluptate velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjnt occa cupidatat non aute iruxvfg dhjinulpadeserunt moll.</p>
                        <a href="about.html" class="btn post-btn">Learn About Us</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- About Area End-->
        <!-- Team Start -->
        <div class="team-area section-padding30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle mb-70">
                            <span>Our lawyers </span>
                            <h2>Meet Our Dedicated Team Members.</h2>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <!-- single Tem -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/team2.png" alt="">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">Ethan Welch</a></h3>
                                <span>Chir Lawyer</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/team3.png" alt="">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">Trevor Stanley</a></h3>
                                <span>Junior Lawyer</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/team1.png" alt="">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">Allen Guzman</a></h3>
                                <span>Senior Lawyer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->
        <!--? Testimonial Start -->
        <div class="testimonial-area testimonial-padding" data-background="assets/img/gallery/section_bg04.png">
            <div class="container ">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-md-9">
                        <div class="h1-testimonial-active">
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <div class="testimonial-top-cap">
                                        <svg 
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="67px" height="49px">
                                       <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                                        d="M57.053,48.208 L42.790,48.208 L52.299,29.240 L38.036,29.240 L38.036,0.790 L66.562,0.790 L66.562,29.240 L57.053,48.208 ZM4.755,48.208 L14.263,29.240 L0.000,29.240 L0.000,0.790 L28.527,0.790 L28.527,29.240 L19.018,48.208 L4.755,48.208 Z"/>
                                       </svg>
                                        <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis por incididunt ut labore et dolore mas. </p>
                                    </div>
                                    <!-- founder -->
                                    <div class="testimonial-founder d-flex align-items-center justify-content-center">
                                        <div class="founder-img">
                                            <img src="assets/img/gallery/Homepage_testi.png" alt="">
                                        </div>
                                        <div class="founder-text">
                                            <span>Oliva jems</span>
                                            <p>Chif Lawyer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <div class="testimonial-top-cap">
                                        <svg 
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="67px" height="49px">
                                       <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                                        d="M57.053,48.208 L42.790,48.208 L52.299,29.240 L38.036,29.240 L38.036,0.790 L66.562,0.790 L66.562,29.240 L57.053,48.208 ZM4.755,48.208 L14.263,29.240 L0.000,29.240 L0.000,0.790 L28.527,0.790 L28.527,29.240 L19.018,48.208 L4.755,48.208 Z"/>
                                       </svg>
                                        <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis por incididunt ut labore et dolore mas. </p>
                                    </div>
                                    <!-- founder -->
                                    <div class="testimonial-founder d-flex align-items-center justify-content-center">
                                        <div class="founder-img">
                                            <img src="assets/img/gallery/Homepage_testi.png" alt="">
                                        </div>
                                        <div class="founder-text">
                                            <span>Oliva jems</span>
                                            <p>Chif Lawyer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->
        <!-- Blog Area Start -->
        <div class="home-blog-area section-padding30">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-7">
                        <div class="section-tittle mb-100">
                            <span>Insight and Trends  Articles</span>
                            <h2>Lawyers news from around the world selected by us.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="home-blog-single mb-30">
                            <div class="blog-img-cap">
                                <div class="blog-img">
                                    <img src="assets/img/gallery/home_blog1.png" alt="">
                                    <ul>
                                        <li>By Admin   -   October 27, 2020</li>
                                    </ul>
                                </div>
                                <div class="blog-cap">
                                    <h3><a href="blog_details.html">16 Easy Ideas to Use in Our Everyday
                                        Stuff in Kitchen.</a></h3>
                                    <p>Amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magnua Quis ipsum suspendisse ultrices gra.</p>
                                    <a href="blog_details.html" class="more-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="home-blog-single mb-30">
                            <div class="blog-img-cap">
                                <div class="blog-img">
                                    <img src="assets/img/gallery/home_blog2.png" alt="">
                                    <ul>
                                        <li>By Admin   -   October 27, 2020</li>
                                    </ul>
                                </div>
                                <div class="blog-cap">
                                    <h3><a href="blog_details.html">16 Easy Ideas to Use in Our Everyday
                                        Stuff in Kitchen.</a></h3>
                                    <p>Amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magnua Quis ipsum suspendisse ultrices gra.</p>
                                    <a href="blog_details.html" class="more-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Area End -->
        
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
                                    <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
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
		<!-- All JS Custom Plugins Link Here here -->
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
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        
    </body>
</html>