
document.addEventListener("DOMContentLoaded", () => {
    const dropdownBtn = document.getElementById("dropdown-btn");
    const dropdownMenu = document.getElementById("dropdown-menu");
    const closeMenuBtn = document.getElementById("close-menu");

    // Open menu
    dropdownBtn.addEventListener("click", () => {
      dropdownMenu.classList.add("open");
    });

    // Close menu
    closeMenuBtn.addEventListener("click", () => {
      dropdownMenu.classList.remove("open");
    });
  });