document.getElementById('navId').addEventListener('click', function () {
  var menu = document.getElementById('layout-menu');
  var layoutPage = document.querySelector('.layout-page');
  
  // Toggle the 'd-none' class to hide or show the menu
  menu.classList.toggle('d-none');
  
  // If the menu is open, apply the class for the animation and adjust the layout-page
  if (menu.classList.contains('d-none')) {
    // Menu is hidden, layout-page will span full width
    layoutPage.classList.remove('layout-menu-visible');

    let tableLayout = document.querySelector('div.layout-wrapper.layout-content-navbar');
    let containerLayout = document.querySelector('div.layout-container.card-body');

    if (tableLayout) {
      tableLayout.className = 'layout-wrapper layout-content-navbar layout-without-menu';
    }

    if (containerLayout) {
      containerLayout.className = 'layout-container';
    }
  } else {
    // Rollback class before removing
    let tableLayout = document.querySelector('div.layout-wrapper.layout-content-navbar.layout-without-menu');
    let containerLayout = document.querySelector('div.layout-container');

    if (tableLayout) {
      tableLayout.className = 'layout-wrapper layout-content-navbar';
    }

    if (containerLayout) {
      containerLayout.className = 'layout-container card-body';
    }
    // Menu is visible, layout-page will shift by 250px to the right
    layoutPage.classList.add('layout-menu-visible');
  }  
});