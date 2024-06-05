<?php

  $cmd = $conn->prepare("SELECT * FROM account_tbl WHERE AID = ?");
  $cmd->bind_param("i", $_SESSION['AID']);
  $cmd->execute();
  $result = $cmd->get_result();
  $userData = $result->fetch_assoc();

  $name;
  if ($userData['MiddleName'] == NULL) {
    $name = $userData['FirstName'] . " " . $userData['LastName'];
  }
  else {
    $name = ucfirst($userData['FirstName']) . " " . strtoupper($userData['MiddleName'][0]) . ". " . ucfirst($userData['LastName']);
  }

  $cmd->close();

  
  $cmd2 = $conn->prepare("SELECT * FROM transaction_tbl WHERE AID = ? LIMIT 8");
  $cmd2->bind_param("i", $_SESSION['AID']);
  $cmd2->execute();
  $result2 = $cmd2->get_result();
  $cmd2->close();

