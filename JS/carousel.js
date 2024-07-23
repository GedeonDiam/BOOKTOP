document.addEventListener("DOMContentLoaded", function() {
    var slides = document.querySelectorAll(".slide");
    var currentSlide = 0;
    var slideInterval = setInterval(nextSlide, 2000); // Change l'intervalle ici (en millisecondes)
  
    function nextSlide() {
      slides[currentSlide].style.display = "none";
      currentSlide = (currentSlide + 1) % slides.length;
      slides[currentSlide].style.display = "block";
    }
  });
  