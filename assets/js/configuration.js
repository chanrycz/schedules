var config = {
	data: {},

	save_data: function (new_data) {
		var formData = new FormData();
		formData.append("data", encodeURI(JSON.stringify(new_data)));
		
		console.log(new_data);

		const xhttp = new XMLHttpRequest();
		xhttp.overrideMimeType("application/json");
		xhttp.open("POST", "file?write=true", false);
		xhttp.onreadystatechange = function () {
			if (xhttp.readyState == 4 && xhttp.status == "200") {
				var jsonResponse = JSON.parse(xhttp.responseText);
				if (jsonResponse.success) {
					iziToast.show({
						title: "Success",
						message: jsonResponse.message,
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "green",
						icon: "icon-success",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
				} else if (jsonResponse.error) {
					iziToast.show({
						title: "Error",
						message: jsonResponse.message,
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "red",
						icon: "icon-error",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
				} else {
					iziToast.show({
						title: "Error",
						message: "An error occurred while saving the data.",
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "red",
						icon: "icon-error",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
				}
			}
		};
		xhttp.send(formData);
	},

	reset_data: function () {
		const xhttp = new XMLHttpRequest();
		xhttp.overrideMimeType("application/json");
		xhttp.onreadystatechange = function () {
			if (xhttp.readyState == 4 && xhttp.status == "200") {
				var jsonResponse = JSON.parse(xhttp.responseText);
				if (jsonResponse.success) {
					iziToast.show({
						title: "Success",
						message: jsonResponse.message,
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "green",
						icon: "icon-success",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
					delete jsonResponse["success"];
					delete jsonResponse["message"];
					config.data = jsonResponse;
				} else if (jsonResponse.error) {
					iziToast.show({
						title: "Error",
						message: jsonResponse.message,
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "red",
						icon: "icon-error",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
				} else {
					iziToast.show({
						title: "Error",
						message: "An error occurred while trying to reset data.",
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "red",
						icon: "icon-error",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
				}
			}
		};
		xhttp.open("GET", `file?reset`, false);
		xhttp.send();
	},

	load_data: function () {
		const xhttp = new XMLHttpRequest();
		xhttp.overrideMimeType("application/json");
		xhttp.onreadystatechange = function () {
			if (xhttp.readyState == 4 && xhttp.status == "200") {
				var jsonResponse = JSON.parse(xhttp.responseText);
				if (jsonResponse.success) {
					delete jsonResponse["success"];
					delete jsonResponse["message"];
					config.data = jsonResponse;
				} else if (jsonResponse.error) {
					const xhttp2 = new XMLHttpRequest();
					xhttp2.overrideMimeType("application/json");
					xhttp2.onreadystatechange = function () {
						if (xhttp2.readyState == 4 && xhttp2.status == "200") {
							var backupJsonResponse = JSON.parse(xhttp2.responseText);
							if (backupJsonResponse.success) {
								delete backupJsonResponse["success"];
								delete backupJsonResponse["message"];
								config.data = backupJsonResponse;
							} else if (backupJsonResponse.error) {
								iziToast.show({
									title: "Error",
									message: backupJsonResponse.message,
									theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
									color: "red",
									icon: "icon-error",
									zindex: 1000,
									balloon: false,
									close: true,
									position: "bottomRight",
									timeout: 5000,
									animateInside: false,
									drag: true,
									pauseOnHover: true,
									progressBar: false,
								});
							} else {
								iziToast.show({
									title: "Error",
									message: "An error occurred while trying to fetch data template",
									theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
									color: "red",
									icon: "icon-error",
									zindex: 1000,
									balloon: false,
									close: true,
									position: "bottomRight",
									timeout: 5000,
									animateInside: false,
									drag: true,
									pauseOnHover: true,
									progressBar: false,
								});
							}
						}
					};
					xhttp2.open("GET", "file?empty", false);
					xhttp2.send();
				} else {
					iziToast.show({
						message: "An error occurred while trying to fetch data",
						theme: (localStorage.hasOwnProperty("schedule_dark") && localStorage.getItem("schedule_dark") == "true" && printing_mode !== true) ? "light" : "dark",
						color: "red",
						icon: "icon-error",
						zindex: 1000,
						balloon: false,
						close: true,
						position: "bottomRight",
						timeout: 5000,
						animateInside: false,
						drag: true,
						pauseOnHover: true,
						progressBar: false,
					});
				}
			}
		};
		xhttp.open("GET", "file", false);
		xhttp.send();
	},
};

config.load_data();
