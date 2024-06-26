<?php

  session_start();

  include "./configs/connection.php";
  include "./configs/user.php";

  if (!isset($_SESSION['AID'])) {
    header("Location:./login.php");
    exit();
  }

  if (isset($_POST['new-transaction'])) {
    
    $category_id = $_POST['transaction-category-id'];
    
    $cmd = $conn->prepare("SELECT * FROM category_tbl WHERE CID = ?");
    $cmd->bind_param("i", $category_id);
    $cmd->execute();
    $result = $cmd->get_result();
    $cmd->close();
    
    $category = $result->fetch_assoc();
    $currentDate = date('Y-m-d');

    $cmd=$conn->prepare("INSERT INTO transaction_tbl (TransactionName, TransactionAmount, AID, CID, TransactionType, TransactionCategory, TransactionIcon, TransactionDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $cmd->bind_param("siiissbs", $_POST['transaction-name'], $_POST['transaction-amount'], $userData['AID'], $category['CID'], $category['CategoryType'], $category['CategoryName'], $null, $currentDate);
    $cmd->send_long_data(6, $category['CategoryIcon']);
    if($cmd->execute()) {
      echo "<script> alert('Transaction added successfully!'); </script>";
    }

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
  <link rel="stylesheet" href="../css/transaction.css">

  
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
      
      <a href="./category.php">
        <li>
          <svg class="icon" fill="#FFFFFF" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M225.882 1298.412c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.882-225.883 225.882C101.308 1750.176 0 1648.868 0 1524.294s101.308-225.882 225.882-225.882ZM1920 1411.352v225.883H677.647v-225.882H1920ZM225.882 733.707c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.883-225.883 225.883C101.308 1185.47 0 1084.162 0 959.588c0-124.574 101.308-225.882 225.882-225.882ZM1920 846.647v225.882H677.647V846.647H1920ZM225.882 169c124.574 0 225.883 101.308 225.883 225.882S350.456 620.765 225.882 620.765C101.308 620.765 0 519.456 0 394.882 0 270.308 101.308 169 225.882 169ZM1920 281.941v225.883H677.647V281.94H1920Z" fill-rule="evenodd"/>
          </svg>
          <p >Category</p>
        </li>
      </a>

      <li style="background-color: white;">
        <svg class="icon" fill="green" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
          <g fill-rule="evenodd">
              <path d="M1164.23 160.333h304.01v337.82L840.282 1126.11c-31.623 31.62-49.694 74.54-49.694 119.71v395.3h395.292c45.18 0 88.1-18.07 119.72-49.7l162.64-162.63V1867H0V160.333h329.104C351.069 98.19 410.335 53.667 480 53.667h533.33c69.67 0 128.93 44.523 150.9 106.666Zm-737.563 53.334c0-29.456 23.878-53.334 53.333-53.334h533.33c29.46 0 53.34 23.878 53.34 53.334v160H426.667v-160Z"/>
              <path d="m1677.57 528.308 225.88 225.882c22.02 22.024 22.02 57.713 0 79.85l-677.65 677.65c-10.62 10.5-24.96 16.49-39.98 16.49H903.467v-282.36c0-15.02 5.986-29.36 16.489-39.87L1597.6 528.308c22.14-22.137 57.83-22.137 79.97 0Zm-129.55 209.28 146.03 146.033 89.56-89.562-146.03-146.033-89.56 89.562Z"/>
          </g>
        </svg>
        <p style="color: darkgreen">Transaction</p>
      </li>

    </ul>
    <div class="user-profile">
      <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($userData['ProfileImage']); ?>" alt="" id="profile-pic" class="profile-pic">
      <p class="name" id="name"><?php echo $name?></p>
    </div>
  </aside>

  <section>
    <h1>Transaction</h1>
    <main>
      <div class="form-wrapper">
        <h1>New Transaction</h1>
        <form action="./transaction.php" method="POST">
          <div class="input-field">
            <label for="transaction-name">Transaction Name:</label>
            <input type="text" id="transaction-name" name="transaction-name" required>
          </div>

          <div class="input-field">
            <label for="transaction-amount">Transaction Amount:</label>
            <input type="number" id="transaction-amount" name="transaction-amount" required>
          </div>

          <div class="input-field">
            <label for="transaction-category-id">Category:</label>
            <select name="transaction-category-id" id="transaction-category-id" required>

              <?php
                $cmd = $conn->prepare("SELECT * FROM category_tbl WHERE CreatorAID = 0 AND CategoryType = 'Income' OR CreatorAID = ? AND CategoryType = 'Income'");
                $cmd->bind_param("i", $userData['AID']);
                $cmd->execute();

                $result = $cmd->get_result();
                $cmd->close();
              ?>

              <optgroup label="Income">
                <?php while($row = $result->fetch_assoc()) { ?>
                  <?php echo "<option value='".$row['CID']."'>".$row['CategoryName']."</option>" ?>
                <?php } ?>
              </optgroup>


              <?php
                $cmd = $conn->prepare("SELECT * FROM category_tbl WHERE CreatorAID = 0 AND CategoryType = 'Expense' OR CreatorAID = ? AND CategoryType = 'Expense'");
                $cmd->bind_param("i", $userData['AID']);
                $cmd->execute();

                $result = $cmd->get_result();
                $cmd->close();
              ?>

              <optgroup label="Expense">
                <?php while($row = $result->fetch_assoc()) { ?>
                  
                  <?php echo "<option value='".$row['CID']."'>".$row['CategoryName']."</option>" ?>
                <?php } ?>
              </optgroup>
            </select>
          </div>
          <div class="input-field">
            <button name="new-transaction" value="new-transaction">Confirm Transaction</button>
          </div>
        </form>
      </div>
    </main>
  </section>

</body>
</html>