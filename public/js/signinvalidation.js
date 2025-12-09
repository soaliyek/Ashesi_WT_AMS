document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signin");
    const remarks = document.getElementById("remarks");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        remarks.innerHTML = ""; // Clear old messages

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Basic validation
        if (email.length === 0 || password.length === 0) {
            remarks.innerHTML = "<p>Please fill all fields.</p>";
            return;
        }

        if (!email.endsWith("@ashesi.edu.gh")) {
            remarks.innerHTML = "<p>Email must be an Ashesi email.</p>";
            return;
        }

        // Prepare data
        const formData = new FormData(form);

        // Send to backend
        fetch("../api/signin.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (data.status === "error") {
                remarks.innerHTML = `<p>${data.message}</p>`;
                return;
            }

            // SUCCESS → redirects based on role
            if (data.status === "success") {
                if (data.role === "student") {
                    window.location.href = "../student/courses.php";
                } else if (data.role === "faculty") {
                    window.location.href = "../faculty/courses.php";
                } else if (data.role === "admin") {
                    window.location.href = "../admin/courses.php";
                }
            }
        })
        .catch(err => {
            console.log(err);
            remarks.innerHTML = "<p>Oh oooooo. Try again.</p>";
        });
    });
});
