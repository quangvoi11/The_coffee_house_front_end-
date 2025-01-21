<main>
<div class="container">
    <h1>Welcome to The Coffee House</h1>

    <div class="auth-links">
        <a href="register.php">Register</a> | 
        <a href="login.php">Login</a>
    </div>

    <div class="search-bar">
        <form action="search.php" method="get">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="products">
        <?php
        include('includes/db.php');
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src='images/" . $row['ImageURL'] . "' alt='" . $row['Name'] . "'>";
            echo "<h2>" . $row['Name'] . "</h2>";
            echo "<p>" . $row['Description'] . "</p>";
            echo "<p class='price'>$" . $row['Price'] . "</p>";

            if (isset($_SESSION['username'])) {
                echo "<button onclick='addToCart(" . $row['id'] . ")'>Add to Cart</button>";
            } else {
                echo "<p class='login-message'>Login required to add to cart</p>";
            }
            
            echo "</div>";
        }
        ?>
    </div>
</div>
</main>