
// this ensure that the page is fully loaded before the script is executed
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('studentsPerYearCanvas').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: studentStatistics.map(row => row.studylevel),
            datasets: [{
                label: 'number of students per study level',
                data: studentStatistics.map(row => row.nbStudents)
            }]
        }
    });
    

    //this part is for the abscence chart
    //we need to add the missing days with 0 abscences
    const currentdate= new Date();
    let date= new Date(currentdate);
    date.setDate(date.getDate()-20);
    
    let j=0;  
    for(let i=0; i<20; i++){
        if(abscenceStatistics[j].absencedate!=formatDate(date)){
            abscenceStatistics.splice(j,0,{absencedate: formatDate(date), nbAbscences: 0});
            
        }
        else{
            j++;
        }
        date.setDate(date.getDate()+1);
    }
    // now we sort the array by date
    abscenceStatistics.sort((a, b) => new Date(a.absencedate) - new Date(b.absencedate));
    // now we can draw the chart
    const ABSCENCE_CHART = document.getElementById('abscenceCanvas').getContext('2d');
    new Chart(ABSCENCE_CHART, {
        type: 'bar',
        data: {
            labels: abscenceStatistics.map(row => row.absencedate),
            datasets: [{
                label: 'number of abscences per day',
                data: abscenceStatistics.map(row => row.nbAbscences)
            }]
        }
    });

    
    // this part is for the GENDER destribution chart
    console.log(genderStatistics);
    const GENDER_CHART = document.getElementById('genderCanvas').getContext('2d');
    new Chart(GENDER_CHART, {
        type: 'pie',
        data: {
            labels: genderStatistics.map(row => row.gender),
            datasets: [{
                label: 'Number of students',
                data: genderStatistics.map(row => row.nbStudents)
            }]
        },

        // I set these options so that the chart does not maintain it's default proportions !!!!!!!!!!!
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});



// function to format the date in the format yyyy-mm-dd
function formatDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
} 

