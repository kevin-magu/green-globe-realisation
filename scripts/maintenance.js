document.addEventListener('DOMContentLoaded', function() {
    // Set the date we're counting down to (2 days from now)
    const countDownDate = new Date();
    countDownDate.setDate(countDownDate.getDate() + 2);
    
    // Update the countdown every 1 second
    const timer = setInterval(function() {
        // Get today's date and time
        const now = new Date().getTime();
        
        // Find the distance between now and the countdown date
        const distance = countDownDate - now;
        
        // Time calculations for days, hours and minutes
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        
        // Display the result
        document.querySelector('.days').textContent = days.toString().padStart(2, '0');
        document.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
        document.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
        
        // If the countdown is finished
        if (distance < 0) {
            clearInterval(timer);
            document.querySelector('.timer').textContent = "Very soon!";
        }
    }, 1000);
    
    // Animate progress bar
    let progress = 0;
    const progressBar = document.querySelector('.progress');
    const progressText = document.querySelector('.progress-text');
    const targetProgress = 65;
    
    const progressInterval = setInterval(function() {
        if (progress >= targetProgress) {
            clearInterval(progressInterval);
        } else {
            progress++;
            progressBar.style.width = progress + '%';
            progressText.textContent = progress + '% Complete';
        }
    }, 30);
});