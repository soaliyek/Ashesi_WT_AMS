

document.addEventListener("DOMContentLoaded", function(){
    const login = document.getElementById("login");
    const signup = document.getElementById("signup");

    if(signup){
        const form = signup.querySelector("#functional");

        form.addEventListener("submit", function(e){
            e.preventDefault();

            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const password_valid = document.getElementById("conf_password");
            
            if(validate_email(email.value) && validate_password_length(password.value) && password_match(password.value, password_valid.value)){
                form.submit();
            }
        })
    }
    else if(login){
        const form = login.querySelector("#functional");
        form.addEventListener("submit", function(e){
            e.preventDefault();

            const email = document.getElementById("email");
            const password = document.getElementById("password");

            if(validate_email(email.value) && validate_password_length(password.value)){
                form.submit();
            }
        })
    }
});


// Working
function validate_email(this_email){
    if(this_email.includes("@ashesi.edu.gh")){
        return true;
    }else{
        return false;
    }
}

// Working
function validate_password_length(this_pass){
    if(this_pass.length < 8){
        return false;
    }else{
        return true;
    }
}

// Working
function password_match(this_pass, that_pass){
    if(this_pass === that_pass){
        return true;
    }else{
        return false;
    }
}
