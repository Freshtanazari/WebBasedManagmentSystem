<?php
 require '..\login&signup\dbconnection.php';

 // Set the content type to JSON
header('Content-Type: application/json');

 // Query to get the month and total revenue
 $sql = "SELECT DATE_FORMAT(SaleDate, '%M') AS month, SUM(price) AS total_revenue
         FROM sales
         GROUP BY month
         ORDER BY saleDate";
 
 $result = $conn->query($sql);
 
 // Initialize the array with headers
 $data = [
     ['Month', 'Total Revenue']
 ];
 
 // Fetch data and push it to the array
 if ($result->num_rows > 0) {
     while ($row = $result->fetch_assoc()) {
         $data[] = [$row['month'], (float) $row['total_revenue']];
     }
 } else {
     echo "No data found";
 }
 $jsonData = json_encode($data);
 
 echo $jsonData;
 // Close the database connection
 $conn->close();
 ?>