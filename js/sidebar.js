
document.querySelector("aside").addEventListener("click", (event) => {
  let target = event.target;

  if (target.id != "arrow") {
    return;
  }

  target.parentElement.classList.toggle("collapse");
  target.parentElement.nextElementSibling.classList.toggle("collapse");
  target.classList.toggle("collapse");
  target.nextElementSibling.classList.toggle("collapse");
  target.nextElementSibling.nextElementSibling.classList.toggle("collapse");
  document.querySelector(".user-profile .name").classList.toggle("collapse");
  document.querySelectorAll(".nav li p").forEach(element => {
    element.classList.toggle("collapse");
  })

  if (target.classList.contains("collapse")) {
    target.nextElementSibling.textContent = "SS";
  }
  else {
    target.nextElementSibling.textContent = "SpendSense";
  }
  
})