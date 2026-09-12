$(document).ready(function () {
  function loadProducts() {
    $.ajax({
      url: "fetch_products.php",
      method: "GET",
      dataType: "json",
      success: function (products) {
        $("#product_list").empty();
        $.each(products, function (index, product) {
          $("#product_list").append(
            "<tr>" +
              "<td>" +
              product.ProductId +
              "</td>" +
              "<td>" +
              product.Title +
              "</td>" +
              // ... other product fields
              '<td><button class="btn btn-info">Edit</button></td>' +
              "</tr>"
          );
        });
      },
    });
  }

  loadProducts();

  // Handle form submission
  $("#add_product_modal form").submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
      url: "addproduct.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: response,
          confirmButtonColor: '#c084fc'
        });
        loadProducts();
        $("#add_product_modal").modal("hide");
      },
      error: function (response) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'An error occurred!',
          confirmButtonColor: '#c084fc'
        });
      },
    });
  });
});
