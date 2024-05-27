<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SpendSense | Login</title>
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <h1>SpendSense</h1>
  <main>
    <form action="" method="post">
      <h2>Login</h2>
      <div class="if-cont">
        <div class="input-field">
          <input type="text" name="username" id="username" required>
          <label for="username">Username</label>
        </div>
        <div class="input-field">
          <input type="password" name="password" id="password" required>
          <label for="password">Password</label>
        </div>
        <button type="reset">
          LOGIN
        </button>
        </div>
      </div>
    </form>
    <div class="divider">
      <div></div>
      <p>Dont have an account?</p>
      <div></div>
    </div>
    <div class="register-btn-cont">
      <button type="reset">
        <a href="./signup.html">Register</a>
      </button>
    </div>
  </main>
</body>
</html>