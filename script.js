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
	xhr.onerror = function()
	{
		console.log(xhr.responseText);
	}

	formData.append('type', '1');
	xhr.send(formData);
}

function ClickForUpload()
{
	document.getElementById('archivo').click;
}

function SendPOSTRequest()
{
	let data = document.getElementById('archivo').files[0];

	AjaxPOSTRequest('rest/postHandler/', data, output);

	document.querySelector('form').innerHTML += `<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`;
	function output(response)
	{
		console.log(response);
		let objson = JSON.parse(response);
		console.log(objson);
		formPlace = document.getElementById('formPlace');
		formPlace.innerHTML = `
			<form onsubmit="return SendDataToDB(this)">
				<label for="surname">APELLIDOS</label>
				<input name = "surname" value="${objson.BODY.SURNAME}">
				
				<label for="name">NOMBRE</label>
				<input name = "name" value="${objson.BODY.NAME}">
				
				<label for="title">TÍTULO DE LA CRÓNICA</label>
				<input name = "title" value="${objson.BODY.TITLE}">
				
				<label for="source">FUENTE</label>
				<input name = "source" value="${objson.BODY.SOURCE}">
				
				<label for="place">LUGAR</label>
				<input name = "place" value="${objson.BODY.PLACE}">
				
				<label for="date">FECHA</label>
				<input name = "date" value="${objson.BODY.DATE}">
				
				<label for="page">PÁGINA</label>
				<input name = "page" value="${objson.BODY.PAGE}">
				
				<label for="column">COLUMNA</label>
				<input name = "column" value="${objson.BODY.COLUMN}">
				
				<label for="medium">MEDIO</label>
				<input name = "medium" value="${objson.BODY.MEDIUM}">
				
				<label for="language">IDIOMA</label>
				<input name = "language" value="${objson.BODY.LANGUAGE}">
				
				<label for="name">PAÍS</label>
				<input name = "name" value="${objson.BODY.COUNTRY}">
				
				<input type="submit">

			</form>
		`;
	}

	return false;
}