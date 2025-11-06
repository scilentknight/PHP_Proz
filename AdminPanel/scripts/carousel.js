// carousel section
let carousel_s_form = document.getElementById("carousel_s_form");
let carousel_picture_input = document.getElementById("carousel_picture_input");

carousel_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_image();
});

function add_image() {
  let data = new FormData(); //creating object of FormData named interface
  data.append("picture", carousel_picture_input.files[0]);
  data.append("add_image", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("carousel-s");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == "inv_img") {
      alert("error", "Only jpg, jpeg, png, webp, svg images are allowed!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Image should be less than 2MB!");
    } else if (this.responseText == "upload_failed") {
      alert("error", "Image upload failed. Server down!");
    } else {
      alert("success", "New carousel added!");
      carousel_picture_input.value = "";
      get_carousel();
    }
  };

  xhr.send(data);
}

function get_carousel() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("carousel-data").innerHTML = this.responseText;
  };

  xhr.send("get_carousel");
}

function remove_image(val) {
  if (!confirm("Are you sure you want to delete this carousel?")) {
    return; // Exit if user clicks "Cancel"
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "carousel removed!");
      get_carousel();
    } else {
      alert("error", "Server down!");
    }
  };

  xhr.send("remove_image=" + encodeURIComponent(val));
}

// store section
let store_s_form = document.getElementById("store_s_form");
let store_name_input = document.getElementById("store_name_input");
let store_image_input = document.getElementById("store_image_input");

store_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_store();
});

function add_store() {
  let data = new FormData(); //creating object of FormData named interface
  data.append("store_name", store_name_input.value);
  data.append("store_image", store_image_input.files[0]);
  data.append("add_store", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("store-s");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == "inv_img") {
      alert("error", "Only jpg, jpeg, png, webp, svg images are allowed!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Image should be less than 2MB!");
    } else if (this.responseText == "upload_failed") {
      alert("error", "Image upload failed. Server down!");
    } else {
      alert("success", "New store image added!");
      store_name_input.value = "";
      store_image_input.value = "";
      get_store();
    }
  };

  xhr.send(data);
}

function get_store() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("store-data").innerHTML = this.responseText;
  };

  xhr.send("get_store");
}

function remove_store(val) {
  if (!confirm("Are you sure you want to delete this store image?")) {
    return; // Exit if user clicks "Cancel"
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Store removed!");
      get_store();
    } else {
      alert("error", "Server down!");
    }
  };

  xhr.send("remove_store=" + encodeURIComponent(val));
}

// choose us section
let chooseus_s_form = document.getElementById("chooseus_s_form");
let chooseus_name_input = document.getElementById("chooseus_name_input");
let chooseus_image_input = document.getElementById("chooseus_image_input");

chooseus_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_chooseus();
});

function add_chooseus() {
  let data = new FormData(); //creating object of FormData named interface
  data.append("chooseus_name", chooseus_name_input.value);
  data.append("chooseus_image", chooseus_image_input.files[0]);
  data.append("add_chooseus", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("chooseus-s");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == "inv_img") {
      alert("error", "Only jpg, jpeg, png, webp, svg images are allowed!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Image should be less than 2MB!");
    } else if (this.responseText == "upload_failed") {
      alert("error", "Image upload failed. Server down!");
    } else {
      alert("success", "New choose us image added!");
      chooseus_name_input.value = "";
      chooseus_image_input.value = "";
      get_chooseus();
    }
  };

  xhr.send(data);
}

function get_chooseus() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("chooseus-data").innerHTML = this.responseText;
  };

  xhr.send("get_chooseus");
}

function remove_chooseus(val) {
  if (!confirm("Are you sure you want to delete this chooseus image?")) {
    return; // Exit if user clicks "Cancel"
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Choose us removed!");
      get_chooseus();
    } else {
      alert("error", "Server down!");
    }
  };

  xhr.send("remove_chooseus=" + encodeURIComponent(val));
}

window.onload = function () {
  get_carousel();
  get_store();
  get_chooseus();
};
