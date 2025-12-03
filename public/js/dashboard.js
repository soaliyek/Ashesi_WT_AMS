function divswitch(identifier){
    const mycourses = document.getElementById("mycourses");
    const courses = document.getElementById("courses");
    const enrollments = document.getElementById("enrollments");

    const allmycourses = document.getElementById("allmycourses");
    const allcourses = document.getElementById("allcourses");
    const allenrollments = document.getElementById("allmyenrollments");
    
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
}