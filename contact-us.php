<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap 5 -->
  <link rel="stylesheet" href="custom-sass/main.min.css">
  <!-- global stylesheet -->
  <link rel="stylesheet" href="css/global.css">
  <!-- custom css -->
  <link rel="stylesheet" href="css/contact-us.css">
  <title>Contact Us</title>
</head>

<body class="d-flex flex-column vh-100" onload="renderCountriesAndStore()">
<header>


    <!-- navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" id="navbar">
    
    <div class="bg-gold top-bar d-block" id="gold-bar">
      <div class="languages">
					<a href="#en" id='en' class="translate">English</a>
          <a href="#fr" id='fr' class="translate">Français</a>
      </div>
    </div>

      <div class="container-fluid mt-5">
        <a class="navbar-brand" href="index.html" id="logo"><img width="220px" id="logo_img" src="images/Q7_white_nobg.png"
            alt="Company-logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0 container-fluid">
            <li class="nav-item mx-xxl-3">
              <a class="nav-link lang" href="about-us.html" key="about"></a>
            </li>
            <li class="nav-item mx-xxl-3">
              <a class="nav-link lang" href="training.html" key="training"></a>
            </li>
            <li class="nav-item mx-xxl-3">
              <a class="nav-link lang" href="consulting.html" key="consulting"></a>
            </li>
            <li class="nav-item mx-xxl-3">
              <a class="nav-link lang" href="events-webinars.html" key="events"></a>
            </li>
            <li class="nav-item mx-xxl-3">
              <a class="nav-link lang" href="contact-us.html" key="contact"></a>
            </li>
          </ul>
          <div class="nav-item col-lg-3 searchbar">
            <form class="d-flex input-group">
              <input class="form-control " type="search" placeholder="" aria-label="Search">
              <button class="btn btn-outline-light" type="submit"><img id="search" src="images/icons/magglass_gray.svg" alt="Search"
                  width="25px" height="25px"></button>
            </form>
          </div>
        </div>
      </div>
    </nav>
  </header>


  <!-- contact form -->
  <div class="container mt-5 p-4 shadow">
    <div class="row mt-2">
      <div class="col-7">
        <h3 class="text-gold fw-bold mb-3 lang" key="contact"></h3>
        <form action="_includes/send_inquiry.php" method="POST">
          <div class="row mb-3">
            <div class="col-lg-6">
              <label for="first-name" class="form-label my-2 required lang" key="contact-first-name"></label>
              <input type="text" class="form-control" id="first-name" name="first-name" required>
            </div>
            <div class="col-lg-6">
              <label for="last-name" class="form-label my-2 required lang" key="contact-last-name"></label>
              <input type="text" class="form-control" id="last-name" name="last-name" required>
            </div>
            <div class="col-lg-6">
              <label for="email" class="form-label my-2 required lang" key="contact-email"></label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-lg-6">
              <label for="phone" class="form-label my-2 not-required lang" key="contact-phone"></label>
              <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="col-lg-4">
              <label for="country" class="form-label my-2 required lang" key="contact-country"></label>
              <select id="country" class="form-select" name="country" onchange="getState()" required>
                <option value="">Choose a country</option>
              </select>
            </div>
            <div class="col-lg-4">
              <label for="state" class="form-label my-2 not-required lang" key="contact-state"></label>
              <select id="state" class="form-select" name="state" onchange="getCity()">
                <option value="">-</option>
              </select>
            </div>
            <div class="col-lg-4">
              <label for="city" class="form-label my-2 not-required lang" key="contact-city"></label>
              <input list="city" class="form-control" id="city-choice" name="city-choice"/>
              <datalist id="city"  name="city">
                <option value="-"></option>
              </datalist>
            </div>
            <div class="col-lg-12">
              <label for="subject" class="form-label my-2 required lang" key="contact-subject"></label>
              <select id="subject" class="form-select" name="subject" required>
                <option value="" selected disabled></option>
                <option value="Lorem ipsum">Lorem ipsum Option 1</option>
                <option value="Lorem ipsum">Lorem ipsum Option 2</option>
              </select>
            </div>
            <div class="col-lg-12">
              <label for="message" class="form-label my-2 required lang" key="contact-message"></label>
              <textarea class="form-control" id="message" rows="10" name="message" required></textarea>
            </div>
          </div>
          <button type="submit" name="submit" class="btn-lg btn-gold text-white lang" key="contact-send"></button>
        </form>
      </div>
      <div class="col-5 py-5 ps-4">
        <div class="h-50">
          <h4 class="text-gold lang" key="contact-info"></h4>
          <h5 class="lang" key="contact-headquarters"></h5>
          <p class="mb-md-0">1000 de la Gauchetière Ouest, suite 2400 Montréal, QC H3B 4W5</p>
          <p class="mb-md-0"><span class="text-decoration-underline lang" key="contact-our-phone"></span>  +1 514 448-2246</p>
          <p><span class="text-decoration-underline lang" key="contact-fax"></span> +1 514 448 5101</p>
        </div>

        <h4 class="text-gold lang" key="contact-why"></h4>
        <p class="lang" key="contact-why-text"></p>
      </div>
    </div>
  </div>

  <!-- footer -->
  <footer>
    <div class="mt-5 bg-dark p-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-2 col-md-4 text-secondary ft-border-right">
            <div class="ms-3 ms-sm-0"> 
              <h5 class="text-lightGold">Services</h5>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, sequi. Minima quasi sunt adipisci vitae.
              </p>
              <ul class="d-flex flex-row ms-n3 nav">
                <li class="nav-item">
                  <a class="nav-link pe-1" href="" target="_blank">
                    <img src="./images/icons/facebook.svg" alt="Facebook" width="30px">
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link pe-1" href="#" target="_blank">
                    <img src="./images/icons/twitter.svg" alt="Twitter" width="30px">
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link pe-1" href="#" target="_blank">
                    <img src="./images/icons/linkedin.svg" alt="LinkedIn" width="30px">
                  </a>
                </li>
              </ul>
            </div>
          </div>
          
          <div class="d-block d-md-none">
            <hr class="text-secondary opacity-100">
          </div>
          
          <div class="col-lg-4 col-md-8 col-sm-12 col-12 mb-4">
            <div class="row">
              <div class="col-6 ps-md-4">
                <h5 class="text-lightGold">Categories</h5>
                <ul class="flex-column ms-n3 nav">
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Product</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">About Us</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Testimonials</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Price Table</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Crew</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Portfolio</a>
                  </li>
                </ul>
              </div>
              <div class="col-6 d-flex d-md-block d-lg-flex  justify-content-end">
                <div>
                  <h5 class="text-lightGold">Partners</h5>
                <ul class="flex-column ms-n3 nav">
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Lorem Ipsum</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Lorem Ipsum</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Lorem Ipsum</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-secondary py-1" href="#">Lorem Ipsum</a>
                  </li>
                </ul>
                </div>
                
              </div>
            </div>
          </div>
          
          <div class="d-block d-lg-none">
            <hr class="text-secondary opacity-100">
          </div>
  
          <div class="col-lg-6 text-secondary p-lg-5 ft-border-left">
            <p class="text-lightGold text-center fw-bolder">
              Sign up for our newsletter
            </p>
            <div class="d-md-flex">
              <input type="text" class="form-control rounded-0" placeholder="Enter your email here...">
              <div class="text-center">
                <button class="btn btn-gold text-white rounded-0">SUBSCRIBE</button>
              </div>
            </div>          
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <!-- translation JS-->
    <script src="js/scripts.js"></script>
    <script src="js/translations.js"></script>
    <!-- countrycitystate api js -->
    <script src="js/countrystatecity.js"></script>
    <!-- JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>