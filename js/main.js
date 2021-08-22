let careersBtn = document.getElementById("careers-btn");
let categoriesBtn = document.getElementById("categories-btn");
let levelsBtn = document.getElementById("levels-btn");

categoriesBtn.addEventListener("click", () => {
  document.getElementById("categories").classList.remove("d-none");
  document.getElementById("levels").classList.add("d-none");
  document.getElementById("careers").style.overflow = "hidden";
  document.getElementById("careers").style.height = "0px";
});
levelsBtn.addEventListener("click", () => {
  document.getElementById("levels").classList.remove("d-none");
  document.getElementById("categories").classList.add("d-none");
  document.getElementById("careers").style.overflow = "hidden";
  document.getElementById("careers").style.height = "0px";
});
careersBtn.addEventListener("click", () => {
  document.getElementById("careers").style.overflow = null;
  document.getElementById("careers").style.height = null;
  document.getElementById("levels").classList.add("d-none");
  document.getElementById("categories").classList.add("d-none");
});