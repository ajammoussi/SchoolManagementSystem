document.addEventListener("DOMContentLoaded", () => {

    const filterSelect = document.getElementById("filter");
    const fieldSelect = document.getElementById("fieldSelect");
    const studyLevelSelect = document.getElementById("studyLevelSelect");
    const tableBody = document.getElementById("body");
    const cancelButton = document.getElementById("cancel");
    const showMoreButton = document.getElementById("showMore");
    const modal = document.getElementById("Modal");
    const studentInfo = document.getElementById("studentInfo");
    const span = document.getElementsByClassName("close")[0];
    const pageTitle = document.getElementById("pageTitle");

    if (filter === 'field' || filter === 'studylevel') {
        cancelButton.removeAttribute("hidden");
    } else {
        cancelButton.setAttribute("hidden", "");
    }


    const showMoreInfoStudent = (student) => {
        // Display the student's information in the modal

        studentInfo.innerHTML = `
            <table class="table">
                <tbody>
                <tr><th>ID</th><td>${student.id}</td></tr>
                <tr><th>First Name</th><td>${student.firstname}</td></tr>
                <tr><th>Last Name</th><td>${student.lastname}</td></tr>
                <tr><th>Email</th><td>${student.email}</td></tr>
                <tr><th>Password</th><td>${student.password}</td></tr>
                <tr><th>Phone</th><td>${student.phone}</td></tr>
                <tr><th>Address</th><td>${student.address}</td></tr>
                <tr><th>Birthdate</th><td>${student.birthdate}</td></tr>
                <tr><th>Nationality</th><td>${student.nationality}</td></tr>
                <tr><th>Gender</th><td>${student.gender}</td></tr>
                <tr><th>Field</th><td>${student.field}</td></tr>
                <tr><th>Study Level</th><td>${student.studylevel}</td></tr>
                <tr><th>Class</th><td>${student.class}</td></tr>
                </tbody>
            </table>
        `;

    };

    const showStudents = (arr = students) => {
        tableBody.innerHTML += arr
            .map(
                (student) =>
                    `
            <tr>
                <td>${student.id}</td>
                <td>${student.firstname}</td>
                <td>${student.lastname}</td>
                <td>${student.field}</td>
                <td>${student.studylevel}</td>
                <td><button class="btn btn-primary showMore" id="showMore${student.id}" data-bs-toggle="modal" data-bs-target="#Modal">Show More</button></td>
            </tr>
        `
            )
            .join("");

            // Add event listeners to the "Show More" buttons
            arr.forEach((student) => {
                document.getElementById(`showMore${student.id}`).addEventListener("click", () => {
                    showMoreInfoStudent(student);
                });
            });
    };
    if (pageTitle.innerHTML === "Students") {
        showStudents();
    }
    else if (pageTitle.innerHTML === "Teachers") {
        showTeachers();
    }




    filterSelect.addEventListener("change", (choice) => {
        const selectedValue = filterSelect.value;

        // Hide all select menus
        fieldSelect.classList.add("hidden");
        studyLevelSelect.classList.add("hidden");

        // Show select menu based on user's selection
        if (selectedValue === "field") {
            fieldSelect.removeAttribute("hidden");
            studyLevelSelect.setAttribute("hidden", "");
        } else if (selectedValue === "studyLevel") {
            studyLevelSelect.removeAttribute("hidden");
            fieldSelect.setAttribute("hidden", "");
        } else {
            fieldSelect.setAttribute("hidden", "");
            studyLevelSelect.setAttribute("hidden", "");
        }

        //Showing the students
        tableBody.innerHTML = "";
        switch (choice.target.value) {
            case "field":
                fieldSelect.addEventListener("change", (choice) => {
                    tableBody.innerHTML = "";
                    showStudents(students.filter((student) => student.field === choice.target.value));
                    cancelButton.removeAttribute("hidden");
                });
                break;
            case "studyLevel":
                studyLevelSelect.addEventListener("change", (choice) => {
                    tableBody.innerHTML = "";
                    showStudents(students.filter((student) => student.studylevel === parseInt(choice.target.value)));
                    cancelButton.removeAttribute("hidden");
                });
                break;
            default:
                showStudents();
                cancelButton.setAttribute("hidden", "");
        }

    });

    cancelButton.addEventListener("click", () => {
        tableBody.innerHTML = "";
        showStudents();
        cancelButton.setAttribute("hidden", "");
    });



});

