
// Faculty Accept/Deny Enrollment request
const deny = document.getElementById("den");
deny.addEventListener("click", function(e){
    const request = new XMLHttpRequest();
    const data =  new FormData();

    data.append("requestId", e.target.value);
    data.append("operation", e.target.innerHTML.trim());

    request.open("POST", "../api/decision.php", true);
    //request.setRequestHeader("Content-Type", "application/json");
    //alert(e.target.value);

    request.onreadystatechange = function(){
        if(request.readyState === XMLHttpRequest.DONE && request.status === 200){
            // Process the reponse
            //const response = JSON.parse(request.responseText);
            console.log("Successful: ", request.responseText);
            //console.log("Response:", request.responseText);
            //console.log("Response:", response);

            // In your AJAX success:
            /*
            if (response.status === "success") {
                if (e.target.innerHTML.trim() === "Enroll") {
                    e.target.innerHTML = "Withdraw";
                    e.target.classList.remove("enrollable");
                    e.target.classList.add("withdrawn");
                } else {
                    e.target.innerHTML = "Enroll";
                    e.target.classList.remove("withdrawn");
                    e.target.classList.add("enrollable");
                }
            }
            */

        }else if(request.readyState === XMLHttpRequest.DONE && request.status !== 200){
            console.log("Error:", request.status, request.statusText);
        }
    }

    request.send(data);
});

const accept = document.getElementById("acc");
accept.addEventListener("click", function(e){
    const request = new XMLHttpRequest();
    const data =  new FormData();

    data.append("requestId", e.target.value);
    data.append("operation", e.target.innerHTML.trim());

    request.open("POST", "../api/decision.php", true);
    //request.setRequestHeader("Content-Type", "application/json");
    //alert(e.target.value);

    request.onreadystatechange = function(){
        if(request.readyState === XMLHttpRequest.DONE && request.status === 200){
            // Process the reponse
            //const response = JSON.parse(request.responseText);
            console.log("Successful: ", request.responseText);
            //console.log("Response:", request.responseText);
            //console.log("Response:", response);

            // In your AJAX success:
            /*
            if (response.status === "success") {
                if (e.target.innerHTML.trim() === "Enroll") {
                    e.target.innerHTML = "Withdraw";
                    e.target.classList.remove("enrollable");
                    e.target.classList.add("withdrawn");
                } else {
                    e.target.innerHTML = "Enroll";
                    e.target.classList.remove("withdrawn");
                    e.target.classList.add("enrollable");
                }
            }
            */

        }else if(request.readyState === XMLHttpRequest.DONE && request.status !== 200){
            console.log("Error:", request.status, request.statusText);
        }
    }

    request.send(data);
});
