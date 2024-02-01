<?php
session_start();

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit;
}

include 'login.php'; // Replace with your actual database connection file

try {
    $userId = $_SESSION['user_id']; // Retrieve the user ID from the session
    $conn = new PDO("mysql:host=$host;dbname=$data;charset=$chrs", $user, $pass, $opts);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM Expense WHERE UserID = ?");
    $stmt->execute([$userId]);
    $expenses = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <script>
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
        }

        h2, h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #666;
            color: white;
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

        <?php if (!empty($expenses)): ?>
            <table>
                <tr>
                    <th>Expense ID</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Date Of Expense</th>
                    <th>Amount</th>
                </tr>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($expense['ExpenseID']); ?></td>
                        <td><?php echo htmlspecialchars($expense['Description']); ?></td>
                        <td><?php echo htmlspecialchars($expense['Category']); ?></td>
                        <td><?php echo htmlspecialchars($expense['DateOfExpense']); ?></td>
                        <td><?php echo htmlspecialchars($expense['Amount']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No expenses found.</p>
        <?php endif; ?>
    </div>

    <footer class="footer">
    <p><b>© 2023  Expense Tracker</b><br>12.18.2023</p>
        <button class="button" onclick="displayDateTime()">Display Date and Time</button>
        <p id="datetime"></p>
    </footer>
</body>
</html>
