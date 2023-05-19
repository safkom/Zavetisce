window.addEventListener('load', function() {
    showPopup();
    setTimeout(function() {
        closePopup();
        setTimeout(function() {
            document.getElementById('infoPopup').remove();
        }, 500);
    }, 5000);
});

function showPopup() {
    var popup = document.getElementById('infoPopup');
    popup.style.display = 'block';
}

function closePopup() {
    var popup = document.getElementById('infoPopup');
    popup.style.animation = 'fade-out 0.5s ease-in-out forwards';
}
