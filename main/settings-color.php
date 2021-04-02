<?php require 'loginsys.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Colors Settings | <?php echo $_SESSION['name']; ?> | Schedules</title>
    <link rel="stylesheet" href="https://chanrycz.com/fonts/fonts.css" />
    <link rel="stylesheet" href="assets/css/general.css" />
    <link rel="stylesheet" href="assets/css/settings_pages.css" />
    <link rel="stylesheet" href="assets/css/schedule-icons/css/schedules-icons.css" />
    <link rel="stylesheet" href="assets/css/iziToast.css" />
    <meta name="theme-color" content="#FFFFFF" />
    <link rel="shortcut icon" href="assets/icon_128.png">
</head>

<body>
    <script src="assets/js/general.js"></script>

    <header>
        <button class="back_button icon-back" onclick="transition_back();"></button>
        <h1 data-translator-key="settings">Settings</h1>
        <button id="save_button" class="icon-save" onclick="save();" aria-label="Save"></button>
    </header>

    <div id="settings_container">
        <div id="color_settings_group" class="settings_group">
            <div class="settings_group_header">
                <h2 data-translator-key="manage_colors">Manage colors</h2>
            </div>

            <div id="color_input_groups_container"></div>
        </div>
    </div>

    <script src="assets/js/iziToast.js"></script>
    <script src="assets/js/configuration.js"></script>
    <script src="assets/js/translator.js"></script>
    <script src="assets/js/page_transitions.js"></script>
    <script src="assets/js/sanitize.js"></script>
    <script src="assets/js/color_settings.js"></script>
</body>

</html>