<?php
 session_start();
require '../login&signup/dbconnection.php';
$sql = 'SELECT MAX(productID) AS max_productID FROM sales;';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ./login.html?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                    $_SESSION['ID'] = $row['max_productID'];
                    $_SESSION['latestProductID'] =  $_SESSION['ID'] + 1;
                }
            }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/CSS" rel="stylesheet" href="mainPage.css">
    <!-- <link rel="stylesheet" type="text/css" href="file:///C:/bootstrap/bootstrap-5.3.2-dist/css/bootstrap.min.css"> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Document</title>
</head>
<body>

        <div class="container">
            <div class="nav-bar">
                <div class="nav-btn fbtn" >
                    <img src="./form-icon.png" style="width: 30px; height: 30px;">
                    Sales Form
                </div>
                
                <div class="nav-btn rbtn" o >
                    <img src="./report-icon.png" style="width: 30px; height: 30px;">
                    Sales List
                </div>
                <div class="nav-btn lbtn"  >
                    <img src="./list-icon.png" style="width: 30px; height: 30px;">
                    Sales Report
                </div>
            </div>

            <div class="input-area">

                <form class="sales-form wrapper active" id="salesForm" action="salesFrom.php" method="post">
                 
                      <label class="label"> Product Name
                      <input class="sales-input pd-nm" type="text" name="productName"></label>
                      <label class="label">Product ID
                      <input class="sales-input pd-id"  type="text" name="productID" value="<?php echo ($_SESSION['latestProductID']); ?>" readonly></label>
                      <label class="label"> Date
                      <input class="sales-input date" id="p-date" type="text" name="date" readonly></label>
                      <label class="label">  Price 
                      <input class="sales-input sold-Price" type="text" name="price"></label>
                      <label class="label"> Seller 
                      <input class="sales-input seller-nm" type="text" name="seller" value="<?php echo ($_SESSION['userName']); ?>" readonly></label>
                      <!-- i will use the global session variable to get the user name and set the value of it to that.  -->
                      <label class="label" >Description
                      <input class="sales-input description" type="text" name="description"></label>
                      <input  class="submit" type="submit" value="submit" name="PD-entry">
                </form>

                <div class="sales-form wrapper" id="salesForm" >

                    <div class="tableContainer">
                       <table class="salesLists">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>price</th>
                            <th>Seller</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql1 = 'SELECT * FROM sales';
                        $result2 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_array($result2)){
                            $id = $row["productID"];
                            $name = $row["productName"];
                            $date = $row["saleDate"];
                            $price = $row["price"];
                            $seller = $row["username"];
                            $description = $row["productDescription"];
                            // header('Content-Type: application/json');
                            echo"
                            <tr>
                            <td>$id</td>
                            <td>$name</td>
                            <td>$date</td>
                            <td>$price</td>
                            <td>$seller</td>
                            <td>$description</td>
                            </tr>
                            ";
                        }
                        ?>
                        </tbody>
                       </table>
                    </div>
                    <div class="salesDetails">
                        <span class="property"> Total sales:</span><?php
                         $sql2 = 'SELECT SUM(price) AS total_sales FROM sales;';
                         $totalSales = mysqli_query($conn, $sql2);

                         // Fetch the row containing the result
                        $row = mysqli_fetch_assoc($totalSales);

                        // Access the 'total_sales' field and echo it
                        echo number_format($row['total_sales'], 2);
                        ?>
                        <br>
                        <hr>
                        <span class="property"> Average sales:</span>
                        <?php
                        $sql3 = 'SELECT AVG(price) AS average_price FROM sales;';
                        $avgSales = mysqli_query($conn, $sql3);

                        // fetch the row containing the resut
                        $row = mysqli_fetch_assoc($avgSales);

                        // access the avgSales field and echo it
                        echo number_format($row['average_price']?? 0 , 2);
                        ?>
                        <hr>
                        <span class="property">Monthly sales:</span>
                        <?php
                        $currentYear = date('Y');
                        $currentMonth = date('m');
                        
                        $MonthQuery = "SELECT 
                            YEAR(`saleDate`) AS year,
                            MONTH(`saleDate`) AS month,
                            SUM(price) AS monthlySales
                        FROM 
                            sales
                        WHERE 
                            YEAR(`saleDate`) = $currentYear 
                            AND MONTH(`saleDate`) = $currentMonth
                        GROUP BY 
                            YEAR(`saleDate`),
                            MONTH(`saleDate`)
                        ORDER BY 
                            YEAR(`saleDate`),
                            MONTH(`saleDate`);";
                        $monthlySalesResult = mysqli_query($conn, $MonthQuery);
                       
                        // fetch the data
                        $row = mysqli_fetch_assoc($monthlySalesResult);

                        // access it
                        echo number_format($row['monthlySales']?? 0, 2);
                    
                        // echo  $monthlySalesResult;
                        ?>
                        <hr>

                        <span class="property">Weekly sales:</span>
                         <?php
                            $currentYear = date('Y');
                            $currentMonth = date('m');

                            // Calculate the date for the last 7 days
                            $startDate = date('Y-m-d', strtotime('-7 days'));

                            // Query to get the total sales for the last 7 days
                            $WeekQuery = "
                                SELECT 
                                    SUM(price) AS weeklySales
                                FROM 
                                    sales
                                WHERE 
                                    `saleDate` >= '$startDate' ";

                            // Execute the query
                            $weeklySalesResult = mysqli_query($conn, $WeekQuery);

                            // Fetch the data
                            $row = mysqli_fetch_assoc($weeklySalesResult);

                            // Access and display the result
                            echo number_format($row['weeklySales'] ?? 0, 2);
                         ?>   
                        <br>
                        <hr>
                        <span class="property">Most sold item:</span>
                        <?php

                            // Query to get the most sold item in the last 7 days
                            $MostSoldItemQuery = "
                            SELECT 
                                productName, 
                                COUNT(*) AS totalSold
                            FROM 
                                sales
                            GROUP BY 
                                productName
                            ORDER BY 
                                totalSold DESC
                            LIMIT 1
                        ";

                            // Execute the query
                            $mostSoldItemResult = mysqli_query($conn, $MostSoldItemQuery);

                            // Fetch the data
                            $row = mysqli_fetch_assoc($mostSoldItemResult);

                            // Access and display the result
                            echo ($row['productName'] ?? 'None') ;

                        ?>

                        <br>
                    </div>
                </div>
                <div class="sales-form wrapper" id="noGrid">
                    <div id="chart_div" style="width: 650px; height: 200px; margin: 40px;"></div>
                </div>

            </div>
        </div>
        
<script type="text/javascript" src="mainPage.js"></script> 
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script type="text/javascript" src="file:///C:/bootstrap/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>