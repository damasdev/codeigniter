$(document).ready(function () {
  /**
   * Datatables
   */
  $("#feature").DataTable({
    processing: true,
    serverSide: true,
    stateSave: true,
    ajax: {
      url: `${baseURL}feature/datatables`,
      method: "POST",
    },
    columns: [
      { data: "module" },
      { data: "class" },
      { data: "method" },
      { data: "description" },
      {
        data: "id",
        render: function (id) {
          return `
            <a href="${baseURL}feature/${id}" class="btn btn-sm text-primary">
              <i class="ti ti-list-details"></i>
              Detail
            </a>
            |
            <a href="${baseURL}feature/${id}/edit" class="btn btn-sm text-warning">
              <i class="ti ti-edit"></i>
              Edit
            </a>
            |
            <span class="btn btn-sm text-danger remove" data-id="${id}">
              <i class="ti ti-trash"></i>
              Delete
            </span>
          `;
        },
      },
    ],
  });

  /**
   * Destroy Data
   */
  $(document).on("click", ".remove", function () {
    let id = $(this).attr("data-id");
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
          url: `${baseURL}feature/${id}`,
          type: "DELETE",
          error: function ({ responseJSON }) {
            Swal.fire({
              text: responseJSON.message,
              icon: responseJSON.status,
            });
          },
          success: function (data) {
            $("#feature").DataTable().ajax.reload();
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

  /**
   * Store Data
   */
  $("#submit").click(function (e) {
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
      url: `${baseURL}feature`,
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
        }).then(() => {
          $("#feature").DataTable().ajax.reload();
        });
      },
    });
  });
});