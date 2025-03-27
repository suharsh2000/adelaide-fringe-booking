<?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $fullname = $_POST['fullname'];
                        $email = $_POST['email'];
                        $password= $_POST['password'];
                        $confirm_password = $_POST['confirm_password'];
                        echo '<div class="alert alert-success" role="alert">
                        This is a success alert—check it out!
                        </div>';
                    }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            $fullname = $_POST['fullname'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $confirm_password = $_POST['confirm_password'];
                            
                            $servername = "localhost";
                            $username = 'root';
                            $password = '';
                        
                            $conn = mysqli_connect($servername, $username, $password);
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                        
                            // Create database if not exists
                            $sql = "CREATE DATABASE IF NOT EXISTS `adelaide_fringe`";
                            if (mysqli_query($conn, $sql)) {
                                echo "Database created successfully";
                            } else {
                                echo "Error creating database: " . mysqli_error($conn);
                            }
                        
                            // Select the database
                            mysqli_select_db($conn, $dbname);
                        
                            // Create table if not exists
                            $sql = "CREATE TABLE IF NOT EXISTS `register` (
                                `Fullname` VARCHAR(100) NOT NULL,
                                `email` VARCHAR(100) NOT NULL,
                                `password` VARCHAR(100) NOT NULL,
                                `confirm_password` VARCHAR(100) NOT NULL
                            )";
                            if (mysqli_query($conn, $sql)) {
                                echo "Table created successfully";
                            } else {
                                echo "Error creating table: " . mysqli_error($conn);
                            }
                        
                            // Insert data into table
                            $sql = "INSERT INTO `register` (`Fullname`, `email`, `password`, `confirm_password`) VALUES ('$fullname', '$email', '$password', '$confirm_password')";
                            if (mysqli_query($conn, $sql)) {
                                echo "The data was inserted";
                            } else {
                                echo "It was not inserted: " . mysqli_error($conn);
                            }
                        
                            mysqli_close($conn);
                        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Adelaide Fringe 2025</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="Home page.html" >
                        <img src="/Images/logo.svg" alt="Adelaide Fringe" class="logo-img">
                    </a>
                </div>
                <ul class="nav-links">
                    <li><a href="index.html#events">Events</a></li>
                    <li><a href="index.html#about">About</a></li>
                    <li><a href="index.html#venues">Venues</a></li>
                    <li><a href="index.html#contact">Contact</a></li>
                    <li><a href="#" class="btn btn-secondary">Book Tickets</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="login-section">
        <div class="container">
            <div class="login-container">
                <h2>Create Your Account</h2>
                <p>Join Adelaide Fringe to book tickets and personalize your festival experience.</p>
                
                <form id="register-form" class="login-form" action = '/register.php' method="post">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                        <small class="password-hint">Password must be at least 8 characters long and include letters, numbers, and special characters.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>
                    
                    <div class="form-group">
                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                
                <div class="login-footer">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul>
                        <li>Adelaide Fringe</li>
                        <li>136 Frome Street</li>
                        <li>Adelaide SA 5000</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Venues</a></li>
                        <li><a href="#">Artists</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Information</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Accessibility</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Follow Us</h3>
                    <p>Stay connected with us on social media</p>
                    <div class="social-links">
                        <a href="#">FB</a>
                        <a href="#">IG</a>
                        <a href="#">TW</a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Adelaide Fringe Festival. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>