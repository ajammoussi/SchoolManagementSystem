document.addEventListener("DOMContentLoaded", function() {

    const filterSelect = document.getElementById("filter");
    const fieldSelect = document.getElementById("fieldSelect");
    const studyLevelSelect = document.getElementById("studyLevelSelect");

    const submitButton = document.getElementById("submit");
    const cancelButton = document.getElementById("remove");

    if (filter === 'field' || filter === 'studylevel') {
        cancelButton.removeAttribute("hidden");
    } else {
        cancelButton.setAttribute("hidden", "");
    }

    filterSelect.addEventListener("change", function() {
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
        }
    });


    const submitForm = (event) => {
        event.preventDefault();
    }
    submitButton.addEventListener("click", submitForm);

});

