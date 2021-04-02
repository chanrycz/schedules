var printing_mode = false;
var settings_saved = true;

window.addEventListener("load", function () {
	show_options();
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
	var color_settings_group = document.getElementById("color_settings_group");
	var color_input_groups_container = document.getElementById("color_input_groups_container");

	var subjects_in_schedule = get_subjects_in_schedule();

	for (let subject in config.data.colors) {
		let hue = config.data.colors[subject];

		let new_input_group = "<div class='input_group'>" + `<label>${subject}</label>` + `<input type='range' min='0' max='360' value='${hue}'/>` + `<div class="color_preview" style="background-color: hsl(${hue}, 100%, 50%)"></div>`;

		if (subjects_in_schedule.indexOf(subject) >= 0) {
			new_input_group += `<button onclick="remove_color(this);" class="icon-delete" disabled></button>`;
		} else {
			new_input_group += `<button onclick="remove_color(this);" class="icon-delete"></button>`;
		}

		new_input_group += "</div>";

		color_input_groups_container.innerHTML += new_input_group;
	}

	var inputs = document.getElementsByTagName("input");
	for (input_element of inputs) {
		input_element.addEventListener("input", function (e) {
			settings_saved = false;
			document.getElementById("save_button").classList.add("positive");
			e.target.parentElement.getElementsByClassName("color_preview")[0].style.backgroundColor = `hsl(${e.target.value}, 100%, 50%)`;
		});
	}

	function get_subjects_in_schedule() {
		var subjects_in_schedule = [];

		for (let day of config.data.timetable) {
			let schedule = day.schedule;

			for (let period of schedule) {
				if (subjects_in_schedule.indexOf(period.subject) == -1 && period.subject != "") {
					subjects_in_schedule.push(period.subject);
				}
			}
		}

		return subjects_in_schedule;
	}
}

function remove_color(clicked_element) {
	clicked_element.parentElement.remove();
	settings_saved = false;
	document.getElementById("save_button").classList.add("positive");
}

function save() {
	var color_settings_input_groups = document.querySelectorAll("#color_input_groups_container > .input_group");
	var new_colors = {};

	for (let input_group of color_settings_input_groups) {
		var label = input_group.getElementsByTagName("label")[0];
		var input = input_group.getElementsByTagName("input")[0];

		new_colors[label.innerText] = input.value;
	}

	config.data.colors = new_colors;

	config.save_data(config.data);

	settings_saved = true;
	document.getElementById("save_button").classList.remove("positive");
}
