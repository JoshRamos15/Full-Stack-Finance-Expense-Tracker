<?php
session_start(); // Start the session at the beginning of the script

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit;
}

// Handle the AJAX form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'login.php'; // Include your database connection file

    $expenseID = $_POST['expenseID'];
    $newDescription = $_POST['newDescription'];
    $newCategory = $_POST['newCategory'];
    $newDateOfExpense = $_POST['newDateOfExpense'];
    $newAmount = $_POST['newAmount'];
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID from the session

    try {
        $conn = new PDO("mysql:host=$host;dbname=$data;charset=$chrs", $user, $pass, $opts);
        $stmt = $conn->prepare("UPDATE Expense SET Description = ?, Category = ?, DateOfExpense = ?, Amount = ? WHERE ExpenseID = ? AND UserID = ?");
        $stmt->execute([$newDescription, $newCategory, $newDateOfExpense, $newAmount, $expenseID, $userId]);

        if ($stmt->rowCount()) {
            echo json_encode(["success" => true, "message" => "Expense updated successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "No expense found with the specified ID or no changes were made."]);
        }
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
    <title>Expense Tracker - Modify Expense</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'Modify_Expense.php', // Submit to this PHP script
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message); // Show success message
                        } else {
                            alert('Error: ' + response.message); // Show error message
                        }
                    },
                    error: function() {
                        alert('Error: Could not send request.');
                    }
                });
            });
        });

        function displayDateTime() {
            var currentDateTime = new Date();
            var date = currentDateTime.toDateString();
            var time = currentDateTime.toLocaleTimeString();
            document.getElementById("datetime").innerHTML = "Current Date and Time: " + date + " " + time;
        }
    </script>
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
    padding-bottom: 50px; /* Adjust this value based on the height of your footer */
    margin-bottom: 60px; /* Add a bottom margin that is equal or greater than the height of the footer */
}

        h2, h3 {
            color: #333;
        }

        form {
            margin-top: 20px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }

        input[type="text"], 
        input[type="number"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1a1a1a;
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
        <h3>Modify Expense</h3>
        <form action="Modify_Expense.php" method="post">
            Expense ID: <input type="number" name="expenseID" required><br>
            New Description: <input type="text" name="newDescription"><br>
            New Category: <input type="text" name="newCategory"><br>
            New Date of Expense: <input type="date" name="newDateOfExpense"><br>
            New Amount: <input type="text" name="newAmount"><br>
            <input type="submit" value="Update Expense">
        </form>
    </div>

    <footer class="footer">
        <p><b>© 2023 Expense Tracker</b><br>12.18.2023</p>
        <button class="button" onclick="displayDateTime()">Display Date and Time</button>
        <div id="datetime"></div>
    </footer>
</body>
</html>


