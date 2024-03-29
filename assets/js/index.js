window.addEventListener("load", function () {
	dom_setup();
	add_navigation_events();
	timetable.display_current();
	add_color_input_events();
});

function dom_setup() {
	create_header_buttons();
	refresh_periods_container();
	timetable.subject_divs.create();

	function create_header_buttons() {
		var header = document.getElementsByTagName("header")[0];
		var counter = 0;
		var delayClick = false;

		for (entry of config.data.timetable) {
			var new_button = document.createElement("button");

			new_button.innerText = translator.translate(entry.day).substring(0, 3);
			new_button.setAttribute("data-dayNumber", counter);

			new_button.addEventListener("click", function (e) {
			    if (delayClick == false && e.target.getAttribute("data-dayNumber") != timetable.currently_shown_day_number) {
    				var header_buttons = document.querySelectorAll("header > button");
    				
    				for (button of header_buttons) {
    					button.classList.remove("open");
    				}
    				
    				e.target.classList.add("open");
    				timetable.display_for_day(e.target.getAttribute("data-dayNumber"));
    				
    				setTimeout(function () {
    				    delayClick = false;
    				}, 800);
    				
    				delayClick = true;
			    }
			});

			header.appendChild(new_button);
			counter++;
		}
	}
}

function add_navigation_events() {
	add_swipe_events();
	add_keyboard_events();

	function add_swipe_events() {
		var timetable_div = document.getElementById("timetable");

		timetable_div.addEventListener("touchstart", function (e_start) {
			var touch_start_position = e_start.touches[0].clientX;

			function handleTouchMove(e_end) {
				var touch_end_position = e_end.touches[0].clientX;

				if (touch_start_position < touch_end_position - 75) {
					timetable_div.removeEventListener("touchmove", handleTouchMove);
					timetable.display_previous_day();
				} else if (touch_start_position > touch_end_position + 75) {
					timetable_div.removeEventListener("touchmove", handleTouchMove);
					timetable.display_next_day();
				}
			}

			timetable_div.addEventListener("touchmove", handleTouchMove);
		});
	}

	function add_keyboard_events() {
		var delayKey = false;

		function handleKeyboardEvent(e) {
			if (e.key === "ArrowLeft") {
				timetable.display_previous_day();
			} else if (e.key === "ArrowRight") {
				timetable.display_next_day();
			}
		}

		window.addEventListener("keydown", handleKeyboardEvent);
	}
}

var timetable = {
	currently_shown_day_number: -1,

	display_for_day: function (dayNumber) {
		timetable.currently_shown_day_number = dayNumber;

		timetable.subject_divs.hide();

		setTimeout(function () {
			timetable.subject_divs.fill(dayNumber);
			timetable.subject_divs.show();
		}, 450);
	},

	display_current: function () {
		var currentDate = new Date();
		var dayNumber = (currentDate.getDay() + 6) % 7;

		if (config.data.other.timeSkipNextDay.enabled && config.data.other.timeSkipNextDay.enabled === true) {
			var timeSkipNextDay = config.data.other.timeSkipNextDay.time || "1020";
			if (currentDate.getHours() * 60 + currentDate.getMinutes() >= timeSkipNextDay) {
				dayNumber += 1;
			}
		}

		var header_buttons = document.querySelectorAll("header > button");

		if (dayNumber >= config.data.timetable.length) {
			header_buttons[0].classList.add("open");
			timetable.display_for_day(0);
		} else {
			header_buttons[dayNumber].classList.add("open");
			timetable.display_for_day(dayNumber);
		}
	},

	display_previous_day: function () {
		var previous_day_number;
		var header_buttons = document.querySelectorAll("header > button");

		if (timetable.currently_shown_day_number != 0) {
			previous_day_number = parseInt(timetable.currently_shown_day_number) - 1;
			header_buttons[previous_day_number].click();
		}
	},

	display_next_day: function () {
		var next_day_number;
		var header_buttons = document.querySelectorAll("header > button");

		if (timetable.currently_shown_day_number != config.data.timetable.length - 1) {
			next_day_number = parseInt(timetable.currently_shown_day_number) + 1;
			header_buttons[next_day_number].click();
		}
	},

	subject_divs: {
		create: function () {
			var subjectsContainer = document.getElementById("subjects_container");

			for (let i = 0; i < config.data.periods.length; i++) {
				var subjectDiv = document.createElement("div");

				subjectDiv.classList.add("subject");
				subjectDiv.classList.add("hidden");
				subjectDiv.style.transitionDelay = i * 0.025 + "s";

				subjectDiv.innerHTML = "<span></span><span></span>";

				subjectDiv.addEventListener("click", function (e) {
					var clicked_subject_div = e.target;

					if (e.target.classList.contains("subject") === false) {
						clicked_subject_div = e.target.closest(".subject");
					}

					var day_index = timetable.currently_shown_day_number;
					var period_index = i;

					editor.show_schedule_edit_popup(day_index, period_index);
				});

				subjectsContainer.appendChild(subjectDiv);
			}
		},

		fill: function (dayNumber) {
			var subject_divs = document.querySelectorAll(".subject");

			for (let period = 0; period < config.data.timetable[dayNumber].schedule.length && period < config.data.periods.length; period++) {
				var subject_name = config.data.timetable[dayNumber].schedule[period].subject;
				var subject_room = config.data.timetable[dayNumber].schedule[period].room;

				if (subject_name == "" && subject_room == "") {
					subject_divs[period].classList.add("empty");
					subject_divs[period].querySelectorAll("span")[0].innerText = "+";
					subject_divs[period].querySelectorAll("span")[1].innerText = "";
					subject_divs[period].style.color = "";

					if (localStorage.getItem("schedule_disable-hints") == "true") {
						subject_divs[period].style.opacity = 0;
					}
				} else {
					subject_divs[period].classList.remove("empty");
					subject_divs[period].style.opacity = "";

					subject_divs[period].style.color = get_subject_color(subject_name);

					subject_divs[period].querySelectorAll("span")[0].innerHTML = subject_name.replace(/\r\n|\r|\n/g, "<br/>");
					subject_divs[period].querySelectorAll("span")[1].innerHTML = subject_room.replace(/\r\n|\r|\n/g, "<br/>");
				}
			}
		},

		show: function () {
			var subject_divs = document.querySelectorAll(".subject");

			for (div of subject_divs) {
				div.classList.remove("hidden");
			}
		},

		hide: function () {
			var subject_divs = document.querySelectorAll(".subject");

			for (div of subject_divs) {
				div.classList.add("hidden");
			}
		},
	},
};

function refresh_schedule_container() {
	document.getElementById("subjects_container").innerHTML = "";
	timetable.subject_divs.create();
	timetable.display_for_day(timetable.currently_shown_day_number);
}
