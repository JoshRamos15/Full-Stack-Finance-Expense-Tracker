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

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background-color: #ddd;
            margin: 5px 0;
            padding: 5px;
            border-radius: 5px;
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
        <p>Welcome to our comprehensive Expense Tracker application. This user-friendly platform is designed to help you manage your expenses efficiently and effectively.</p>

        <h3>Features:</h3>
        <ul>
            <li><strong>Login:</strong> Secure user authentication to keep your data protected.</li>
            <li><strong>Add Expenses:</strong> Easily add new expenses with details like description, category, and amount.</li>
            <li><strong>View Expenses:</strong> Review all your recorded expenses in a user-friendly format.</li>
            <li><strong>Modify Expenses:</strong> Update details of your existing expenses as needed.</li>
            <li><strong>Delete Expenses:</strong> Remove any expenses that are no longer relevant.</li>
        </ul>

        <p>Our goal is to provide you with a seamless experience in managing your personal or business finances. Start by logging in and exploring the features!</p>
    </div>

    <footer class="footer">
        <p><b>© 2023  Expense Tracker</b><br>12.18.2023</p>
        <button class="button" onclick="displayDateTime()">Display Date and Time</button>
        <p id="datetime"></p>
    </footer>
</body>
</html>
