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


