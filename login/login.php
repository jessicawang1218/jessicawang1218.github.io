<?php 
    require '../config/config.php';

    // Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// Check for any Connection Errors.
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

    //handle login
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $username = $mysqli->real_escape_string($_POST['username']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);

        $query = "SELECT * FROM users WHERE username = '$username' AND email = '$email' AND password = '$password'";
        $result = $mysqli->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['user_id'];

                header('Location: ../main.php');
                exit();
            }
        }
        else {
            $error = "Invalid username, email, or password";
        }
    }

    // Handle registration
    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $username = $mysqli->real_escape_string($_POST['username']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);

        // Check if user already exists
        $check_user = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $result_check = $mysqli->query($check_user);

        if ($result_check && $result_check->num_rows > 0) {
            $error = "Username or Email already exists";
        } else {
            $insert_sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if ($mysqli->query($insert_sql)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $mysqli->insert_id;

                header('Location: ../main.php');
                exit();
            } else {
                $error = "Error in registering: " . $mysqli->error;
            }
        }
    }
    $mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://use.typekit.net/ufg7hqz.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <!-- navigation bar -->
    <div id="navbar">
        <div id="nav">
            <ul>
                <li><a href="../main.php#home">Jessica Wang</a></li>
                <li class="right-items">
                    <ul>
                        <li><a href="../main.php#aboutme-section">about</a></li>
				        <li><a href="../main.php#project-section">projects</a></li>
                        <li><a href="../main.php#blog-section">blog</a></li>
                        <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) : ?>
                            <li><a href="login/login.php">login</a></li>
                        <?php else : ?>
                            <li><a href="login/logout.php">logout</a></li>
                        <?php endif ; ?>
                    </ul>
                </li>
			</ul>
        </div> <!-- #nav -->
    </div> <!-- #navbar -->

    <div class="form-container">
        <div class="row">
            <h1 class="col-12 mt-4 mb-4">Login</h1>
        </div> <!-- .row -->
        <div class="container">
            <form action="" method="POST">
                <input type="hidden" name="action" value="login">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <?php 
                            if (isset($error) && trim($error) != '') {
                                echo $error;
                            } 
                        ?>
                    </div>
                </div> <!-- .row -->
                
                <div class="form-group row">
                    <label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username-id" name="username">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="email-id" class="col-sm-3 col-form-label text-sm-right">Email:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email-id" name="email">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password-id" name="password">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 mt-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
                    </div>
                </div> <!-- .form-group -->
            </form>
        </div> <!-- .container -->

        <hr>

        <div class="row">
                <h1 class="col-12 mt-4">Sign Up</h1>
            </div>

            <!-- Sign Up Form -->
            <form action="" method="POST">
                <input type="hidden" name="action" value="register">
                <div class="form-group row">
                    <label for="signup-username" class="col-sm-3 col-form-label text-sm-right">Username:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="signup-username" name="username">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="signup-email" class="col-sm-3 col-form-label text-sm-right">Email:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="signup-email" name="email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="signup-password" class="col-sm-3 col-form-label text-sm-right">Password:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="signup-password" name="password">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>



</body>
</html>