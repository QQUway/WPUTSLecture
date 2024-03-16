document.getElementById('photo-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting
    
    var fileInput = document.getElementById('profile-photo');
    var file = fileInput.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
