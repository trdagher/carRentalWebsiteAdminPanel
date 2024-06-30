<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/global.css" type="text/css" />
    <link rel="stylesheet" href="./login.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <title>Login</title>
</head>

<body>
    <div class="container">
        <form id="form" action="./signInForm.php" method="POST">
            <div class="login-box">
                <i class="fas fa-arrow-left" id="backToHomeArrow"></i>
                <div class="carImg"></div>
                <h2>Admin Login</h2>

                <div class="user-box">
                    <input type="email" name="email" id="email" required />
                    <label>Email</label>
                </div>
                <div class="user-box">
                    <input type="password" name="password" id="password" required />
                    <label>Password</label>
                </div>

                <div class="btnLoginContainer">
                    <button class="btnRipple"><span>Login</span></button>
                </div>
                <div class="error">
                    <p id="errorContainer"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>