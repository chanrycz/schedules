var printing_mode = false;
var settings_saved = true;

window.addEventListener("load", function () {
	show_options();

	setup_backup_button();

	var timeSkipEnableButton = document.getElementById("new_day_time_enable_input");
	var timeSkipTimeInput = document.getElementById("new_day_time_input");
	var configTime = config.data.other.timeSkipNextDay.time || "1020";
	var configTimeHours = Math.floor(configTime / 60);
	var configTimeMinutes = configTime % 60;
	timeSkipTimeInput.value = `${configTimeHours.toString().padStart(2, "0")}:${configTimeMinutes.toString().padStart(2, "0")}` || "17:00";
	timeSkipEnableButton.checked = config.data.other.timeSkipNextDay.enabled || false;

	const timeSkipCheckbox = () => {
		timeSkipTimeInput.disabled = timeSkipEnableButton.checked !== true;
		timeSkipTimeInput.style.visibility = timeSkipEnableButton.checked === true ? "visible" : "hidden";
	};
	timeSkipCheckbox();
	timeSkipEnableButton.addEventListener("change", timeSkipCheckbox);

	var input = document.getElementById("restore_file_input");
	input.addEventListener("change", function () {
		restore();
	});

	var inputs = document.querySelectorAll("#language_input, #dark_mode_input, #disable_hints_input");

	for (input of inputs) {
		input.addEventListener("change", function () {
			settings_saved = false;
			document.getElementById("save_button").classList.add("positive");
		});
	}
});

window.addEventListener("beforeunload", function (e) {
	// if settings saved or if variable doesn't exist
	if (settings_saved === false || settings_saved === undefined) {
		setTimeout(function () {
			setTimeout(function () {
				document.body.style.opacity = 1;
			}, 200);
		}, 1);

		var confirmationMessage = "Warning: You have unsaved changes. If you leave before saving, your changes will be lost.";
		(e || window.event).returnValue = confirmationMessage;
		return confirmationMessage;
	}
});

function show_options() {
	var language_input = document.getElementById("language_input");
	var dark_mode_input = document.getElementById("dark_mode_input");
	var disable_hints_input = document.getElementById("disable_hints_input");
	disable_hints_input.checked = localStorage.getItem("schedule_disable-hints") == "true";

	language_input.value = localStorage.getItem("schedule_language");
	dark_mode_input.checked = localStorage.getItem("schedule_dark") == "true";
}

function save() {
	var language_input_value = document.getElementById("language_input").value;
	var dark_mode_input_value = document.getElementById("dark_mode_input").checked;
	var disable_hints_input_value = document.getElementById("disable_hints_input").checked;
	localStorage.setItem("schedule_disable-hints", disable_hints_input_value);
	localStorage.setItem("schedule_language", language_input_value);
	localStorage.setItem("schedule_dark", dark_mode_input_value);

	translator.translate_ui();

	if (dark_mode_input_value === true) {
		document.body.classList.add("dark_mode");
		document.head.querySelector("[name='theme-color']").setAttribute("content", "#222222");
	} else {
		document.body.classList.remove("dark_mode");
		document.head.querySelector("[name='theme-color']").setAttribute("content", "#FFFFFF");
	}

	var timeSkipEnableButton = document.getElementById("new_day_time_enable_input");
	if (timeSkipEnableButton.checked === true) {
		config.data.other.timeSkipNextDay.enabled = true;
		var timeSkipTimeInput = document.getElementById("new_day_time_input");
		if (timeSkipTimeInput !== null && timeSkipTimeInput.disabled !== true) {
			var [hour, minute] = timeSkipTimeInput.value.split(":");
			config.data.other.timeSkipNextDay.time = parseInt(hour) * 60 + parseInt(minute);
			config.save_data(config.data);
		}
	} else {
		config.data.other.timeSkipNextDay.enabled = false;
		config.save_data(config.data);
	}

	settings_saved = true;
	document.getElementById("save_button").classList.remove("positive");
}

function setup_backup_button() {
	var data_string = JSON.stringify(config.data);
	var data_uri = `data:application/json;charset=utf-8,${encodeURIComponent(data_string)}`;

	var file_name = "data_backup.json";

	var link_element = document.getElementById("backup_button").parentElement;
	link_element.setAttribute("href", data_uri);
	link_element.setAttribute("download", file_name);
}

function restore() {
	var input = document.getElementById("restore_file_input");
	var file = input.files[0];

	var reader = new FileReader();

	reader.addEventListener("load", function (e) {
		try {
			var content = e.target.result;
			var content_json = JSON.parse(content);

			config.data = content_json;
			config.save_data(config.data);
			
			var timeSkipEnableButton = document.getElementById("new_day_time_enable_input");
        	var timeSkipTimeInput = document.getElementById("new_day_time_input");
        	var configTime = config.data.other.timeSkipNextDay.time || "1020";
        	var configTimeHours = Math.floor(configTime / 60);
        	var configTimeMinutes = configTime % 60;
        	timeSkipTimeInput.value = `${configTimeHours.toString().padStart(2, "0")}:${configTimeMinutes.toString().padStart(2, "0")}` || "17:00";
        	timeSkipEnableButton.checked = config.data.other.timeSkipNextDay.enabled || "false";
    		timeSkipTimeInput.disabled = timeSkipEnableButton.checked !== true;
    		timeSkipTimeInput.style.visibility = timeSkipEnableButton.checked === true ? "visible" : "hidden";
		} catch (e) {
			iziToast.show({
				title: "Error",
				message: "An error occurred while restoring data",
				theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true") ? "dark" : "light",
				color: "red",
				icon: "icon-error",
				zindex: 1000,
				balloon: false,
				close: true,
				position: "bottomRight",
				timeout: 5000,
				animateInside: true,
				drag: true,
				pauseOnHover: true,
				progressBar: false,
			});
		}
	});

	reader.readAsText(file);
}

function reset() {
	if (confirm(translator.translate("reset_confirm"))) {
		localStorage.removeItem("schedule_language");
		localStorage.removeItem("schedule_dark");
		localStorage.removeItem("schedule_disable-hints");
		
		document.body.classList.remove("dark_mode");
		document.head.querySelector("[name='theme-color']").setAttribute("content", "#FFFFFF");
		
		document.getElementById("new_day_time_enable_input").checked = false;
        document.getElementById("new_day_time_input").value = "17:00";
    	
        document.getElementById("language_input").selectedIndex = 0;
        document.getElementById("dark_mode_input").checked = false;
        document.getElementById("disable_hints_input").checked = false;
        
		config.reset_data();
	}
}
