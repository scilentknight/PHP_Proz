let add_product_form = document.getElementById("add_product_form");

add_product_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_product();
});

function add_product() {
  let data = new FormData(); // creating object of FormData named interface
  data.append("item", add_product_form.elements["items"].value); // frm_data
  data.append("modal", add_product_form.elements["modal"].value); // frm_data
  data.append("variant", add_product_form.elements["variant"].value); // frm_data
  data.append("color", add_product_form.elements["color"].value); // frm_data
  data.append("price", add_product_form.elements["price"].value); // frm_data
  data.append("specs", add_product_form.elements["specs"].value); // frm_data
  data.append("image", add_product_form.elements["image"].files[0]); // frm_data
  data.append("status", add_product_form.elements["status"].value); // frm_data

  data.append("add_product", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/products_crud.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("add-product-s"); // product model id hit
    var modal = bootstrap.Modal.getInstance(myModal);

    modal.hide();

    if (this.responseText == "inv_img") {
      alert("error", "Only jpg, jpeg, png, webp images are allowed!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Image should be less than 2MB!");
    } else if (this.responseText == "upload_failed") {
      alert("error", "Image upload failed. Server down!");
    } else {
      alert("success", "New product added!");
      add_product_form.reset();
      get_products();
    }
  };

  xhr.send(data);
}

function get_products() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/products_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("products-data").innerHTML = this.responseText;
  };

  xhr.send("get_products");
}

function remove_product(val) {
  if (!confirm("Are you sure you want to delete this product?")) {
    return; // Exit if user clicks "Cancel"
  }

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/products_crud.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "product removed!");
      get_products();
    } else {
      alert("error", "Server down!");
    }
  };

  xhr.send("remove_product=" + encodeURIComponent(val));
}

window.onload = function () {
  get_products();
};
