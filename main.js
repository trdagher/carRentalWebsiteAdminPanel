let dashboardContainer = document.querySelectorAll(".dashboard-container");
let closeDashboardBtn = document.querySelectorAll(".closeDashboardBtn");
let navMenu = document.querySelectorAll(".nav-menu");
navMenu.forEach((menuItem) => {
  menuItem.addEventListener("click", () => {
    const menuItemId = menuItem.id; // Get the id of the clicked nav-menu
    // Loop through dashboard containers to find the one with matching id
    dashboardContainer.forEach((container) => {
      if (container.id === menuItemId) {
        container.classList.add("show"); // Add the 'show' class to the matching container
      } else {
        container.classList.remove("show"); // Remove 'show' class from other containers
      }
    });
  });
});
closeDashboardBtn.forEach((CloseButton) => {
  CloseButton.addEventListener("click", () => {
    const closeBtnId = CloseButton.id;
    dashboardContainer.forEach((container) => {
      if (container.id == closeBtnId) {
        container.classList.remove("show");
      }
    });
  });
});
