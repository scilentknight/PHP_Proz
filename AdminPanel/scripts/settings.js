let contacts_data;
let general_data;

let general_s_form = document.getElementById("general_s_form");
let site_title_input = document.getElementById("site_title_input");
let site_about_input = document.getElementById("site_about_input");
let contacts_s_form = document.getElementById("contacts_s_form");

let team_s_form = document.getElementById("team_s_form");
let member_name_input = document.getElementById("member_name_input");
let member_picture_input = document.getElementById("member_picture_input");

function get_general() {
  let site_title = document.getElementById("site_title");
  let site_about = document.getElementById("site_about");

  let shutdown_toggle = document.getElementById("shutdown-toggle");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);

  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    general_data = JSON.parse(this.responseText);

    site_title.innerText = general_data.site_title;
    site_about.innerText = general_data.site_about;

    site_title_input.value = general_data.site_title;
    site_about_input.value = general_data.site_about;

    if (general_data.shutdown == 0) {
      shutdown_toggle.checked = false;
      shutdown_toggle.value = 0;
    } else {
      shutdown_toggle.checked = true;
      shutdown_toggle.value = 1;
    }
  };

  xhr.send("get_general");
}

general_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  update_general(site_title_input.value, site_about_input.value);
});

function update_general(site_title_val, site_about_val) {
  let xhr = new XMLHttpRequest();

  xhr.open("POST", "ajax/settings_crud.php", true);

  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    var myModal = document.getElementById("general-s");
    var modal = bootstrap.Modal.getInstance(myModal);

    modal.hide();
    if (this.responseText == 1) {
      alert("success", "Changes saved!");
      get_general();
    } else {
      alert("error", "No changes made!");
    }
  };
  xhr.send(
    "site_title=" +
      encodeURIComponent(site_title_val) +
      "&site_about=" +
      encodeURIComponent(site_about_val) +
      "&update_general=1"
  );
}

function update_shutdown(val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1 && general_data.shutdown == 0) {
      alert("success", "Site has been shutdown!");
      get_general();
    } else {
      alert("success", "Shutdown mode off!");
    }
    get_general();
  };
  xhr.send("update_shutdown=" + val);
}

// imp
function get_contacts() {
  let contacts_p_id = [
    "address",
    "gmap",
    "pn1",
    "pn2",
    "email",
    "fb",
    "insta",
    "tw",
  ];
  let iframe = document.getElementById("iframe");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);

  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    contacts_data = JSON.parse(this.responseText);
    contacts_data = Object.values(contacts_data);

    for (i = 0; i < contacts_p_id.length; i++) {
      document.getElementById(contacts_p_id[i]).innerText =
        contacts_data[i + 1];
    }
    iframe.src = contacts_data[9];
    contacts_input(contacts_data);
  };

  xhr.send("get_contacts");
}

function contacts_input(data) {
  let contacts_input_id = [
    "address_input",
    "gmap_input",
    "pn1_input",
    "pn2_input",
    "email_input",
    "fb_input",
    "insta_input",
    "tw_input",
    "iframe_input",
  ];

  for (i = 0; i < contacts_input_id.length; i++) {
    document.getElementById(contacts_input_id[i]).value = data[i + 1];
  }
}

contacts_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  update_contacts();
});

function update_contacts() {
  let index = [
    "address",
    "gmap",
    "pn1",
    "pn2",
    "email",
    "fb",
    "insta",
    "tw",
    "iframe",
  ];
  let contacts_input_id = [
    "address_input",
    "gmap_input",
    "pn1_input",
    "pn2_input",
    "email_input",
    "fb_input",
    "insta_input",
    "tw_input",
    "iframe_input",
  ];
  let data_str = "";

  for (let i = 0; i < index.length; i++) {
    data_str +=
      index[i] +
      "=" +
      encodeURIComponent(document.getElementById(contacts_input_id[i]).value) +
      "&";
  }

  data_str += "update_contacts";

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    var myModal = document.getElementById("contacts-s");
    var modal = bootstrap.Modal.getInstance(myModal);

    modal.hide();
    if (this.responseText == 1) {
      alert("success", "Changes saved!");
      get_contacts();
    } else {
      alert("success", "No changes made!");
    }
  };

  xhr.send(data_str);
}
// imp ends

// team support
team_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_members();
});

function add_members() {
  let data = new FormData(); //creating object of FormData named interface
  data.append("name", member_name_input.value);
  data.append("picture", member_picture_input.files[0]);
  data.append("add_members", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("team-s");
    var modal = bootstrap.Modal.getInstance(myModal);

    modal.hide();
    if (this.responseText == "inv_img") {
      alert("error", "Only jpg, jpeg, png, webp, svg images are allowed!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Image should be less than 2MB!");
    } else if (this.responseText == "upload_failed") {
      alert("error", "Image upload failed. Server down!");
    } else {
      alert("success", "New member added!");
      member_name_input.value = "";
      member_picture_input.value = "";
      get_members();
    }
  };

  xhr.send(data);
}

function get_members() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("team-data").innerHTML = this.responseText;
  };

  xhr.send("get_members");
}

function remove_member(val) {
  if (!confirm("Are you sure you want to delete this member?")) {
    return; // Exit if user clicks "Cancel"
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Member removed!");
      get_members();
    } else {
      alert("error", "Server down!");
    }
  };

  xhr.send("remove_member=" + encodeURIComponent(val));
}

window.onload = function () {
  get_general();
  get_contacts();
  get_members();
};
