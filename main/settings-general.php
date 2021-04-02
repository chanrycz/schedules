<?php require 'loginsys.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>General Settings | <?php echo $_SESSION['name']; ?> | Schedules</title>
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
        <div class="settings_group closed">
            <div class="settings_group_header">
                <h2 data-translator-key="general">General</h2>
            </div>

            <div class="input_group">
                <label data-translator-key="language:" for="language_input">Language:</label>

                <select id="language_input" name="language_input">
                    <option value="en">English</option>
                    <option value="zh-Hant">繁體中文</option>
                    <option value="zh-Hans">简体中文</option>
                </select>
            </div>

            <div class="input_group">
                <label data-translator-key="dark_mode:" for="dark_mode_input">Dark mode:</label>
                <input id="dark_mode_input" name="dark_mode_input" type="checkbox" />
            </div>

            <div class="input_group">
                <label data-translator-key="disable_hints:" for="disable_hints_input">Disable hints:</label>
                <input id="disable_hints_input" name="disable_hints_input" type="checkbox" />
            </div>

            <!--<div class="input_group">-->
            <!--    <label data-translator-key="default_week_view:" for="default_week_view">Week View as default view:</label>-->
            <!--    <input id="default_week_view" name="default_week_view" type="checkbox" />-->
            <!--</div>-->

            <div class="input_group">
                <label data-translator-key="new_day_time_threshold:" for="new_day_time_input">New day time threshold:</label>
                <input id="new_day_time_enable_input" name="new_day_time_enable_input" type="checkbox" />
                <input id="new_day_time_input" name="new_day_time_input" type="time" required />
            </div>

            <div class="input_group">
                <a><button id="backup_button" class="icon-download" data-translator-key="backup">Backup</button></a>

                <label for="restore_file_input" class="icon-upload" data-translator-key="restore">Restore</label>
                <input id="restore_file_input" name="restore_file_input" type="file" />
            </div>

            <div class="input_group">
                <button class="negative icon-reset" onclick="reset();" data-translator-key="reset">Reset</button>
            </div>
        </div>
    </div>

    <script src="assets/js/iziToast.js"></script>
    <script src="assets/js/configuration.js"></script>
    <script src="assets/js/translator.js"></script>
    <script src="assets/js/page_transitions.js"></script>
    <script src="assets/js/general_settings.js"></script>
</body>

</html>