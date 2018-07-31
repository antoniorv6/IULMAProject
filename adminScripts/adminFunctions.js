
function getAllUsers()
{
    let link = 'rest/users/';

    AjaxGETRequest(link, showRegisteredUsers);

    function showRegisteredUsers(list)
    {
        let objJSON = JSON.parse(list);
        let tableBody = document.getElementById('users');
        console.log(objJSON);
        
        objJSON.BODY.forEach(function(element)
        {
            tableBody.innerHTML += `<tr>
                                        <td>${element.email}</td>
                                        <td>${element.name}</td>
                                        <td>${element.surname}</td>
                                        <td><button>Eliminar usuario</button></td>
                                    </tr>`
        });
    }
}

function checkIfAdmin()
{
    let link = `rest/admin/?email=${sessionStorage.getItem('user')}`;
        
    AjaxGETRequest(link, checkIfTrue);

    function checkIfTrue(response)
    {
        let objJSON = JSON.parse(response);
            if(!objJSON.BODY.EXISTS)
                window.location.replace('index.html');
    }
}

function GenerateRandomPwd()
{    
    let password = Math.random().toString(36).slice(-16);
    console.log(password);
    document.getElementById('pass').value = password;
}

function SendRegisterRequest(form)
{
    AjaxPOSTRequest('rest/register/', form, registerResponse);

    function registerResponse(response)
    {
        let objJSON = JSON.parse(response);
        console.log(objJSON);
        if(objJSON.RESULT == 'OK')
        {
            window.location.replace('index.html');
        }
    }

    return false;
}

function GetAllColumns()
{
    AjaxGETRequest('rest/column/', PresentResult);

	function PresentResult(response)
	{
		let objJSON = JSON.parse(response);
		console.log(objJSON);
	}
}