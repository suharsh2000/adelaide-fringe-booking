// Set the date for Adelaide Fringe Festival 2025
// Based on the website content, assuming the festival starts on February 15, 2025
const festivalDate = new Date("February 15, 2025 00:00:00").getTime();

// Update the countdown every second
const countdownTimer = setInterval(function() {
    // Get current date and time
    const now = new Date().getTime();
    
    // Find the time remaining between now and the festival date
    const timeRemaining = festivalDate - now;
    
    // Calculate days, hours, minutes, and seconds
    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
    
    // Display the results with leading zeros
    document.getElementById("days").innerHTML = days.toString().padStart(2, "0");
    document.getElementById("hours").innerHTML = hours.toString().padStart(2, "0");
    document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, "0");
    document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, "0");
    
    // If the countdown is over, display a message
    if (timeRemaining < 0) {
        clearInterval(countdownTimer);
        document.getElementById("countdown").innerHTML = "<h3>The Festival Has Started!</h3>";
    }
}, 1000);

// Add mobile menu toggle functionality
document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });
    }
});