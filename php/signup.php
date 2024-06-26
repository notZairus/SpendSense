<?php
  include "./configs/connection.php";
  if (isset($_POST['register'])) {

    $image = $_FILES['profile-pic']['tmp_name'];
    $imageData = file_get_contents($image);
    
    $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $null = NULL;
    $cmd = $conn->prepare("INSERT INTO account_tbl (FirstName, MiddleName, LastName, Username, Pw, ProfileImage) VALUES (?, ?, ?, ?, ?, ?)");
    $cmd->bind_param("sssssb", $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['username'], $hashed, $null);
    $cmd->send_long_data(5, $imageData);
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
    <form action="./signup.php" method="post" enctype="multipart/form-data">
      <h2>Register</h2>
      <div class="if-cont">
        <div class="profile-pic-cont">
          <img src="../assets/notepad-svgrepo-com.svg" alt="" class="image-preview" id="image-preview">
          <input type="file" name="profile-pic" id="profile-pic" style="display: none;" accept=".jpg">
          <button type="button" class="select-img" id="select-img">Select Image</button>
        </div>
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
  <script>

    document.getElementById("select-img").addEventListener("click", (event) => {
      let target = event.target;
      document.getElementById("profile-pic").click();
    });

    document.getElementById("profile-pic").addEventListener("change", function (event) {
      if (this.files < 0) {
        return;
      }

      let selectedFile = this.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(selectedFile);

      reader.addEventListener("load", function (event) {
        let imagePreview = document.getElementById("image-preview");
        imagePreview.src = this.result;
      })
    })  

  </script>
</body>
</html>