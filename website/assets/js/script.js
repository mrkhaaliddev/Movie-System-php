// script.js

// This function sets up arrow-based horizontal scrolling for every .scrolling-wrapper
function initHorizontalScroll() {
  // 1) Find all .scrolling-wrapper elements on the page
  const wrappers = document.querySelectorAll(".scrolling-wrapper");

  wrappers.forEach((wrapper) => {
    // 2) Inside each wrapper, find the scrolling content & arrow buttons
    const content = wrapper.querySelector(".scrolling-content");
    const leftArrow = wrapper.querySelector(".arrow-left");
    const rightArrow = wrapper.querySelector(".arrow-right");

    if (!content || !leftArrow || !rightArrow) return;

    // On click, move scrollLeft
    leftArrow.addEventListener("click", () => {
      content.scrollLeft -= 300;
    });
    rightArrow.addEventListener("click", () => {
      content.scrollLeft += 300;
    });

    // Optional: hide/show arrows based on scroll position
    content.addEventListener("scroll", () => {
      const maxScrollLeft = content.scrollWidth - content.clientWidth;
      // If at the left edge, hide left arrow
      if (content.scrollLeft <= 0) {
        leftArrow.style.display = "none";
      } else {
        leftArrow.style.display = "block";
      }
      // If at the right edge, hide right arrow
      if (content.scrollLeft >= maxScrollLeft) {
        rightArrow.style.display = "none";
      } else {
        rightArrow.style.display = "block";
      }
    });

    // Initialize arrow visibility
    // If content is short, we may hide right arrow immediately
    const checkArrows = () => {
      const maxScrollLeft = content.scrollWidth - content.clientWidth;
      leftArrow.style.display = content.scrollLeft <= 0 ? "none" : "block";
      rightArrow.style.display =
        content.scrollLeft >= maxScrollLeft ? "none" : "block";
    };
    checkArrows();
    window.addEventListener("resize", checkArrows);
  });
}

// Initialize once the DOM is ready
document.addEventListener("DOMContentLoaded", initHorizontalScroll);
