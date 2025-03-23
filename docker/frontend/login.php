<?php
// Start session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adelaide_fringe";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before querying the database
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if ($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($id, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            
                            // Redirect user to welcome page
                            header("location: dashboard.php");
                        } else {
                            // Password is not valid
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // Email doesn't exist
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}

// Include HTML from login.html file
$html = file_get_contents('login.html');

// Replace form with error messages if any
if (!empty($email_err) || !empty($password_err) || !empty($login_err)) {
    $error_html = '<div class="error-message">';
    if (!empty($login_err)) {
        $error_html .= '<p>' . $login_err . '</p>';
    }
    if (!empty($email_err)) {
        $error_html .= '<p>' . $email_err . '</p>';
    }
    if (!empty($password_err)) {
        $error_html .= '<p>' . $password_err . '</p>';
    }
    $error_html .= '</div>';
    
    // Insert error messages before the form
    $html = str_replace('<form id="login-form" class="login-form">', $error_html . '<form id="login-form" class="login-form" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">', $html);
} else {
    // Just add method and action to the form
    $html = str_replace('<form id="login-form" class="login-form">', '<form id="login-form" class="login-form" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">', $html);
}

// Output the HTML
echo $html;
?>