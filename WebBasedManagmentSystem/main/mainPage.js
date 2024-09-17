

// the suggested code:
const navBtns = document.querySelectorAll(".nav-btn");
const forms = document.querySelectorAll(".sales-form");

if (navBtns.length !== forms.length) {
    console.error("The number of navigation buttons and forms do not match.");
} else {
    navBtns.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            const activeElement = document.querySelector(".active");
            if (activeElement) {
                activeElement.classList.remove("active");
            }
            forms[index].classList.add("active");
        });
    });
}



function getCurrentDate(){
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth()+1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`; // it returns the current date
} 

function setPurchaseDate(){
    const purchaseDate = document.getElementById("p-date");
    if (purchaseDate) {
        purchaseDate.value = getCurrentDate(); // Set the input value to the current date
    }
}

document.addEventListener('DOMContentLoaded', setPurchaseDate)

// google bar chart:
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawStuff);


let data, dataTable;

function drawStuff() {
  // Fetch the data from the PHP script
  fetch('fetchingData.php')
  .then(response => response.json())
  .then(fetchedData => {
      // console.log(fetchedData); // Check if the data is properly fetched
      // console.log("maybe it is not even reading the data");
      if (Array.isArray(fetchedData) && Array.isArray(fetchedData[0])) {
                console.log('yes, it is array');
                // Convert the fetched data into a DataTable
                dataTable = google.visualization.arrayToDataTable(fetchedData);

                // Define the chart options
                var options = {
                    margin_left: 0,
                    width: 600,
                    legend: { position: 'none' },
                    bars: 'vertical', // Required for Material Bar Charts.
                    axes: {
                        x: {
                            0: { side: 'top', label: 'Based on Months' } // Top x-axis.
                        }
                    },
                    bar: { groupWidth: "50%" }
                };
              }else {
                console.error('Fetched data is not a valid array:', fetchedData);
            }
                // Draw the chart with the fetched data
                var chart = new google.charts.Bar(document.getElementById('chart_div'));
                chart.draw(dataTable, options);
            })
            .catch(error => console.error('Error fetching data:', error));
  
};