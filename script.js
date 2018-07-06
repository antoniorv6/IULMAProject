function AjaxGETRequest(url, callbacksuccess)
{
	let xhr = new XMLHttpRequest();

	xhr.open('POST', url, true);

	xhr.onload = function()
	{
		callbacksuccess(xhr.responseText);
	}

	xhr.send();
}

function AjaxPOSTRequest (url, form, callbacksuccess)
{
	let formData = new FormData(),
		xhr = new XMLHttpRequest();

	formData.append('archivo', form);
	xhr.open('POST', url, true);
	xhr.onload = function()
	{
		callbacksuccess(xhr.responseText);
	}
	xhr.send(formData);
}

function SendGETRequest()
{
	AjaxGETRequest('./rest/GET/getRequest.php', output);

	function output(response)
	{
		console.log(response);
		let objson = JSON.parse(response);
		console.log(objson);
	}
}

function SendPOSTRequest()
{
	let data = document.getElementById('archivo').files[0];

	AjaxPOSTRequest('./rest/POST/postRequest.php', data, output);

	function output(response)
	{
		console.log(response);
		let objson = JSON.parse(response);
		console.log(objson);
	}

	return false;
}