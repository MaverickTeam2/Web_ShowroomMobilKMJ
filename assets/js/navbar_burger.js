// Navbar Burger Script
document.addEventListener('DOMContentLoaded', () => {
  // Navbar burger toggle
  const burger = document.querySelector('.navbar-burger');
  const menu = document.getElementById(burger.dataset.target);

  burger.addEventListener('click', () => {
    burger.classList.toggle('is-active');
    menu.classList.toggle('is-active');
  });

  // More Dropdown
  const more = document.getElementById('moreDropdown');
  more.querySelector('.navbar-link').addEventListener('click', () => {
    more.classList.toggle('is-active');
  });

  // Account Dropdown
  const account = document.getElementById('accountDropdown');
  account.querySelector('.navbar-link').addEventListener('click', () => {
    account.classList.toggle('is-active');
  });
});
