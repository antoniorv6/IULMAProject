
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

	AjaxPOSTRequestFile('./rest/POST/post_handler.php', data, output);

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
				
				<label for="source">NOMBRE DEL PERIÓDICO</label>
				<input name = "source" value="${objson.BODY.SOURCE}">
				
				<label for="place">LUGAR</label>
				<input name = "place" value="${objson.BODY.PLACE}">
				
				<label for="date">FECHA</label>
				<input name = "date" value="${objson.BODY.DATE}">
				
				<label for="page">PÁGINA</label>
				<input name = "page" value="${objson.BODY.PAGE}">
				
				<label for="column">COLUMNA</label>
				<input name = "column" value="${whatToPut}">
				
				<label for="medium">TIPO DE MEDIO</label>
				<input name = "medium" value="${objson.BODY.MEDIUM}">
				
				<label for="language">IDIOMA</label>
				<input name = "language" value="${objson.BODY.LANGUAGE}">
				
				<label for="country">PAÍS</label>
				<input name = "country" value="${objson.BODY.COUNTRY}">

				<input name = "user" value="${sessionStorage.getItem('user')}" hidden>
				<input name = "filepath" value="${objson.BODY.PATH}" hidden>
				<textarea name = "content" hidden>${objson.BODY.CONTENT}</textarea>

				<label>Profesión</label>
				<div id="profession">
					<label><input type="checkbox" name="profession[]" value="Lingüista">Lingüista</label>
					<label><input type="checkbox" name="profession[]" value="Periodista">Periodista</label>
					<label><input type="checkbox" name="profession[]" value="Corrector de estilo">Corrector de estilo</label>
					<label><input type="checkbox" name="profession[]" value="Otro">Otro</label>
				</div>
				<label>Estilo</label>
				<div id="style">
					<label><input type="checkbox" name="style[]" value="Prescriptivo">Prescriptivo</label>
					<label><input type="checkbox" name="style[]" value="Descriptivo">Descriptivo</label>
					<label><input type="checkbox" name="style[]" value="Lúdico">Lúdico</label>
				</div>
				<label>Política lingüística</label>
				<select name="policy">
					<option>-</option>
					<option value="Si">Sí</option>
					<option value="No">No</option>
				</select>
				<label>Dimensión lingüística</label>
				<div id="dimention">
					<label><input type="checkbox" name="dimention[]" value="Fonética">Fonética</label>
					<label><input type="checkbox" name="dimention[]" value="Tipografía">Tipografía</label>
					<label><input type="checkbox" name="dimention[]" value="Morfología">Morfología</label>
					<label><input type="checkbox" name="dimention[]" value="Sintaxis">Sintaxis</label>
					<label><input type="checkbox" name="dimention[]" value="Léxico">Léxico</label>
					<label><input type="checkbox" name="dimention[]" value="Léxico">Retórica</label>
					<label><input type="checkbox" name="dimention[]" value="Léxico">Pragmática y textualidad</label>
				</div>
				<label>Préstamos</label>
				<div id="loans">
					<label><input type="checkbox" name="loans[]" value="Anglicismo">Anglicismo</label>
					<label><input type="checkbox" name="loans[]" value="Germanismo">Germanismo</label>
					<label><input type="checkbox" name="loans[]" value="Latinismo">Latinismo</label>
					<label><input type="checkbox" name="loans[]" value="Galicismo">Galicismo</label>
					<label><input type="checkbox" name="loans[]" value="Hispanismo">Hispanismo</label>
					<label><input type="checkbox" name="loans[]" value="Italicismo">Italicismo</label>
                </div>
				<label>Neologismo</label>
				<select name="neologism">
					<option>-</option>
					<option value="Si">Sí</option>
					<option value="No">No</option>
				</select>
				<label>Formación de palabras</label>
				<div id="wordformation">
					<label><input type="checkbox" name="wordformation[]" value="Abreviación">Abreviación</label>
					<label><input type="checkbox" name="wordformation[]" value="Tipografía">Tipografía</label>
					<label><input type="checkbox" name="wordformation[]" value="Prefijación">Prefijación</label>
					<label><input type="checkbox" name="wordformation[]" value="Sufijación">Sufijación</label>
				</div>
				<label>Etimología</label>
				<select name="etimology">
					<option>-</option>
					<option value="Si">Sí</option>
					<option value="No">No</option>
				</select>
				<input type="submit" class="button addParameters" value = "Subir">

			</form>

			</article>
		`;
	}

	return false;
}

function SendDataToDB(form)
{
	AjaxPOSTRequest('./rest/POST/post_handler.php',form, showConfirmation);

	function showConfirmation(response)
	{
		console.log(response);
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

function SearchByParameter()
{
	console.log("Hacer consulta");
	let query = '';
	let selects = document.querySelectorAll('select');
	let howmany = 0;
	selects.forEach(function(element)
	{
		if(element.options.selectedIndex != -1)
		{
			if(howmany == 0)
				query += element.id + '=' + "'" + element.options[element.options.selectedIndex].value + "' ";
			else
				query += 'AND '+ element.id + '=' + "'" + element.options[element.options.selectedIndex].value + "' ";
			
			howmany++;
		}
	});
	console.log(query);
	url = './rest/GET/get_handler.php?query=' + query; 
	AjaxGETRequest(url, PresentResult, undefined);
}

function sendAllRequest()
{
	AjaxGETRequest('./rest/GET/get_handler.php', PresentResult, undefined);
}

function SearchByWord()
{
	let word = document.getElementById('wordSearch').value;
	console.log(word);
	let url = './rest/GET/get_handler.php?search='+word;
	AjaxGETRequest(url, PresentResult, undefined);
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
			<a class="button" href="entry.html?id=${element.ID}">Ver entrada completa</button>
			</article>`;
		}); 
		
}

