function ClickForUpload()
{
	document.getElementById('archivo').click;
}

function initMenu()
{
	if(CheckSessionStatus())
	{
		document.querySelector('ul').innerHTML += `<li><a href='data-insertion.html'><span>Insertar Datos</span></a></li>`;
		document.getElementById('loginform').innerHTML = `<button class="button" onclick="Logout()">Cerrar Sesión</button>`;

	}
	else
	{
		document.getElementById('loginform').innerHTML = `<form onsubmit="return Login(this)" id="menuform">
		<input type="text" name="email" id="email" placeholder="Email">
		<input type="pwd" name="pass" id="pwd" placeholder="Contraseña">
		<input type="submit">
		</form>`;
	}
}

function AnalyseDocument()
{
	let data = document.getElementById('archivo').files[0];

	AjaxPOSTRequestFile('rest/postHandler/', data, output);

	document.querySelector('form').innerHTML += `<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`;
	function output(response)
	{
		console.log(response);
		let objson = JSON.parse(response);
		console.log(objson);
		formPlace = document.querySelector('section');
		let whatToPut = null;
		if(objson.BODY.COLUMN != undefined)
		{
			whatToPut = objson.BODY.COLUMN;
		}
		formPlace.innerHTML = `
			<article class="instructions">
				<h2> 2. REVISAR DATOS ANALIZADOS Y AÑADIR DATOS OPCIONALES</h2>
				<h3> Por favor, revise los datos que hemos analizado de su documento y, si lo desea, añada datos adicionales para enriquecer la información del mismo</h3>
				<button class="button info" id="buttonAdd" onclick="AddNewParamenters()">Incluir datos adicionales</button>
			</article>
			<article id="formupload">
			<form onsubmit="return SendDataToDB(this)" class="uploadform">
				<p><b>Datos obligatorios</b></p>
				<label for="abbreviation">ABREVIACIÓN</label>
				<input name="abbreviation" value="${objson.BODY.ABBREVIATION}">

				<label for="surname">APELLIDOS</label>
				<input name = "surname" value="${objson.BODY.SURNAME}">
				
				<label for="name">NOMBRE</label>
				<input name = "name" value="${objson.BODY.NAME}">
				
				<label for="title">TÍTULO DE LA CRÓNICA</label>
				<input name = "title" value="${objson.BODY.TITLE}">

				<label for="gen_title">TÍTULO GENERAL DE LA CRÓNICA</label>
				<input name= "gen_title" value="${objson.BODY.GEN_TITLE}">
				
				<label for="source">FUENTE</label>
				<input name = "source" value="${objson.BODY.SOURCE}">
				
				<label for="place">LUGAR</label>
				<input name = "place" value="${objson.BODY.PLACE}">
				
				<label for="date">FECHA</label>
				<input name = "date" value="${objson.BODY.DATE}">
				
				<label for="page">PÁGINA</label>
				<input name = "page" value="${objson.BODY.PAGE}">
				
				<label for="column">COLUMNA</label>
				<input name = "column" value="${whatToPut}">
				
				<label for="medium">MEDIO</label>
				<input name = "medium" value="${objson.BODY.MEDIUM}">
				
				<label for="language">IDIOMA</label>
				<input name = "language" value="${objson.BODY.LANGUAGE}">
				
				<label for="country">PAÍS</label>
				<input name = "country" value="${objson.BODY.COUNTRY}">

				<input name = "user" value="${sessionStorage.getItem('user')}" hidden>
				<input name = "filepath" value="${objson.BODY.PATH}" hidden>
				<textarea name = "content" hidden>${objson.BODY.CONTENT}</textarea>
				<input type="submit" class="button addParameters" value = "Subir">

			</form>

			</article>
		`;
	}

	return false;
}

function SendDataToDB(form)
{
	AjaxPOSTRequest('rest/postHandler/',form, showConfirmation);

	function showConfirmation(response)
	{
		objJSON = JSON.parse(response);
		section = document.querySelector('section');
		if(objJSON.BODY.RESULT == "OK")
		{
			console.log(objJSON);
			section.innerHTML = `
				<article class = "instructions">
					<h2 class = "success"> ENHORABUENA </h2>
					<h3>${objJSON.BODY.MESSAGE}</h3>
					<a href="data-insertion.html" class="button"> Realizar otra inserción </a>
				</article>
			`;
		}
	}

	return false;
}

function VerifyUserInsertion()
{
	if(!CheckSessionStatus())
	{
		console.log('hola');
		window.location.replace('index.html');
	}
}

function updateDisclaimer()
{
	document.getElementById('disclaimer').innerText = document.getElementById('archivo').files[0].name;
}

function AddNewParamenters()
{
	document.getElementById('buttonAdd').outerHTML = null;
	document.getElementById('formupload').innerHTML += `<form class="uploadform">
	<label>Parameter 1</label>
	<input type="text" placeholder ="p1">
	<label>Parameter 2</label>
	<input type = "text" placeholder = "p2">`;
}

function prop()
{
	console.log("Hacer consulta");
}

function sendAllRequest()
{
	AjaxGETRequest('rest/column/', PresentResult);
}

function SearchByWord()
{
	let word = document.getElementById('wordSearch').value;
	console.log(word);
	let url = 'rest/column/?search='+word;
	AjaxGETRequest(url, PresentResult);
}

function PresentResult(response)
{
	let objJSON = JSON.parse(response);
	console.log(objJSON);
	let placer = document.querySelector('.results');
	placer.innerHTML = null;
	objJSON.BODY.forEach( function(element)
		{
			placer.innerHTML += `<article class="data">
			<p><b>Autor:</b>${element.Author_Name} ${element.Author_surname}</p>
			<p><b>Título: </b>${element.Title}</p>
			<p><b>Fecha: </b>${element.Dateofcreation}</p>
			<p><b>Descarga el documento: <a href = ${element.Filepath}><span class="icon-doc"></span></a></p>
			</article>`;
		}); 
		
}

function checkOptions()
{
	//TODO, set all columns in admin view
	let selects = document.querySelectorAll('select');

	selects.forEach(function(child)
		{
			if(child.childElementCount < 7)
			{
				child.style.overflow = 'hidden';
			}
		});
}