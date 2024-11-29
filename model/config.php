<?php
  $host = "localhost";
  $db = "gym-management-db";
  $user = "root";
  $pass = "";

  try {
      $cnx = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
      $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      exit;
  }
?>