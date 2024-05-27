<?php
  include "./configs/connection.php";
  if (isset($_POST['register'])) {

    $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $cmd = $conn->prepare("INSERT INTO account_tbl (FirstName, MiddleName, LastName, Username, Pw) VALUES (?, ?, ?, ?, ?)");
    $cmd->bind_param("sssss", $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['username'], $hashed);
    $cmd->execute();
    
    $cmd->close();
  }
  $conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SpendSense | Login</title>
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
  <main>
    <form action="./signup.php" method="post">
      <h2>Register</h2>
      <div class="if-cont">
        <div class="input-field">
          <input type="text" name="firstname" id="firstname" required>
          <label for="firstname">First Name</label>
        </div>
        <div class="input-field">
          <input type="text" name="middlename" id="middlename" required>
          <label for="middlename">Middle Name</label>
        </div>
        <div class="input-field">
          <input type="text" name="lastname" id="lastname" required>
          <label for="lastname">Last Name</label>
        </div>
        <div class="input-field">
          <input type="text" name="username" id="username" required>
          <label for="username">Username</label>
        </div>
        <div class="input-field">
          <input type="password" name="password" id="password" required>
          <label for="password">Password</label>
        </div>
        <button type="submit"  name="register" value="register">
          Register
        </button>
        </div>
      </div>
    </form>
    <div class="divider">
      <div></div>
      <p>Already have an account?</p>
      <div></div>
    </div>
    <div class="register-btn-cont">
      <button>
        <a href="./login.php">
          Back to Login
        </a>
      </button>
    </div>
  </main>
</body>
</html>