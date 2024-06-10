<?php
$servername = "localhost";
$username = "library";
$password = "y9KD3AShTz.3k(QR";
$dbname = "wt2_konferencny_system";

// Vytvorenie spojenia
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kontrola spojenia
if (!$conn)
  die("Connection failed: " . mysqli_connect_error());

// Nastavenie spravnej kodovej sady pre citanie a zapis do DB
mysqli_query($conn, 'SET CHARACTER SET utf8');
mysqli_query($conn, 'SET NAMES "utf8"');
mb_internal_encoding('UTF-8');
