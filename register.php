<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adelaide_fringe";

// Initialize variables for form data and error messages
$fullname = $email = $password = $confirm_password = "";
$fullname_err = $email_err = $password_err = $confirm_password_err = $terms_err = "";
$registration_success = false;

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if users table exists, create if it doesn't
$check_table = $conn->query("SHOW TABLES LIKE 'users'");
if ($check_table->num_rows == 0) {
    $create_table_sql = "CREATE TABLE `users` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `fullname` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )";
    $conn->query($create_table_sql);
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate full name
    if (empty(trim($_POST["fullname"]))) {
        $fullname_err = "Please enter your full name.";
    } else {
        $fullname = trim($_POST["fullname"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', trim($_POST["password"]))) {
        $password_err = "Password must include letters, numbers, and special characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Passwords did not match.";
        }
    }

    // Validate terms checkbox
    if (!isset($_POST["terms"])) {
        $terms_err = "You must agree to the terms and conditions.";
    }

    // Check input errors before inserting in database
    if (empty($fullname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($terms_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_fullname, $param_email, $param_password);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Registration successful
                $registration_success = true;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Adelaide Fringe 2025</title>
    <link rel="stylesheet" href="/adelaide fringe/login.css">
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
                
                <?php if ($registration_success): ?>
                    <div class="success-message">
                        <p>Registration successful! You can now <a href="login.php">login to your account</a>.</p>
                    </div>
                <?php else: ?>
                    <form id="register-form" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required
                                   value="<?php echo htmlspecialchars($fullname); ?>">
                            <span class="error"><?php echo $fullname_err; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required
                                   value="<?php echo htmlspecialchars($email); ?>">
                            <span class="error"><?php echo $email_err; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Create a password" required>
                            <small class="password-hint">Password must be at least 8 characters long and include letters, numbers, and special characters.</small>
                            <span class="error"><?php echo $password_err; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                            <span class="error"><?php echo $confirm_password_err; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="terms-checkbox">
                                <input type="checkbox" id="terms" name="terms">
                                <label for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></label>
                                <span class="error"><?php echo $terms_err; ?></span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                <?php endif; ?>
                
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