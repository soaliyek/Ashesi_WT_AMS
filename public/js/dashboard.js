function divswitch(identifier){
    const mycourses = document.getElementById("mycourses");
    const courses = document.getElementById("courses");
    const enrollments = document.getElementById("enrollments");

    const allmycourses = document.getElementById("allmycourses");
    const allcourses = document.getElementById("allcourses");
    const allenrollments = document.getElementById("allmyenrollments");
    
    /*
    if(identifier === "mycourses"){
        mycourses.style.backgroundColor = "white";
        mycourses.style.color = "black";
    }else if(identifier === "courses"){
        courses.style.backgroundColor = "white";
        courses.style.color = "black";
    } else if(identifier === "enrollments"){
        enrollments.style.backgroundColor = "white";
        enrollments.style.color = "black";
    }
        */
}

const enrollButtons = document.querySelectorAll(".enrollButton");
enrollButtons.forEach(button =>{
    button.addEventListener("click", function(e){
        //console.log("CourseID:", e.target.value, "Operation:", e.target.innerHTML);

        const request = new XMLHttpRequest();
        const data =  new FormData();

        data.append("courseId", e.target.value);
        data.append("operation", e.target.innerHTML.trim());

        request.open("POST", "../api/courseop.php", true);
        //request.setRequestHeader("Content-Type", "application/json");

        request.onreadystatechange = function(){
            if(request.readyState === XMLHttpRequest.DONE && request.status === 200){
                // Process the reponse
                const response = JSON.parse(request.responseText);
                console.log("Successful: ", request.responseText);
                //console.log("Response:", request.responseText);
                //console.log("Response:", response);

                if(response.status === "success"){
                    if(e.target.innerHTML.trim() === "Enroll"){
                        e.target.innerHTML = "Withdraw";
                        e.target.style = "background-color: red;"
                    }else{
                        e.target.innerHTML = "Enroll";
                        e.target.style = "background-color: green;"
                    }
                }

            }else if(request.readyState === XMLHttpRequest.DONE && request.status !== 200){
                console.log("Error:", request.status, request.statusText);
            }
        }

        request.send(data);
    });
});