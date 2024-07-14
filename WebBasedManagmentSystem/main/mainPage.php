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


    // session_start();
    // require '../login&signup/dbconnection.php';
    // // Retrieve the latest productID from the sales table
    // $result = $mysqli->query("SELECT MAX(productID) AS maxID FROM sales");
    // $row = $result->fetch_assoc();
    // $latestProductID = $row[' $_SESSION['latestProductID']maxID'] + 1; // Increment to get the next productID

    // // Close the database connection
    // $mysqli->close();

    // // Pass $latestProductID to your HTML form (e.g., using session or URL parameters)
    // = $latestProductID;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/CSS" rel="stylesheet" href="mainPage.css">
    <!-- <link rel="stylesheet" type="text/css" href="file:///C:/bootstrap/bootstrap-5.3.2-dist/css/bootstrap.min.css"> -->
   
    <title>Document</title>
</head>
<body>
    <div class="main">

        <div class="search-bar">
            <input class="search" type="text" placeholder="Search by name, username and date">
        </div>

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
                
            
                <form action="salesFrom.php" method="post">

                    <div class="sales-form  wrapper active" id="salesForm">
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
                    </div>
             

                </form>
                    <div class="sales-form wrapper" id="salesForm" >
                       <table>
                        <tr>
                            <th>name</th>
                            <th>Product</th>
                        </tr>
                        <tr>
                            <td>shoes</td>
                            <td>books</td>
                        </tr>
                       </table>
                      </div>

                      <div class="sales-form "  >
                        <canvas id="salesChart"></canvas>
                    </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="mainPage.js"></script> 
<script type="text/javascript" src="file:///C:/bootstrap/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>