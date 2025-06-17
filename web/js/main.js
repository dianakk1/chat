window.addEventListener('message', function(e) {
	if (e.data.action === 'redirect' && e.data.url) {
		window.location.href = e.data.url;
	}
});