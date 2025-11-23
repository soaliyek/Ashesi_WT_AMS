function logout() {

    fetch("../api/logout.php", {
        method: "POST"
    })
    .then(response => response.json())
    .then(data => {

        if (data.status === "success") {
            // Redirect user back to login page
            window.location.href = "../authentication/usersignin.php";
        } else {
            console.error("Logout failed:", data.message);
        }

    })
    .catch(error => console.error("Error:", error));
}
