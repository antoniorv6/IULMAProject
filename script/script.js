function ClickForUpload()
{
	document.getElementById('archivo').click;
}

function CheckStatus()
{
	if(sessionStorage.getItem('user')!=null)
	{
		document.querySelector('article').innerHTML = `<form onsubmit="return SendPOSTRequest(this)">
		<label for="archivo" onclick="ClickForUpload()" id="uploader"><span class="icon-folder-open-empty"></span>Subir un fichero</label>
		<input type="file" id="archivo" name="archivo" hidden>
		<input type="submit" value="Analizar" class="button">
		</form>`;
		document.getElementById('loginform').innerHTML = `<button class="button" onclick="Logout()">Cerrar Sesión</button>`;
	}
	else
	{
		document.querySelector('article').innerHTML = `<h1>BIENVENIDO A LA WEB</h1>
		<h2>Inicia sesión para poder interactuar</h2>`;
		document.getElementById('loginform').innerHTML = `
		<form onsubmit="return Login(this)" id="menuform">
			<input type="text" name="email" id="email" placeholder="Email">
			<input type="pwd" name="pass" id="pwd" placeholder="Contraseña">
			<input type="submit">
		</form>`;
	}
}