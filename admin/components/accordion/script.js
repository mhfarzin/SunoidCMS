document.addEventListener("click", function (e) {
  if (!e.target.matches(".admin-accordion-button")) return;
  e.preventDefault();

  const button = e.target;
  const body = button.nextElementSibling;
  const isOpen = button.getAttribute("aria-expanded") === "true";

  button.setAttribute("aria-expanded", !isOpen);
  body.classList.toggle("show");
});
