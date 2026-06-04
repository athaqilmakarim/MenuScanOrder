<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MenuScanOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        body {
    background-color: #444444; 
      margin: 0;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

  main {
    flex: 1;
  }
  
  .custom-footer {
    background-color: #000000;
    color: white;
  }

  .menu-background {
    position: relative;
    color: white;
    justify-content: center; 
    background:url('<?= base_url("images/menu.jpeg"); ?>') no-repeat center center;
    background-size: cover;
    padding-top: 100px; 
    padding-bottom: 100px;
    min-height: 450px;
  }
  
  .menu-background::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }
  
  .menu-background .container {
    position: relative;
    z-index: 2;
  }

  .py-1{
    background-color: #4D5369;
    
    p{
      color: #F4F4F4;
    }
  }

  .py-5{
    background-color: #F4F4F4;
  }

  h1{
    color: #F4F4F4;
  }

header {
    background-color: #F4F4F4;
}

.carousel-item {
  height: 300px;
  padding-bottom: 50px;
}

.carousel-indicators {
  bottom: 10px;
}

html {
  height: 100%;
}
    </style>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg">
          <div class="container">
              <a class="navbar-brand" href="#">MenuScanOrder</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav ms-auto">
                      <li class="nav-item">
                          <a class="nav-link active" href="#">Home</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="login_page">Login</a>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
  </header>

  <main>
    <section class="menu-background">
        <div class="container">
          <div class="row justify-content-center align-items-center" style="min-height: 100%;">
            <div class="col-lg-6 text-center">
              <h1 class="display-4">MenuScanOrder</h1>
              <p class="lead">Streamline your restaurant's ordering process with digital menus and QR codes.</p>
              <a href="login_page" class="btn btn-primary btn-lg mb-3 mb-lg-0">Get Started</a>
            </div>
          </div>
        </div>
      </section>
      <section class="py-5 bg-light">
        <div class="container">
            <div id="featuresCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner text-center">
                    <div class="carousel-item active">
                        <div class="d-flex h-100 align-items-center justify-content-center">
                            <div>
                                <h3>Digital Menu Creation</h3>
                                <p>Allows businesses to easily create and manage a digital menu with categories, items, and pricing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex h-100 align-items-center justify-content-center">
                            <div>
                                <h3>QR Code Generation</h3>
                                <p>Automatically generates unique QR codes for each table, facilitating easy access to the menu by guests.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex h-100 align-items-center justify-content-center">
                            <div>
                                <h3>Seamless Ordering</h3>
                                <p>Guests can scan the QR code at their table to view the menu and place orders directly from their smartphones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex h-100 align-items-center justify-content-center">
                            <div>
                                <h3>Order Management</h3>
                                <p>Staff can view and manage orders in real time, ensuring a smooth dining experience for guests.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
  </main>

  <footer class="bg-dark text-light py-4">
      <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <p>&copy; 2024 MenuScanOrder. All rights reserved.</p>
              </div>
              <div class="col-md-6 text-md-end">
                  <a href="#" class="text-light me-3">Privacy Policy</a>
                  <a href="#" class="text-light">Terms of Service</a>
              </div>
          </div>
      </div>
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
