<?php
session_start(); // Start the session at the beginning of the script

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit;
}

// Handle the AJAX form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'login.php'; // Make sure to use the correct file that contains your database connection

    $description = $_POST['description'];
    $category = $_POST['category'];
    $dateOfExpense = $_POST['dateOfExpense'];
    $amount = $_POST['amount'];
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID from the session

    try {
        $conn = new PDO("mysql:host=$host;dbname=$data;charset=$chrs", $user, $pass, $opts);
        $stmt = $conn->prepare("INSERT INTO Expense (UserID, Description, Category, DateOfExpense, Amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $description, $category, $dateOfExpense, $amount]);
        echo json_encode(["success" => true, "message" => "Expense added successfully!"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    $conn = null;
    exit; // Terminate script execution if it's an AJAX request
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            overflow: auto;
            color: white;
        }

        .navbar a {
            float: left;
            padding: 12px;
            color: white;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .active {
            background-color: #666;
        }

        @media screen and (max-width: 500px) {
            .navbar a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        .navbar a.logout {
            float: right;
        }

        .container {
            padding: 15px;
        }

        h2, h3 {
            color: #333;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

        .button {
            background-color: #666;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #777;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '', // Submit to the current page URL
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message); // Show success message
                            $('form').trigger('reset'); // Reset the form
                        } else {
                            alert('Error: ' + response.error); // Show error message
                        }
                    },
                    error: function() {
                        alert('Error: Could not send request.');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="navbar">
        <a class="active" href="ExpenseTracker.php">Home</a>
        <a href="view_expenses.php">View Expenses</a>
        <a href="Add_New_Expense.php">Add New Expense</a>
        <a href="Modify_Expense.php">Modify Expense</a>
        <a href="Remove_Expense.php">Remove Expense</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <div class="container">
        <h2>Welcome to the CPS-3351 Expense Tracker</h2>
        <h3>Add New Expense</h3>
        <form action="" method="post">
            Description: <input type="text" name="description"><br>
            Category: <input type="text" name="category"><br>
            Date of Expense: <input type="date" name="dateOfExpense"><br>
            Amount: <input type="text" name="amount"><br>
            <input type="submit" value="Add Expense">
        </form>
    </div>
    <footer class="footer">
    <p><b>© 2023  Expense Tracker</b><br>12.18.2023</p>
        <button class="button" onclick="displayDateTime()">Display Date and Time</button>
        <div id="datetime"></div>
    </footer>
</body>
</html>