function DemandParameters()
{
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Author_Name', PutParameters, 'Author_Name');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Author_surname', PutParameters, 'Author_surname');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Title', PutParameters, 'Title');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=gen_title', PutParameters, 'gen_title');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Place', PutParameters, 'Place');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Source', PutParameters, 'Source');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Medium', PutParameters, 'Medium');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Dateofcreation', PutParameters, 'Dateofcreation');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Language_written', PutParameters, 'Language_written');
	AjaxGETRequest('./rest/GET/consultparameters.php?param=Country', PutParameters, 'Country');
}

function PutParameters(response, theId)
{
	let objJSON = JSON.parse(response);
	console.log(theId);
	let place = document.getElementById(theId);
	objJSON.BODY.forEach(function(element)
	{
		console.log(element);
		place.innerHTML += `<option value="${element}">${element}</option>`;
	});
}

function getvariablesURL(nombre)
{
	url = window.location.href;
	nombre = nombre.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + nombre + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if(results == null)
    	return undefined;
    return results[2];
}

function getColumn()
{
	let id = getvariablesURL('id');
	console.log(id);

	url = './rest/GET/get_handler.php?query=' + "ID = " + "'" + id + "'";
	url2 = './rest/GET/get_add_data.php?id='+ id
	AjaxGETRequest(url, PresentColumn, undefined);
	AjaxGETRequest(url2, PresentAditionalData);
	CheckEditButton(id);

}

function PresentColumn(response)
{
	let columnJSON = JSON.parse(response);
	console.log(columnJSON);

	let articleContainer = document.getElementById('principalData');
	articleContainer.innerHTML = `
		<h3>${columnJSON.BODY[0].Title}</h3>
		<ul>
			<li>Título general: ${columnJSON.BODY[0].gen_title}</li>
			<li>Nombre del autor: ${columnJSON.BODY[0].Author_Name}</li>
			<li>Apellidos del autor: ${columnJSON.BODY[0].Author_surname}</li>
			<li>País: ${columnJSON.BODY[0].Country}</li>
			<li>Lugar: ${columnJSON.BODY[0].Place}</li>
			<li>Fecha: ${columnJSON.BODY[0].Dateofcreation}</li>
			<li>Idioma: ${columnJSON.BODY[0].Language_written}</li>
			<li>Nombre del periódico: ${columnJSON.BODY[0].Source}</li>
		<ul>
	`
}

function PresentAditionalData(response)
{
	let addataJSON = JSON.parse(response);
	console.log(addataJSON);

	let secondaryContainer = document.getElementById('secondaryData');

	secondaryContainer.innerHTML = `
	<ul>
		<li>Profesión: ${addataJSON.BODY[0].profession}</li>
		<li>Dimensión Lingüística: ${addataJSON.BODY[0].dimention}</li>
		<li>Etimología: ${addataJSON.BODY[0].etimology}</li>
		<li>Préstamos: ${addataJSON.BODY[0].loans}</li>
		<li>Política lingüística: ${addataJSON.BODY[0].lpolicy}</li>
		<li>Neologismo: ${addataJSON.BODY[0].neologism}</li>
		<li>Estilo: ${addataJSON.BODY[0].style}</li>
		<li>Formación de palabras: ${addataJSON.BODY[0].wordformation}</li>
	<ul>
	`
}

function CheckEditButton(id)
{
	if(CheckSessionStatus())
	{
		document.getElementById('buttonEdit').innerHTML = `<a href="editColumn.html?id=${id}" class="button">Editar columna</a>`
	}
}

function initEditForm()
{
	let id = getvariablesURL('id');
	console.log(id);

	url = './rest/GET/get_handler.php?query=' + "ID = " + "'" + id + "'";
	url2 = './rest/GET/get_add_data.php?id='+ id
	AjaxGETRequest(url, AddPrincipalParameters, undefined);
	AjaxGETRequest(url2, AddSecondaryParameters);
}

