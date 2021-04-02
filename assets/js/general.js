if (localStorage.hasOwnProperty("schedule_dark")) {
	if (localStorage.getItem("schedule_dark") == "true") {
		document.body.classList.add("dark_mode");
		document.head.querySelector("[name='theme-color']").setAttribute("content", "#222");
	}
} else {
	localStorage.setItem("schedule_dark", false);
}

if (!localStorage.hasOwnProperty("schedule_disable-hints")) {
	localStorage.setItem("schedule_disable-hints", false);
}

window.addEventListener("beforeprint", function (event) {
    if (printing_mode !== true) {
    	var current_url_directory = window.location.href.substring(0, window.location.href.lastIndexOf("/"));
    	next_url = current_url_directory + "/" + "week?print";
        window.location.href = next_url;
    }
});