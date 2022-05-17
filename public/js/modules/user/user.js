$(".remove").click(function (e) {
  e.preventDefault();

  let id = $(this).parents("tr").attr("id");

  Swal.fire({
    title: "Are you sure?",
    text: "You will not be able to recover this data!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: `${baseURL}user/${id}`,
        type: "DELETE",
        error: function ({ responseJSON }) {
          Swal.fire({
            text: responseJSON.message,
            icon: responseJSON.status,
          });
        },
        success: function (data) {
          $("#" + id).remove();
          Swal.fire({
            text: data.message,
            icon: data.status,
          });
        },
      });
    } else {
      Swal.fire({
        title: "Canceled",
        text: "Your request has been canceled",
        icon: "error",
      });
    }
  });
});

$("#submit").click(function (e) {
  e.preventDefault();

  let data = $("#form").serialize();

  $.ajax({
    url: `${baseURL}user`,
    type: "POST",
    data: data,
    caches: false,
    error: function ({ responseJSON }) {
      Swal.fire({
        text: responseJSON.message,
        icon: responseJSON.status,
      });
    },
    success: function (data) {
      Swal.fire({
        text: data.message,
        icon: data.status,
      }).then((result) => {
        if (result.isConfirmed) {
          location.reload();
        }
      });
    },
  });
});

$(".select2").select2({ tags: true, dropdownParent: $("#createUser") });
