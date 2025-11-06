// facility section
let facility_s_form = document.getElementById("facility_s_form");

facility_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_facility();
});

function add_facility() {
  let data = new FormData(); // creating object of FormData named interface
  data.append("name", facility_s_form.elements["facility_name"].value); // frm_data
  data.append("icon", facility_s_form.elements["facility_icon"].files[0]); // frm_data
  data.append("desc", facility_s_form.elements["facility_desc"].value); // frm_data

  data.append("add_facility", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/facilities_crud.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("facility-s"); // facility model id hit
    var modal = bootstrap.Modal.getInstance(myModal);

    modal.hide();

    if (this.responseText == "inv_img") {
      alert("error", "Only svg, jpg, png images are allowed!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Image should be less than 1MB!");
    } else if (this.responseText == "upload_failed") {
      alert("error", "Image upload failed. Server down!");
    } else {
      alert("success", "New facility added!");
      facility_s_form.reset();
      get_facilities();
    }
  };

  xhr.send(data);
}

function get_facilities() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/facilities_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("facilities-data").innerHTML = this.responseText;
  };

  xhr.send("get_facilities");
}

function remove_facility(val) {
  if (!confirm("Are you sure you want to delete this product?")) {
    return; // Exit if user clicks "Cancel"
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/facilities_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Facility removed!");
      get_facilities();
    } else {
      alert("error", "Server down!");
    }
  };

  xhr.send("remove_facility=" + encodeURIComponent(val));
}

window.onload = function () {
  get_facilities();
};
