document.getElementById("surveyForm").addEventListener("submit", function (e) {
  //e.preventDefault();

  let valid = true;

  // Clear errors
  document.querySelectorAll(".error").forEach(el => el.textContent = "");

  // Name
  const name = document.getElementById("full_name").value.trim();
  if (name === "") {
    document.getElementById("nameError").textContent = "Please enter your name.";
    valid = false;
  }

  // Email
  const email = document.getElementById("email").value.trim();
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email || !emailPattern.test(email)) {
    document.getElementById("emailError").textContent = "Enter a valid email address.";
    valid = false;
  }

  // Contact (SA phone number)
  const contact = document.getElementById("contact_number").value.trim();
  const saPhonePattern = /^0[6-8][0-9]{8}$/;
  if (!saPhonePattern.test(contact)) {
    document.getElementById("contactError").textContent = "Enter a valid SA number like 0831234567.";
    valid = false;
  }

  // Date of Birth
  const dob = document.getElementById("dob").value;
  if (!dob) {
    document.getElementById("dobError").textContent = "Select your date of birth.";
    valid = false;
  } else {
    const age = new Date().getFullYear() - new Date(dob).getFullYear();
    if (age < 5 || age > 120) {
      document.getElementById("dobError").textContent = "Age must be between 5 and 120.";
      valid = false;
    }
  }

  // Favorite Food
  const selectedFoods = document.querySelectorAll("input[name='food[]']:checked");
  if (selectedFoods.length === 0) {
    document.getElementById("foodError").textContent = "Select at least one favorite food.";
    valid = false;
  }

  // Ratings
  const ratingGroups = ["watch_movies", "listen_radio", "eat_out", "watch_tv"];
  for (const group of ratingGroups) {
    if (!document.querySelector(`input[name="${group}"]:checked`)) {
      document.getElementById("ratingError").textContent = "Rate all the lifestyle statements.";
      valid = false;
      break;
    }
  }

  /*if (valid) {
    alert("Survey submitted successfully!");
    document.getElementById("surveyForm").reset();
  }*/
 if (!valid) {
    e.preventDefault(); // block form submission
  }





});
