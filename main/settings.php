<?php require 'loginsys.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Settings | <?php echo $_SESSION['name']; ?> | Schedules</title>
    <link rel="stylesheet" href="https://chanrycz.com/fonts/fonts.css" />
    <link rel="stylesheet" href="assets/css/general.css" />
    <link rel="stylesheet" href="assets/css/settings.css" />
    <link rel="stylesheet" href="assets/css/schedule-icons/css/schedules-icons.css" />
    <link rel="stylesheet" href="assets/css/iziToast.css" />
    <meta name="theme-color" content="#FFFFFF" />
    <link rel="shortcut icon" href="assets/icon_128.png">
</head>

<body>
    <script src="assets/js/general.js"></script>

    <header>
        <div>
            <button class="back_button icon-back" onclick="transition_back();"></button>
            <h1 data-translator-key="settings">Settings</h1>
        </div>

        <h2 class="profile-name"><img src="<?php echo $_SESSION["profile"]; ?>" alt="Profile photo"><?php echo $_SESSION["name"]; ?></h1>
    </header>

    <div id="settings_container">
        <div class="settings_group">
            <a onclick="transition_to_page('settings-general')" data-translator-key="general" class="icon-settings">General</a>

            <a onclick="transition_to_page('settings-color')" data-translator-key="manage_colors" class="icon-colors">Manage Colors</a>

            <a onclick="transition_to_page('week?print')" data-translator-key="print" class="icon-print">Print</a>

            <a onclick="transition_to_page('logout')" data-translator-key="logout" class="icon-logout">Logout</a>
        </div>
    </div>

    <script src="assets/js/iziToast.js"></script>
    <script src="assets/js/configuration.js"></script>
    <script src="assets/js/translator.js"></script>
    <script src="assets/js/page_transitions.js"></script>
</body>

</html>