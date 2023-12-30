<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-md-12 col-lg-5">
        <div class="card">
          <div class="card-body">
            <div id="response"></div>
            <form id="login-form" class="mb-0" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
              </div>
              <button type="button" class="btn btn-primary mt-2" onclick="login()">
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/user.js"></script>
</body>

</html>