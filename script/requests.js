function AjaxPOSTRequestFile (url, form, callbacksuccess)
{
	let formData = new FormData(),
		xhr = new XMLHttpRequest();

	formData.append('archivo', form);
	xhr.open('POST', url, true);
	xhr.onload = function()
	{
		callbacksuccess(xhr.responseText);
	}
	xhr.onerror = function()
	{
		console.log(xhr.responseText);
	}

	formData.append('type', '1');
	xhr.send(formData);
}

function AjaxPOSTRequest (url, form, callbacksuccess)
{
	let formData = new FormData(form),
		xhr = new XMLHttpRequest();

	xhr.open('POST', url, true);
	xhr.onload = function()
	{
		callbacksuccess(xhr.responseText);
	}
	xhr.onerror = function()
	{
		console.log(xhr.responseText);
	}

	formData.append('type', '2');
	xhr.send(formData);
}

function AjaxGETRequest(url, callbacksuccess, variables)
{
	let xhr = new XMLHttpRequest();

	xhr.open('GET', url, true);

	xhr.onload = function()
	{
		console.log(xhr.responseText);
		if(variables == undefined)
			callbacksuccess(xhr.responseText);
		else
			callbacksuccess(xhr.responseText, variables);

	}

	xhr.send();
}