function AddPrincipalParameters(response)
{
	let JSONPrincipal = JSON.parse(response);

	let inputs = document.querySelectorAll('input');
	console.log(inputs);

	inputs[0].value = JSONPrincipal.BODY[0].Abbreviation
	inputs[2].value = JSONPrincipal.BODY[0].Author_Name
	inputs[1].value = JSONPrincipal.BODY[0].Author_surname
	inputs[3].value = JSONPrincipal.BODY[0].Title
	inputs[4].value = JSONPrincipal.BODY[0].gen_title
	inputs[5].value = JSONPrincipal.BODY[0].Source
	inputs[6].value = JSONPrincipal.BODY[0].Place
	inputs[7].value = JSONPrincipal.BODY[0].Dateofcreation
	inputs[8].value = JSONPrincipal.BODY[0].Col
	inputs[9].value = JSONPrincipal.BODY[0].Medium
	inputs[10].value = JSONPrincipal.BODY[0].Language_written
	inputs[11].value = JSONPrincipal.BODY[0].Country
}

function AddSecondaryParameters(response)
{
	let JSONSecundario = JSON.parse(response);

	console.log("JSONSec: ");
	console.log(JSONSecundario);

	JSONSecundario.BODY.forEach(function(element){
		for(var key in element)
		{
			console.log(key);
			checkSecondaryParams(key, element[key]);
		}
	});
	
	checkSecondarySelects('policy',JSONSecundario.BODY[0].lpolicy);
	checkSecondarySelects('neologism',JSONSecundario.BODY[0].neologism);
	checkSecondarySelects('etimology',JSONSecundario.BODY[0].etimology);
}

function checkSecondarySelects(formID, result)
{
	let input = document.getElementById(formID);
	switch(result)
	{
		case 'Si':
			input.selectedIndex = 1;
		break;
		case 'No':
			inputs.selectedIndex = 2;
		break;	
	}
}

function checkSecondaryParams(formID, queryString)
{
	let allocator = document.getElementById(formID);
	let stringSearch = queryString.split(",");

	if(allocator != null)
	{
		for(var i = 0; i<allocator.childElementCount; i++)
		{
			for(var j = 0; j<stringSearch.length; j++)
			{
				if(allocator.children[i].children[0] != undefined && allocator.children[i].children[0].value == stringSearch[j])
				{
					allocator.children[i].children[0].checked = true;
				}
			}
		}
	}
}

function EditColumn()
{
	let id = getvariablesURL('id');
	console.log(id);
	
	EditMainParameters(id);
	EditSecondaryParameters(id);

	return false;
}

function EditMainParameters(id)
{
	let queryString = 'UPDATE `column` SET ';
	let inputs = document.querySelectorAll('input');
	queryString += "Author_surname =" + "'" + inputs[1].value +"',"
	queryString += "Author_Name =" + "'" + inputs[2].value +"',"
	queryString += "Title =" + "\"" + inputs[3].value +"\","
	queryString += "gen_title =" + "'" + inputs[4].value +"',"
	queryString += "Source =" + "'" + inputs[5].value +"',"
	queryString += "Place =" + "'" + inputs[6].value +"',"
	queryString += "Dateofcreation =" + "'" + inputs[7].value +"',"
	queryString += "Col =" + "'" + inputs[8].value +"',"
	queryString += "Medium =" + "'" + inputs[9].value +"',"
	queryString += "Language_written =" + "'" + inputs[10].value +"',"
	queryString += "Country =" + "'" + inputs[11].value + "' "
	queryString += "WHERE ID = " + "'" + id + "'"
	

	console.log(queryString);

	let url = './rest/GET/editColumn.php?query=' + queryString;

	AjaxGETRequest(url, UpdateResponse);
}

function UpdateResponse(response)
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
				</article>
			`;
		}
}

function EditSecondaryParameters(id)
{
	let queryString = 'UPDATE additionaldata SET ';
	let inputs = document.querySelectorAll('select');
	
	queryString += "lpolicy =" + "'" + inputs[0].value +"',"
	queryString += "neologism =" + "'" + inputs[1].value +"',"
	queryString += "etimology =" + "'" + inputs[2].value +"',"
	
	queryString += appendCheckBoxValuesToQuery('profession', false);
	queryString += appendCheckBoxValuesToQuery('style', false);
	queryString += appendCheckBoxValuesToQuery('dimention', false);
	queryString += appendCheckBoxValuesToQuery('loans', false);
	queryString += appendCheckBoxValuesToQuery('wordformation', true);
	
	queryString += "WHERE article = " + "'" + id + "'"

	console.log(queryString);

	let url = './rest/GET/editColumn.php?query=' + queryString;

	AjaxGETRequest(url, UpdateResponse);
}

function appendCheckBoxValuesToQuery(identificator, last)
{
	var array = document.getElementsByName(identificator + '[]');
	var result = identificator + "=" + '"';
	var firstone = true;
	var inserted = false;

	for(var i = 0; i<array.length; i++)
	{
		if(array[i].checked == true)
		{
			if(firstone)
			{
				result += array[i].value
				firstone = false;
				inserted = true;
			}
			else
				result += ',' + array[i].value
		}
	}

	if(!inserted)
		result += "-"
	
	result += '"';

	if(last)
		return result;

	result += ','

	return result;
}