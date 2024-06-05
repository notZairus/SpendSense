<?php
  session_start();
  if (!isset($_SESSION['AID'])) {
    header("Location:./login.php");
    exit();
  }

  include "./configs/connection.php";
  include "./configs/user.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SpendSense | Dashboard</title>
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/sidebar.css">
  <link rel="stylesheet" href="../css/dashboard.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <script defer src="../js/sidebar.js"></script>
</head>
<body>

  <aside>
    <img src="../assets/arrow-double-end-svgrepo-com.svg" alt="menu-icon" id="arrow">
    <h1>SpendSense</h1>
    <ul class="nav">
      <li style="background-color: white;">
        <svg class="icon" fill="darkgreen" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
          <path d="M746.667 106.667H1173.33V1493.33H746.667V106.667ZM533.333 533.333H106.667V1493.33H533.333V533.333ZM1920 1706.67H0V1824H1920V1706.67ZM1813.33 746.667H1386.67V1493.33H1813.33V746.667Z"/>
        </svg>
        <p style="color: darkgreen">Dashboard</p>
      </li>

      <a href="./category.php">
        <li>
          <svg class="icon" fill="#FFFFFF" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M225.882 1298.412c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.882-225.883 225.882C101.308 1750.176 0 1648.868 0 1524.294s101.308-225.882 225.882-225.882ZM1920 1411.352v225.883H677.647v-225.882H1920ZM225.882 733.707c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.883-225.883 225.883C101.308 1185.47 0 1084.162 0 959.588c0-124.574 101.308-225.882 225.882-225.882ZM1920 846.647v225.882H677.647V846.647H1920ZM225.882 169c124.574 0 225.883 101.308 225.883 225.882S350.456 620.765 225.882 620.765C101.308 620.765 0 519.456 0 394.882 0 270.308 101.308 169 225.882 169ZM1920 281.941v225.883H677.647V281.94H1920Z" fill-rule="evenodd"/>
          </svg>
          <p>Category</p>
        </li>
      </a>
      
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
    <h1>Dashboard</h1>
    <main>

      <div class="Income" id="Income">
        <h2>INCOME</h2>
        <p class="amount"><span>₱</span> <?php echo $userData['Income'] ?></p>
      </div>
      <div class="Expense" id="Expense">
        <h2>EXPENSE</h2>
        <p class="amount"><span>₱</span> <?php echo $userData['Expense'] ?></p>
      </div>
      <div class="Balance" id="Balance">
        <h2>BALANCE</h2>
        <p class="amount"><span>₱</span> <?php echo $userData['Balance'] ?></p>
      </div>

      <div class="recent-transaction">
        <div class="header">
          <svg fill="#FFFFFF" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path d="M225.882 1298.412c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.882-225.883 225.882C101.308 1750.176 0 1648.868 0 1524.294s101.308-225.882 225.882-225.882ZM1920 1411.352v225.883H677.647v-225.882H1920ZM225.882 733.707c124.574 0 225.883 101.308 225.883 225.882s-101.309 225.883-225.883 225.883C101.308 1185.47 0 1084.162 0 959.588c0-124.574 101.308-225.882 225.882-225.882ZM1920 846.647v225.882H677.647V846.647H1920ZM225.882 169c124.574 0 225.883 101.308 225.883 225.882S350.456 620.765 225.882 620.765C101.308 620.765 0 519.456 0 394.882 0 270.308 101.308 169 225.882 169ZM1920 281.941v225.883H677.647V281.94H1920Z" fill-rule="evenodd"/>
          </svg>
          <h1>
            RECENT TRANSACTIONS
          </h1>
        </div>
        <div class="transactions">

          <?php while($row2 = $result2->fetch_assoc()) { 
            

            ?>

            

          <div class="transaction" style="background-color: green">
            <img src="../assets/analytics-svgrepo-com.svg" alt="category-icon">
            <div class="transaction-content">
              <p class="transaction-name">
                <?php echo $row2['TransactionName']?>
              </p>
              <p class=category-name>
              <?php echo $row2['CID']?>
              </p>
            </div>
            <p class="transaction-amount">
              ₱<?php echo $row2['TransactionAmount'] ?>
            </p>
          </div>

          <?php } ?>

        </div>
      </div>

      <div class="analytics">
        <canvas id="myChart"></canvas>
      </div>

    </main>
  </section>
</body>
</html>