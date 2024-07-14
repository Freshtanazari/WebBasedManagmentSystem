// const navBtns = document.querySelectorAll(".nav-btn");
// const forms = document.querySelectorAll(".sales-form");


// navBtns[0].addEventListener("click",()=>{
//     document.querySelector(".active").classList.remove("active");
//     forms[0].classList.add("active");
// })

// navBtns[1].addEventListener("click",()=>{
//     document.querySelector(".active").classList.remove("active");
//     forms[1].classList.add("active");
// })

// navBtns[2].addEventListener("click",()=>{
//     document.querySelector(".active").classList.remove("active");
//     forms[2].classList.add("active");
// })

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