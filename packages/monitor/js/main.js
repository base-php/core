function app()
{
	return {
		reloadWithType() {
			type = document.getElementById('type').value;
			href = window.location.protocol + '//' + window.location.host + '/monitor/' + type;
			window.location.href = href;
		}
	}
}