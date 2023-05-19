function showPopup() {
    var popup = document.getElementById('infoPopup');
    var content = document.getElementById('popupContent');
    popup.style.display = 'block';

    setTimeout(function() {
        popup.style.opacity = '0';
        setTimeout(function() {
            popup.style.display = 'none';
            popup.style.opacity = '1';
        }, 500);
    }, 5000);
}
