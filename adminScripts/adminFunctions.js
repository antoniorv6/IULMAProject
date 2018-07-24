
function getAllUsers()
{
    let link = 'rest/users/';

    AjaxGETRequest(link, showRegisteredUsers);

    function showRegisteredUsers(list)
    {
        let objJSON = JSON.parse(list);
        console.log(objJSON);
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