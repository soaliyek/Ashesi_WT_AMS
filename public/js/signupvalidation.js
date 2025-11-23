function next() {
    const personalinfo = document.getElementById("part1");
    const accountinfo = document.getElementById("part2");

    personalinfo.style.display = "none";
    accountinfo.style.display = "flex";
}
function prev() {
    const personalinfo = document.getElementById("part1");
    const accountinfo = document.getElementById("part2");

    personalinfo.style.display = "flex";
    accountinfo.style.display = "none";
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signup");
    form.addEventListener("submit", validate);
});

function validate(e) {
    e.preventDefault();

    const remarks = document.getElementById("remarks");
    remarks.innerHTML = "";

    const fname = document.getElementById("fname").value.trim();
    const lname = document.getElementById("lname").value.trim();
    const role = document.getElementById("role").value;
    const studentId = document.getElementById("studentid").value.trim();
    const major = document.getElementById("major").value;

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const cpassword = document.getElementById("cpassword").value;

    // Client-side validation
    const errors = [];

    if (!validName(fname)) errors.push("Invalid First Name.");
    if (!validName(lname)) errors.push("Invalid Last Name.");

    if (role === "0") errors.push("Please select a role.");

    if (role === "student") {
        if (!validID(studentId)) errors.push("Student ID must be 8 digits.");
        if (major === "0") errors.push("Please select your major.");
    }

    if (!validEmail(email)) errors.push("Email must be an Ashesi email.");
    if (!validPass(password)) errors.push("Password not strong enough.");
    if (!passMatch(password, cpassword)) errors.push("Passwords do not match.");

    if (errors.length > 0) {
        errors.forEach(err => {
            const p = document.createElement("p");
            p.innerText = err;
            remarks.appendChild(p);
        });
        return;
    }

    const formData = new FormData(e.target);

    fetch("../api/signup.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const p = document.createElement("p");
            p.innerText = data.message;
            remarks.appendChild(p);

            if (data.status === "success") {
                setTimeout(() => {
                    window.location.href = "usersignin.php";
                }, 1500);
            }
        })
        .catch(error => {
            const p = document.createElement("p");
            p.innerText = error;
            remarks.appendChild(p);
        });
}

const validName = (name) => /^[\p{L} '-]+$/u.test(name);
const validID = (id) => /^[0-9]{8}$/.test(id);
const validEmail = (email) => email.endsWith("@ashesi.edu.gh");
const validPass = (password) => password.trim().length >= 8;
const passMatch = (p, cp) => p === cp;