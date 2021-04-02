function transition_to_page(relative_url) {
	document.body.style.opacity = 0;
	var next_url;
	setTimeout(function () {
		if (relative_url.startsWith("http://") || relative_url.startsWith("https://")) {
			next_url = relative_url;
		} else {
			var current_url_directory = window.location.href.substring(0, window.location.href.lastIndexOf("/"));
			next_url = current_url_directory + "/" + relative_url;
		}
		window.location = next_url;
	}, 200);
}

function transition_back() {
	document.body.style.opacity = 0;

	setTimeout(function () {
		window.history.back();
	}, 200);
}

window.addEventListener("load", function () {
	setTimeout(function () {
		document.body.style.opacity = 1;
	}, 200);
});
