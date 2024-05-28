<?php

  $cmd = $conn->prepare("SELECT * FROM account_tbl WHERE AID = ?");
  $cmd->bind_param("i", $_SESSION['AID']);
  $cmd->execute();
  $result = $cmd->get_result();
  $sidebar = $result->fetch_assoc();

  $name;
  if ($sidebar['MiddleName'] == NULL) {
    $name = $sidebar['FirstName'] . " " . $sidebar['LastName'];
  }
  else {
    $name = ucfirst($sidebar['FirstName']) . " " . strtoupper($sidebar['MiddleName'][0]) . ". " . ucfirst($sidebar['LastName']);
  }

  $cmd->close();

