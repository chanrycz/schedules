<?php
require "../cookies.php";

// Initialize the session
if (!isset($_SESSION)) {
    setupSession();
}

require "../sql.php";

// Check if the user is already logged in, if not then redirect him to home page
if (isset($_SESSION["schedulelogin"]) && $_SESSION["schedulelogin"] === true) {
    // Redirect user to main page
    header("Location: .");
    exit;
} else {
    require_once "vendor/autoload.php";

    // create Client Request to access Google API
    $client = new Google\Client();
    // $client->setClientId("547767123411-od4fr658vr6s98mgca2albomepe8ejr7.apps.googleusercontent.com");
    // $client->setClientSecret("kPq4u4ox8aQ8cEH3oUs5ol3w");
    $client->setClientId(""); // Put your OAuth Client ID here
    $client->setClientSecret(""); // Put your OAuth Client Secret here
    $client->setRedirectUri((isset($_SERVER["HTTPS"]) && !empty($_SERVER["HTTPS"]) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/schedule/login");
    $client->addScope("email");
    $client->addScope("profile");
    $client->setIncludeGrantedScopes(true);
    $client->setHostedDomain("stu.tes.tp.edu.tw");

    // Processing form data when form is submitted
    if (isset($_GET["code"])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
        $client->setAccessToken($token["access_token"]);

        // get profile info
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
        $profile = $google_account_info->picture;
        $lastlogin = date("Y-m-d H:i:s");
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $name;
        $_SESSION["profile"] = $profile;
        $_SESSION["last_login"] = $lastlogin;
        $_SESSION["gauth_account"] = $google_account_info;


        if ($query = mysqli_query($con, "SELECT * FROM `users` WHERE email='$email'")) {
            if (mysqli_num_rows($query) > 0) {
                if ($query = mysqli_query($con, "UPDATE `users` SET `name`='$name', `profile`='$profile', `last_login`='$lastlogin' WHERE email='$email'")) {
                    $_SESSION["schedulelogin"] = true;

                    // Redirect to main page
                    header("Location: .");
                } else {
                    $err_msg = "Something went wrong with the database. Please try again later.";
                }
                exit;
            } else {
                // Check if email domain ends with tes.tp.edu.tw
                if (substr($email, -13) == "tes.tp.edu.tw") {
                    if (mysqli_query($con, "INSERT INTO `users` (`email`, `name`, `profile`, `last_login`) VALUES ('$email', '$name', '$profile', '$lastlogin')")) {
                        $_SESSION["schedulelogin"] = true;

                        // Redirect to main page
                        header("Location: .");
                        exit;
                    } else {
                        $err_msg = "Something went wrong with the database. Please try again later.";
                    }
                } else {
                    $err_msg = "Please sign in with your TES email account.";
                }
            }
        } else {
            $err_msg = "Something went wrong with the database. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html class="h-100">

<head>
    <script src="https://chanrycz.com/site-theme/js/darkmode.js"></script>
    <title>Login | Schedules</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A modern and beautiful school schedule">
    <meta name="author" content="Ryan Chan">
    <link rel="shortcut icon" href="assets/icon_128.png">

    <!-- FontAwesome CSS -->
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@18657a9/css/all.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="https://chanrycz.com/site-theme/css/theme.css">
</head>

<body class="d-flex flex-column h-100">
    <header class="header fixed-top">
        <div class="d-flex justify-content-between flex-row flex-wrap branding site-branding px-3 py-2 py-sm-0 g-2">
            <div class="invisible nav-spacer"></div>
            <div class="d-flex align-items-center site-logo">
                <a class="me-0 navbar-brand" href="">
                    <div class="brand-logo" style="border-left-color: #007BFF;">
                        <h1 class="brand-name">CHANRYCZ</h1>
                        <p class="service-name">Schedules</p>
                    </div>
                </a>
            </div>
            <div class="invisible nav-break"></div>
            <div class="site-top-utilities d-flex justify-content-end align-items-center">
                <ul class="social-list list-inline mx-3 mb-0 d-flex">
                    <li class="list-inline-item"><a href="javascript:void(0)" id="dark-toggle" class="text-decoration-none">
                            <i class="fas fa-sun fa-fw d-dark"></i>
                            <i class="fas fa-moon-stars fa-fw d-light"></i>
                        </a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="d-flex flex-grow-1 page-content">
        <div class="container my-5">
            <h2 class="mb-3 fw-bold">Login to continue</h2>
            <?php
            if (isset($_SESSION["logout"])) {
                echo '<div class="pb-3 mt-0 d-block valid-feedback">You have been logged out successfully.</div>';
                unset($_SESSION["logout"]);
            }
            ?>
            <?php echo (!empty($err_msg)) ? '<div class="pb-3 mt-0 d-block invalid-feedback">' . $err_msg . '</div>' : ''; ?>
            <?php
            if (!isset($_SESSION["schedulelogin"])) {
            ?>
                <div class="text-center">
                    <p>At the moment this site is only accessible to students and teachers of the Taipei European School.</p>
                    <a class="btn btn-lg btn-dark mb-3" href="<?php echo $client->createAuthUrl(); ?>" role="button">
                        <span style="height:24px;margin-right:8px;width:24px;display:inline-block;">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="margin-top:-3px">
                                <g>
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                    <path fill="none" d="M0 0h48v48H0z"></path>
                                </g>
                            </svg>
                        </span>
                        Sign in with Google</a>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer class="footer py-3 px-3 px-sm-5">
        <ul class="footer-menu text-secondary">
            <li><span class="copyright-symbol">&copy;</span> <?php echo date("Y"); ?> Ryan Chan</li>
            <li><a href="https://chanrycz.com/tos/" class="link-secondary">Terms</a></li>
            <li><a href="https://chanrycz.com/privacy/" class="link-secondary">Privacy</a></li>
        </ul>
    </footer>

    <!-- Javascript -->
    <script src="https://chanrycz.com/site-theme/plugins/popper.min.js"></script>
    <script src="https://chanrycz.com/site-theme/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Page Specific JS -->
    <script>
        document.querySelector("#dark-toggle").onclick = function(e) {
            darkmode.toggleDarkMode();
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>
<?php exit; ?>