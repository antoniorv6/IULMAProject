function Login(form)
{
	let url = 'rest/login/'
	AjaxPOSTRequest(url, form, checkLogin);

	function checkLogin(response)
	{
        console.log(response);
		let objJSON = JSON.parse(response);
        console.log(objJSON);
        if(objJSON.RESPONSE_CODE == 200)
        {
            sessionStorage.setItem('user', objJSON.BODY.USER);
            sessionStorage.setItem('token', objJSON.BODY.SESSION_TOKEN);
            document.getElementById('loginform').innerHTML = `<button class="button" onclick="Logout()">Cerrar Sesión</button>`;
        }
	}
	
	return false;
}

function Logout()
{
    let link = 'rest/logout/?user=' + sessionStorage.getItem('user');
    AjaxGETRequest(link, logoutSuccess);

    function logoutSuccess(response)
    {
        let objJSON = JSON.parse(response);

        if(objJSON.RESPONSE_CODE == 200)
        {
            console.log('logout guay');
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('token');
            document.getElementById('loginform').innerHTML = `
            <form onsubmit="return Login(this)" id="menuform">
                <input type="text" name="email" id="email" placeholder="Email">
                <input type="pwd" name="pass" id="pwd" placeholder="Contraseña">
                <input type="submit">
            </form>`;
        }
    }
}