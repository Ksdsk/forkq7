function checkFileExtension() {

    try {
        const imgfile = document.getElementById('pfp');
        const resultField = document.getElementById("pfpCheck");
        const confirmButton = document.getElementById("pfpconfirmation");
        const allowed = ['jpg','jpeg','png'];
        var extension = imgfile.value.split('.').pop().toLowerCase();
        if (!allowed.includes(extension)) {
            resultField.innerHTML = "Error: Make sure the image extension is .jpg, .jpeg, or .png!";
            confirmButton.disabled = true;
        } else {
            resultField.innerHTML = "";
            confirmButton.disabled = false;
        }

    } catch(err) {
      console.log(err);
    }
};