<?php
$servername = "localhost";
$username = "root"; // your DB username
$password = "";     // your DB password
$dbname = "billing_system2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$consumer = $_POST['consumerName'];
$units = $_POST['units'];
$tariff = $_POST['tariff'];

// Calculate charges
$rate = ($tariff == "residential") ? 10 : (($tariff == "commercial") ? 15 : 20);
$fixedCharge = ($tariff == "residential") ? 50 : (($tariff == "commercial") ? 100 : 200);
$baseAmount = $units * $rate;
$tax = $baseAmount * 0.12;
$total = $baseAmount + $fixedCharge + $tax;

// Insert into DB
$sql = "INSERT INTO bills (consumer_name, units, category, base_amount, fixed_charge, tax, total)
        VALUES ('$consumer', '$units', '$tariff', '$baseAmount', '$fixedCharge', '$tax', '$total')";

if ($conn->query($sql) === TRUE) {
  echo "Bill saved successfully!";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>