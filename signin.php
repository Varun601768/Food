<?php
session_start();
include 'connection.php';
$msg = 0; // Initialize $msg to avoid undefined variable warning

if (isset($_POST['sign'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['gender'] = $row['gender'];
                header("location:home.html");
            } else {
                $msg = 1; // Set $msg if password doesn't match
            }
        }
    } else {
        echo "<h1><center>Account does not exist</center></h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
          background:url('img/1.webp');
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #fff;
            padding: 30px 25px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: black;
        }

        #heading {
            text-align: center;
            font-size: 20px;
            color: #444;
            margin-bottom: 20px;
        }

        .input,
        .password {
            margin-bottom: 15px;
        }

        .input input,
        .password input {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .input input:focus,
        .password input:focus {
            border-color: #06C167;
        }

        .password {
            position: relative;
        }

        .password i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #888;
            cursor: pointer;
        }

        .btn button {
            width: 100%;
            padding: 12px;
            background-color: #06C167;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn button:hover {
            background-color: #048B50;
        }

        .signin-up {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .signin-up a {
            color: #06C167;
            font-weight: bold;
            text-decoration: none;
        }

        .signin-up a:hover {
            text-decoration: underline;
        }

        .error {
            color: #d93025;
            font-size: 14px;
            margin-top: 6px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="regform">
            <form action="" method="post">
                <p class="logo">Food <b style="color:#06C167;">Donate</b></p>
                <p id="heading">Welcome back!</p>

                <div class="input">
                    <input type="email" placeholder="Email address" name="email" required />
                </div>

                <div class="password">
                    <input type="password" placeholder="Password" name="password" id="password" required />
                    <i class="uil uil-eye-slash showHidePw"></i>
                    <?php
                    if ($msg == 1) {
                        echo '<p class="error">Password does not match.</p>';
                    }
                    ?>
                </div>

                <div class="btn">
                    <button type="submit" name="sign">Sign in</button>
                </div>

                <div class="signin-up">
                    <p>Don't have an account? <a href="signup.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.querySelector('.showHidePw');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.classList.toggle('uil-eye');
            togglePassword.classList.toggle('uil-eye-slash');
        });
    </script>
</body>

</html>
