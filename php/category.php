<?php

  session_start();

  include "./configs/connection.php";
  include "./configs/user.php";

  if (!isset($_SESSION['AID'])) {
    header("Location:./login.php");
    exit();
  }


  //FOR CREATING CATEGORY
  if (isset($_POST['create-category'])) {

    if($_FILES['category-image']['error'] === UPLOAD_ERR_OK) {

      $exist = false;

      //CHECK IF THE CATEGORY IS A DEFAULT ONE.
      $default = $conn->prepare("SELECT COUNT(*) as count FROM category_tbl WHERE CreatorAID = 0 AND CategoryName = ?");
      $default->bind_param("s", $_POST['category-name']);
      $default->execute();
      $result = $default->get_result();
      $row1 = $result->fetch_assoc();
      if ($row1['count'] != 0) {
        $exist = true;
        echo "<script> alert('This is a default category') </script>";
      }
      $default->close();

      //CHECK IF THE CATEGORY ALREADY EXIST.
      $cmd = $conn->prepare("SELECT COUNT(*) as count FROM category_tbl WHERE CreatorAID = ? AND CategoryName = ?");
      $cmd->bind_param("is", $userData['AID'], $_POST['category-name']);
      $cmd->execute();
      $result = $cmd->get_result();
      $row2 = $result->fetch_assoc();
      if ($row2['count'] != 0) {
        $exist = true;
        echo "<script> alert('This is an existing category') </script>";
      }
      $cmd->close();

      //IF IT DOESN'T EXIST, INSERT IT ON DATABASE
      if (!$exist) {
        $selectedIcon = $_FILES['category-image']['tmp_name'];
        $IconData = file_get_contents($selectedIcon);

        $cmd2 = $conn->prepare("INSERT INTO category_tbl (CategoryName, CategoryICon, CreatorAID, CategoryType) VALUES (?, ?, ?, ?)");
        $cmd2->bind_param("sbis", $_POST['category-name'], $null, $userData['AID'], $_POST['category-type']);
        $cmd2->send_long_data(1, $IconData);
        
        if ($cmd2->execute()) {
          echo "<script> alert('Category created sucessfully!') </script>";
        }
        $cmd2->close();
      }
    }
    else {
      echo "<script> alert('You must select an icon to create a new category'); </script>";
    }
  }
  

  //FOR DELETING CATEGORY
  if(isset($_POST['delete-category'])) {
    $cmd = $conn->prepare("DELETE FROM category_tbl WHERE CID = ?");
    $cmd->bind_param("i", $_POST['delete-category']);
    $cmd->execute();
    
    echo "<script> alert('Deleted Successfuly!') </script>";
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SpendSense | Category</title>
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/sidebar.css">
  <link rel="stylesheet" href="../css/category.css">

  
  <script defer src="../js/sidebar.js"></script>
  <script defer src="../js/category.js"></script>
</head>
<body>

  <aside>
    <img src="../assets/arrow-double-end-svgrepo-com.svg" alt="menu-icon" id="arrow">
    <h1>SpendSense</h1>
    <ul class="nav">
      <a href="./dashboard.php">
        <li>
          <svg class="icon" fill="#FFFFFF" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M746.667 106.667H1173.33V1493.33H746.667V106.667ZM533.333 533.333H106.667V1493.33H533.333V533.333ZM1920 1706.67H0V1824H1920V1706.67ZM1813.33 746.667H1386.67V1493.33H1813.33V746.667Z"/>
          </svg>
          <p>Dashboard</p>
        </li>
      </a>
      
      <li style="background-color: white;">
        <svg class="icon" fill="darkgreen" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
          <path d="M225.882 1298.412c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.882-225.883 225.882C101.308 1750.176 0 1648.868 0 1524.294s101.308-225.882 225.882-225.882ZM1920 1411.352v225.883H677.647v-225.882H1920ZM225.882 733.707c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.883-225.883 225.883C101.308 1185.47 0 1084.162 0 959.588c0-124.574 101.308-225.882 225.882-225.882ZM1920 846.647v225.882H677.647V846.647H1920ZM225.882 169c124.574 0 225.883 101.308 225.883 225.882S350.456 620.765 225.882 620.765C101.308 620.765 0 519.456 0 394.882 0 270.308 101.308 169 225.882 169ZM1920 281.941v225.883H677.647V281.94H1920Z" fill-rule="evenodd"/>
        </svg>
        <p style="color: darkgreen">Category</p>
      </li>

      <a href="./transaction.php">
        <li>
          <svg class="icon" fill="#FFFFFF" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <g fill-rule="evenodd">
                <path d="M1164.23 160.333h304.01v337.82L840.282 1126.11c-31.623 31.62-49.694 74.54-49.694 119.71v395.3h395.292c45.18 0 88.1-18.07 119.72-49.7l162.64-162.63V1867H0V160.333h329.104C351.069 98.19 410.335 53.667 480 53.667h533.33c69.67 0 128.93 44.523 150.9 106.666Zm-737.563 53.334c0-29.456 23.878-53.334 53.333-53.334h533.33c29.46 0 53.34 23.878 53.34 53.334v160H426.667v-160Z"/>
                <path d="m1677.57 528.308 225.88 225.882c22.02 22.024 22.02 57.713 0 79.85l-677.65 677.65c-10.62 10.5-24.96 16.49-39.98 16.49H903.467v-282.36c0-15.02 5.986-29.36 16.489-39.87L1597.6 528.308c22.14-22.137 57.83-22.137 79.97 0Zm-129.55 209.28 146.03 146.033 89.56-89.562-146.03-146.033-89.56 89.562Z"/>
            </g>
          </svg>
          <p>Transaction</p>
        </li>
      </a>

    </ul>
    <div class="user-profile">
      <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($userData['ProfileImage']); ?>" alt="" id="profile-pic" class="profile-pic">
      <p class="name" id="name"><?php echo $name?></p>
    </div>
  </aside>

  <section>
    <h1>Category</h1>
    <main>
      <div class="new-category">
        <h1>New Category</h1>
        <div class="form-wrapper">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="image-container">
              <img src="../assets/arrow-double-end-svgrepo-com.svg" alt="new-category-image">
              <input type="file" id="category-image-input" name="category-image" style="display: none;" accept=".svg">
              <button type="button" id="catimg-btn">Select Category Icon</button>
            </div>
            <div class="name-container">
              <input type="text" name="category-name" placeholder="Category Name">
              <div class="cat-type-cont">
                <p>Category Type:</p>
                <div class="ifgroup">
                  <input type="radio" id="inc" name="category-type" value="Income" checked>
                  <label for="inc">Income</label>
                </div>
                <div class="ifgroup">
                  <input type="radio" id="exp" name="category-type" value="Expense">
                  <label for="exp">Expense</label>
                </div>
              </div>
            </div>
            <button class="create-cat-btn" name="create-category" value="create-cat">Create Category</button>
          </form>
        </div>
      </div>
      <div class="categories">
        <h1>Categories</h1>
        <div class="category-type-cont">
          <div class="category-type">
            <h1 style="background-color: #08CE08;">Income</h1>
            <div class="existing-category-cont">

            <?php
              $cmd = $conn->prepare("SELECT * FROM category_tbl WHERE CategoryType = 'Income' AND CreatorAID = 0 OR CategoryType = 'Income' AND CreatorAID = ?");
              $cmd->bind_param("s", $userData['AID']);
              $cmd->execute();
              $result = $cmd->get_result();

              while($row = $result->fetch_assoc()) {
            ?>

              <div class="single-category" style="background-color: #08CE08;">
                <div class="category-content">
                  <p><?php echo $row['CategoryName'] ?></p>
                </div>

                <?php if ($row['CreatorAID'] != 0) {
                  echo
                  "<div class='category-delete-button'>
                    <form action='./category.php' method='POST'>
                      <button name='delete-category' value='".$row['CID']."'>
                        Delete Category
                      </button>
                    </form>
                  </div>";
                }?>

                
              </div>

              <?php 
                } 
                $cmd->close();
              ?>
              
            </div>
          </div>
          <div class="category-type">
            <h1 style="background-color: #FF0808;">Expense</h1>
            <div class="existing-category-cont">

              <?php
                $cmd = $conn->prepare("SELECT * FROM category_tbl WHERE CategoryType = 'Expense' AND CreatorAID = 0 OR CategoryType = 'Expense' AND CreatorAID = ?");
                $cmd->bind_param("s", $userData['AID']);
                $cmd->execute();
                $result = $cmd->get_result();

                while($row = $result->fetch_assoc()) {
              ?>

              <div class="single-category" style="background-color: #FF0808;">
                <div class="category-content">
                  <p><?php echo $row['CategoryName'] ?></p>
                </div>

                <?php if ($row['CreatorAID'] != 0) {
                  echo
                  "<div class='category-delete-button'>
                    <form action='./category.php' method='post'>
                      <button name='delete-category' value='".$row['CID']."'>
                        Delete Category
                      </button>
                    </form>
                  </div>";
                }?>

                  
                </div>

                <?php } ?>
              
            </div>
          </div>
        </div>
      </div>
    </main>
  </section>

</body>
</html>