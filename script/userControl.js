/*TODO
    Control de roles de usuraio.
    NEW Tabla Administrador puede controlar a los Editores. Registra
*/


function Login(form)
{
	let url = './rest/POST/login.php'
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
            initMenu();
        }
	}
	
	return false;
}

function Logout()
{
    let link = './rest/GET/logout.php?user=' + sessionStorage.getItem('user');
    AjaxGETRequest(link, logoutSuccess);

    function logoutSuccess(response)
    {
        let objJSON = JSON.parse(response);

        if(objJSON.RESPONSE_CODE == 200)
        {
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('token');
            //Reinicializamos el menu
            document.getElementById('cssmenu').innerHTML = `<ul>
            <li class='active'><a href='index.html'><span>Inicio</span></a></li>
            <li><a href='#'><span>Consultas</span></a></li>
            <li class="rightside" id="loginform">
            </li>
            </ul>`;
            initMenu();
            VerifyUserInsertion();
        }
    }
}

function isAdmin()
{
    if(sessionStorage.getItem('user')!=null)
    {
        let link = `./rest/GET/admins.php?email=${sessionStorage.getItem('user')}`;
        AjaxGETRequest(link, adminVerification);

        function adminVerification(response)
        {
            let objJSON = JSON.parse(response);
            if(objJSON.BODY.EXISTS)
                redirectToAdminInterface();
        }
    }
    else
    {
        return false;
    }
    
}

function redirectToAdminInterface()
{
	window.location.replace('adminIndex.html');
}

function CheckSessionStatus()
{
	if(sessionStorage.getItem('user') == null)
	{
		return false;
	}
	return true;
}