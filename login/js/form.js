/*
//first function to test form functionality
function submitForm(){
    alert("It works!");
}
*/

//form validation and submission function
function submitForm()
{
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    if(username != "" && password != ""){
        //during web session (within the form html document) the username and password will be locally stored & accessed
        localStorage.setItem('username', username.value);
        localStorage.setItem('password',password.value);

        alert("login sucessfully");
        //output to message to the web browser's console for testing purposes
        console.log(username, password);
    }else{
        alert("Username and password were not entered");
    }
};