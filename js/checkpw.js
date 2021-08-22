function checkpw() {
    try {
        const newPassField = document.getElementById("newPassword");
        const confirmPassField = document.getElementById("confirmPassword");
        const resultField = document.getElementById("pwMatches");
        const confirmButton = document.getElementById("pwconfirmation");
        if (newPassField.value != confirmPassField.value) {
            resultField.innerHTML = "Password does not match.";
            confirmButton.disabled = true;
        } else {
            resultField.innerHTML = "Password matches";
            confirmButton.disabled = false;
        }
    } catch(err) {
      console.log(err);
    }
  }
