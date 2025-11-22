
function next(){
    const personalinfo = document.getElementById("part1");
    const accountinfo = document.getElementById("part2");

    personalinfo.style.display = "none";
    accountinfo.style.display = "flex";
}
function prev(){
    const personalinfo = document.getElementById("part1");
    const accountinfo = document.getElementById("part2");

    personalinfo.style.display = "flex";
    accountinfo.style.display = "none";
}


// Validation code
function validate(e){
    e.preventDefault();

    const fname = document.getElementById("fname");
    const lname = document.getElementById("lname");
    const id = document.getElementById("studentid");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const cpassword = document.getElementById("cpassword");

    const remarks = document.getElementById("remarks");
    const elems = [validName(fname.value), validName(lname.value), validID(id.value), validEmail(email.value), validPass(password.value), passMatch(password.value, cpassword.value)];
    const remarkelems = [];
    const remartypes = [
        "First Name Not Supported", "Last Name Not Supported",
        "ID Must Be 8 Digits Long", "Must Be an Ashesi Email",
        "Password Not Strong Enough", "Password Does Not Match"
    ];

    for(let i = 0; i < 6; i++){
        remarkelems[i] = document.createElement("p");
        remarkelems[i].innerText = remartypes[i];
        if(!elems[i]){
            remarks.appendChild(remarkelems[i]);
        }
    }

    const allValid = elems.every(Boolean);
    if(allValid){
        const form = e.target;
        form.submit();
    }else{
        console.log(elems);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signup");
    form.addEventListener("submit", validate);
});


const validName = (name) => {
    const regex = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    return !regex.test(name);
}

function validID(id){
    return id.trim().length == 8;
}

function validEmail(email){
    return email.includes("@ashesi.edu.gh");
}

function validPass(password){
    return password.trim().length >= 8;
}

function passMatch(password, cpassword){
    return password.trim() == cpassword.trim();
}