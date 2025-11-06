const display_msg = (element, msg, color = "red") => {
  element.innerHTML = msg;
  element.style.color = color;
};

let name_input = document.getElementById("name");
let name_msg = document.getElementById("name_msg");

const name_validate = () => {
  let name = name_input.value.trim();

  // Check for only letters and single spaces between words
  if (!name.match(/^[a-zA-Z]+(?: [a-zA-Z]+)+$/)) {
    display_msg(name_msg, "Invalid name format!");
    return false;
  } else if (!name.match(/^.{5,}$/)) {
    // Minimum total length: 5 characters (e.g., "Jo Do")
    display_msg(name_msg, "Full Name must be at least 5 characters long");
    return false;
  } else {
    display_msg(name_msg, "", "green");
    return true;
  }
};

name_input.addEventListener("keyup", name_validate);

let phone_input = document.getElementById("phone");
let phone_msg = document.getElementById("phone_msg");

const phone_validate = () => {
  let phone = phone_input.value;
  if (!phone.match(/^[0-9]+$/)) {
    display_msg(phone_msg, "Phone number must be a number");
    return false;
  } else if (!phone.match(/^9(6|7|8)/)) {
    display_msg(phone_msg, "Phone number must start with 98 or 97 or 96");
    return false;
  } else if (phone.length !== 10) {
    display_msg(phone_msg, "Phone number must be 10 digits");
    return false;
  } else {
    display_msg(phone_msg, "", "green");
    return true;
  }
};
phone_input.addEventListener("keyup", phone_validate);

let email_input = document.getElementById("email");
let email_msg = document.getElementById("email_msg");

const email_validate = () => {
  let email = email_input.value;
  if (!email.match(/^[a-z][a-z0-9_.]+@[a-z]+\.(com)$/)) {
    display_msg(email_msg, "Invalid email");
    return false;
  } else {
    display_msg(email_msg, "", "green");
    return true;
  }
};
email_input.addEventListener("keyup", email_validate);

// Get the date input field
const dateInput = document.getElementById("date");
if (dateInput) {
  // Check if date input exists
  const today = new Date();
  const tenYearsAgo = new Date(
    today.getFullYear() - 10,
    today.getMonth(),
    today.getDate()
  );
  const formattedDate = tenYearsAgo.toISOString().split("T")[0];
  dateInput.setAttribute("max", formattedDate);
}

let password_input = document.getElementById("password");
let password_msg = document.getElementById("password_msg");

const password_validate = () => {
  let password = password_input.value;
  if (!/[a-z]/.test(password)) {
    display_msg(password_msg, "Must contain at least 1 lowercase alphabet");
    return false;
  } else if (!/[A-Z]/.test(password)) {
    display_msg(password_msg, "Must contain at least 1 uppercase alphabet");
    return false;
  } else if (!/[0-9]/.test(password)) {
    display_msg(password_msg, "Must contain at least 1 number");
    return false;
  } else if (!/[-!@#$%]/.test(password)) {
    display_msg(password_msg, "Must contain at least 1 special character");
    return false;
  } else if (password.length < 8) {
    display_msg(password_msg, "Must be at least 8 characters");
    return false;
  } else if (password.length > 15) {
    display_msg(password_msg, "Must not exceed 15 characters");
    return false;
  } else {
    display_msg(password_msg, "", "green");
    return true;
  }
};
password_input.addEventListener("keyup", password_validate);

let cpassword_input = document.getElementById("cpassword");
let cpassword_msg = document.getElementById("cpassword_msg");

const cpassword_validate = () => {
  let cpassword = cpassword_input.value;
  let password = password_input.value;
  if (password !== cpassword) {
    display_msg(cpassword_msg, "Password does not match");
    return false;
  } else {
    display_msg(cpassword_msg, "", "green");
    return true;
  }
};
cpassword_input.addEventListener("keyup", cpassword_validate);

const form_validate = () => {
  if (
    name_validate() &&
    phone_validate() &&
    email_validate() &&
    password_validate() &&
    cpassword_validate()
  ) {
    return true;
  } else {
    return false;
  }
};
