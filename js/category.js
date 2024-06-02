
const selectIconbtn = document.getElementById("catimg-btn");

selectIconbtn.addEventListener("click", (event) => {
  event.target.previousElementSibling.click();
})


selectIconbtn.previousElementSibling.addEventListener("change", function(event) {
  let selectedIcon = this.files[0];
  
  let reader = new FileReader();
  reader.readAsDataURL(selectedIcon);
  reader.addEventListener("load", function (event) {
    selectIconbtn.previousElementSibling.previousElementSibling.src = this.result;
  })
})