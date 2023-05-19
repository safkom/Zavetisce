function showPopup() {
    var popup = document.getElementById('infoPopup');
    popup.style.display = 'block';
    setTimeout(function() {
        popup.style.display = 'none';
    }, 5000);
}
