<?php require 'loginsys.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="description" content="A simple progressive web application helping you to keep track of your school schedule" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $_SESSION['name']; ?> | Schedules</title>
    <link rel="stylesheet" href="https://chanrycz.com/fonts/fonts.css" />
    <link rel="stylesheet" href="assets/css/index.css" />
    <link rel="stylesheet" href="assets/css/timetable.css" />
    <link rel="stylesheet" href="assets/css/general.css" />
    <link rel="stylesheet" href="assets/css/schedule-icons/css/schedules-icons.css" />
    <link rel="stylesheet" href="assets/css/iziToast.css" />
    <meta name="theme-color" content="#FFFFFF" />
    <link rel="manifest" href="manifest.json">
    <link rel="shortcut icon" href="assets/icon_128.png">
</head>

<body>
    <script src="assets/js/general.js"></script>

    <div id="collapsing_header">
        <h1 data-translator-key="schedule">Schedule</h1>
        <button class="icon-settings" onclick="transition_to_page('settings')" aria-label="Settings"></button>
        <button class="icon-table" onclick="transition_to_page('week')" aria-label="Table View"></button>
    </div>

    <header></header>

    <div id="timetable">
        <div id="periods_container"></div>

        <div id="subjects_container"></div>
    </div>

    <div class="overlay" onclick="popup.close();"></div>

    <div id="schedule_edit_popup" class="popup">
        <h2 data-translator-key="edit_schedule">Edit Schedule</h2>

        <span id="day_label">0</span>
        <span class="period_number_label">0</span>

        <div id="schedule_edit_inputs_container" class="inputs_container">
            <label for="color_input" data-translator-key="color:">Color:</label>
            <div class="color-input_container">
                <input name="color_input" type="range" min="0" max="360" value="0" />
                <button onclick="random_color_input();" class="icon-random"></button>
            </div>
            <div class="color_preview"></div>

            <label for="subject_input" data-translator-key="subject:">Subject:</label>
            <textarea name="subject_input"></textarea>

            <label for="room_input" data-translator-key="room:">Room:</label>
            <textarea name="room_input"></textarea>

            <label for="message_input" data-translator-key="message:">Message:</label>
            <textarea name="message_input"></textarea>
        </div>

        <button class="positive" onclick="editor.save_schedule_changes();popup.close();" data-translator-key="save">Save</button>
        <button onclick="popup.close();" data-translator-key="cancel">Cancel</button>
    </div>

    <div id="periods_edit_popup" class="popup">
        <h2 data-translator-key="edit_periods">Edit Periods</h2>

        <div id="periods_edit_inputs_container"></div>

        <button class="add_button" onclick="editor.add_period();" data-translator-key="add">Add</button><br />

        <button class="positive" onclick="editor.save_period_changes();popup.close();" data-translator-key="save">Save</button>
        <button onclick="popup.close();" data-translator-key="cancel">Cancel</button>
    </div>

    <script src="assets/js/iziToast.js"></script>
    <script src="assets/js/configuration.js"></script>
    <script src="assets/js/translator.js"></script>
    <script src="assets/js/page_transitions.js"></script>
    <script src="assets/js/timetable.js"></script>
    <script src="assets/js/index.js"></script>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("serviceworker.js");
            });
        }
    </script>
</body>

</html>