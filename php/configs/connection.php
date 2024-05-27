<?php

  $conn = new mysqli("localhost", "root", "QZr8408o", "spendsense_db");

  if ($conn->connect_error) {
    die ("Erorr: " . $conn->connect_error);
  }