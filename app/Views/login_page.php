<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - MenuScanOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body, html {
    height: 100%;
    margin: 0;
}

  body {
    background-image:url('<?= base_url("images/menu.jpeg"); ?>'); 
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
      margin: 0;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  }

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    background-image: url('<?= base_url("images/menu.jpeg"); ?>');
    background-size: cover;
    background-position: center center;
    background-blend-mode: darken;
    z-index: -1;
}

body * {
    position: relative;
    z-index: 1;
}

#page-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1;
}

.typing-effect {
    font-size: 4rem;
    color: white;
    border-right: 3px solid;
    padding-right: 5px;
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
    animation: typing 1s steps(10) infinite alternate;
  }
  
  @keyframes typing {
    from { width: 0 }
    to { width: 100% }
  }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">MenuScanOrder</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/MenuScanOrder/">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="mt-5">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6 d-none d-md-block">
                <h1 class="typing-effect">MenuScanOrder</h1>
            </div>
            <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title text-center">Login to Your Account</h2>
                    <form>
                      <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Enter email">
                      </div>
                      <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                      </div>
                      <p class="text-center">Log in with:</p>
                      <div class="d-flex flex-row justify-content-center">
                      <a href="login" class="btn btn-outline-danger me-2">
    <i class="fab fa-google me-1"></i> Google
</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</main>

<footer class="bg-dark text-light py-4 mt-5">
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