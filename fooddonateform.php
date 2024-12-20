<?php
include("login.php"); 
if($_SESSION['name']==''){
	header("location: signin.php");
}
// include("login.php"); 
$emailid= $_SESSION['email'];
$connection=mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'demo');
if(isset($_POST['submit']))
{
    $foodname=mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal=mysqli_real_escape_string($connection, $_POST['meal']);
    $category=$_POST['image-choice'];
    $quantity=mysqli_real_escape_string($connection, $_POST['quantity']);
    // $email=$_POST['email'];
    $phoneno=mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district=mysqli_real_escape_string($connection, $_POST['district']);
    $address=mysqli_real_escape_string($connection, $_POST['address']);
    $name=mysqli_real_escape_string($connection, $_POST['name']);
  

 



    $query="insert into food_donations(email,food,type,category,phoneno,location,address,name,quantity) values('$emailid','$foodname','$meal','$category','$phoneno','$district','$address','$name','$quantity')";
    $query_run= mysqli_query($connection, $query);
    if($query_run)
    {

        echo '<script type="text/javascript">alert("data saved")</script>';
        header("location:delivery.html");
    }
    else{
        echo '<script type="text/javascript">alert("data not saved")</script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px 30px;
        }

        .form-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #06C167;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input[type="radio"] {
            margin-right: 5px;
        }

        .form-group .image-radio-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .image-radio-group label img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .image-radio-group input[type="radio"]:checked + label img {
            border-color: #06C167;
        }

        .form-group .contact-details {
            font-weight: bold;
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 10px;
            color: #06C167;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #06C167;
            color: #fff;
            border: none;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-group button:hover {
            background-color: #05a456;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="form-title">Food Donation Form</p>
        <form action="" method="post">
            <!-- Food Name -->
            <div class="form-group">
                <label for="foodname">Food Name:</label>
                <input type="text" id="foodname" name="foodname" required />
            </div>

            <!-- Meal Type -->
            <div class="form-group">
                <label>Meal Type:</label>
                <input type="radio" name="meal" id="veg" value="veg" required />
                <label for="veg">Veg</label>
                <input type="radio" name="meal" id="non-veg" value="non-veg" />
                <label for="non-veg">Non-Veg</label>
            </div>

            <!-- Food Category -->
            <div class="form-group">
                <label>Select the Category:</label>
                <div class="image-radio-group">
                    <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                    <label for="raw-food"><img src="img/raw-food.png" alt="Raw Food"></label>
                    <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                    <label for="cooked-food"><img src="img/cooked-food.png" alt="Cooked Food"></label>
                    <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                    <label for="packed-food"><img src="img/packed-food.png" alt="Packed Food"></label>
                </div>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity (Number of persons/kg):</label>
                <input type="text" id="quantity" name="quantity" required />
            </div>

            <!-- Contact Details Section -->
            <div class="form-group contact-details">Contact Details</div>

            <!-- Name -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required />
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phoneno">Phone Number:</label>
                <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />
            </div>

            <!-- District -->
            <div class="form-group">
                <label for="district">District:</label>
                <select id="district" name="district" required>
                    <option value="chennai">Chennai</option>
                    <option value="kancheepuram">Kancheepuram</option>
                    <option value="madurai" selected>Madurai</option>
                    <!-- Add other districts -->
                </select>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required />
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
