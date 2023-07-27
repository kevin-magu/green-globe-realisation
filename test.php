<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="your_styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Count</title>
</head>
<body>
    <div class="tree-count-container">
        <p id="tree-count-display">0</p>
    </div>

    <script>
        // Use PHP to echo the current tree count directly into JavaScript
        var currentCount = <?php
            // Assuming you have established a database connection
            include 'includes.php';

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $query = "SELECT no_of_trees FROM trees";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Query failed: " . mysqli_error($connection));
            }

            $row = mysqli_fetch_assoc($result);
            echo $row['no_of_trees'];

            // Don't forget to close the database connection
            mysqli_close($connection);
        ?>;
        
        var increment = 1;
        var targetCount = currentCount; // Set the target count

        // Function to update the displayed count incrementally
        function updateTreeCount() {
            if (increment <= targetCount) {
                document.getElementById("tree-count-display").textContent = increment;
                increment++;
                setTimeout(updateTreeCount, 10); // Adjust the timeout to control the speed of increment
            }
        }

        // Call the function to start the incremental count when the page loads
        window.onload = updateTreeCount;
    </script>
</body>
</html>
