try {
    function updateCountdown() {
        const now = new Date();
        const nextMonth = new Date(now.getFullYear(), now.getMonth() + 1, 1);
        nextMonth.setHours(0, 0, 0, 0);
    
        const timeRemaining = nextMonth - now;
    
        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
        document.getElementById('mount_countdown').innerHTML = `${days}j ${hours}h ${minutes}m ${seconds}s`;
    }
    
    setInterval(updateCountdown, 1000);
    updateCountdown();
} catch (e) {}