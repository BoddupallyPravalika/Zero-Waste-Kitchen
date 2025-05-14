<?php
session_start();

// Redirect to login if user is not logged in or is not a donor
if (!isset($_SESSION["user"]) || $_SESSION["user_type"] !== 'donor') {
    header("Location: login.php");
    exit();
}

// Process form submission
if (isset($_POST['submit'])) {
    $donor_name = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];
    $food_name = $_POST['food_name'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $address = $_POST['address'];

    require_once "database.php"; // Adjust this based on your actual database connection file

    $sql = "INSERT INTO food_donations (donor_name, donor_email, food_name, quantity, description, address)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $donor_name, $donor_email, $food_name, $quantity, $description, $address);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>Food donation recorded successfully.</div>";
        // You can redirect or perform other actions after successful insertion if needed
    } else {
        die("Error: Unable to prepare SQL statement.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Donor Dashboard</h1>
        <h2>Submit Food Donation Details</h2>
        <form action="donor_dashboard.php" method="post">
            <div class="form-group">
                <label for="donor_name">Name:</label>
                <input type="text" class="form-control" id="donor_name" name="donor_name" value="<?php echo $_SESSION['user']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="donor_email">Email:</label>
                <input type="email" class="form-control" id="donor_email" name="donor_email" value="<?php echo $_SESSION['email']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="food_name">Food Name:</label>
                <input type="text" class="form-control" id="food_name" name="food_name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="address">Address/Location:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                <a href="logout.php" class="btn btn-warning" style="margin-left: 10px;">Logout</a>
            </div>
        </form>
    </div>
</body>
</html>
