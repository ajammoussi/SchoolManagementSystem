
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="iindex.css"> -->
    <link rel="stylesheet" href="style/landingPage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link rel="stylesheet" href="style/FieldsOfStudy.css">
    
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="style/footer.css">
    
    
</head>
<body>
    <!-- Start Landing Page -->
    <section class="landing-page" id="landing-page">
        <header>
          <div class="header-container">
            <a href="#" class="logo">
              <img src="src/logo-insat.png" alt="logo insat" class="logo-insat">
              INSAT <b>platform</b></a>
            <ul class="links">
              <li><a href="#landing-page">Home</a></li>
              <li><a href="#landing-page">About Us</a></li>
              <li><a href="#fieldsOfStudy">Fields of Study</a></li>
              <li><a href="#landing-page">Contact us</a></li>
              <li><button class="nav-btn nav-btn-login" onclick="window.location.href = './form/form.php';">Log in</button></li>
              <li><button class="nav-btn" >Get Started</button></li>
            </ul>
          </div>
        </header>
        <div class="header-content">
          <div class="header-container">
            <div class="header-info">
              <h1>Welcome to INSAT</h1>
              <p>At the National Institute of Applied Sciences and Technology (INSAT), we're dedicated to empowering minds and transforming lives through innovative education and cutting-edge research. As one of the leading institutions of higher learning in the region, INSAT is committed to excellence in engineering, sciences, and technology.</p>
              <a href="#fieldsOfStudy"><button class="learn-more-btn">learn more</button></a>
            </div>
          </div>
        </div>
      </section>
      <section class="fields-of-study" id="fieldsOfStudy">
        <div class="discover-fields-of-study">
          <span>discover</span>
          <h1>fields of study</h1>
          <hr>
          <p>Explore our diverse range of academic disciplines and fields of study.</p>
        </div>
        <div class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide swiper-slide--one">
              <div>
                <h2>Réseaux Informatiques et Télécommunications</h2>
                <p>
                    The Networks and Telecommunications program equips engineers to design, implement, and manage computer and telecommunications networks, facilitating efficient communication and connectivity across industries.
                </p>
                <!-- <a href="" target="_blank">explore</a> -->
              </div>
            </div>
            <div class="swiper-slide swiper-slide--two">
              <div>
                <h2>Genie Logiciel</h2>
                <p>Software Engineering program cultivates versatile engineers adept at leading projects, driving software solutions, and adapting to industry dynamics for career success.</p>
                <!-- <a href="" target="_blank">explore</a> -->
              </div>
            </div>
      
            <div class="swiper-slide swiper-slide--three">
      
              <div>
                <h2>Informatique Industrielle et Automatique</h2>
                <p>
                    The Industrial Computing and Automation program trains engineers in advanced computer techniques for automated production, fostering innovation and digital transformation in industry.
                </p>
                <!-- <a href="" target="_blank">explore</a> -->
              </div>
            </div>
      
            <div class="swiper-slide swiper-slide--four">
      
              <div>
                <h2>Instrumentation et Maintenance Industrielle</h2>
                <p>
                    The Industrial Computing and Automation program develops engineers proficient in advanced computer techniques for automated production, contributing to process optimization and digital transformation in industry.
                </p>
                <!-- <a href="" target="_blank">explore</a> -->
              </div>
            </div>
            <!-- note : you can add more slides with the same form -->
          </div>
          <!-- Add Pagination -->
          <div class="swiper-pagination"></div>
        </div>
      </section>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js"></script>
      <script src="index.js"></script>
      
</body>

<footer class="site-footer" id="about-us">
  <div class="container">
    <div class="row">
      <div class="About-text">
        <h6>About</h6>
        <p class="text-justify">Welcome to INSAT, the National Institute of Applied Sciences and Technology, where excellence meets innovation. Established in 1996, INSAT is dedicated to providing world-class engineering education, fostering cutting-edge research, and nurturing future leaders in various engineering disciplines.</p>
      </div>

      <div>
        <h6>Quick Links</h6>
        <ul class="footer-links">
          <li><a href="#landing-page">About Us</a></li>
          <li><a href="#contact-us">Contact Us</a></li>
          <li><a href="">Contribute</a></li>
          <li><a href="">Privacy Policy</a></li>
          
        </ul>
      </div>
    </div>
    <hr>
  </div>
  <div class="container">
    <div class="row">
      <div >
        <p class="copyright-text">Copyright &copy; 2024 All Rights Reserved by 
        <a href="#">insat</a>.
        </p>
      </div>

      <div >
        <ul class="social-icons">
          <li><a class="facebook" href="https://www.facebook.com/insat.rnu.tn"><i class="fa fa-facebook"></i></a></li>
          <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
          <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
          <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>   
        </ul>
      </div>
    </div>
  </div>
</footer>
</html>



