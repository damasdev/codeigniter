$(document).ready(function () {
  /**
   * Datatables
   */
  $("#user").DataTable({
    processing: true,
    serverSide: true,
    stateSave: true,
    autoWidth: false,
    ajax: {
      url: `${baseURL}user/datatables`,
      method: "POST",
    },
    columns: [
      {
        name: "users.name",
        data: "name",
        searchable: true,
      },
      {
        name: "users.email",
        data: "email",
        searchable: true,
      },
      {
        name: "roles.name",
        data: "role",
        searchable: true,
      },
      {
        name: "users.id",
        data: "id",
        render: function (id) {
          return `
            <a href="${baseURL}user/${id}" class="btn btn-sm text-primary">
              <i class="ti ti-list-details"></i>
              Detail
            </a>
            |
            <a href="${baseURL}user/${id}/edit" class="btn btn-sm text-warning">
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
          url: `${baseURL}user/${id}`,
          type: "DELETE",
          error: function ({ responseJSON }) {
            Swal.fire({
              text: responseJSON.message,
              icon: responseJSON.status,
            });
          },
          success: function (data) {
            $("#user").DataTable().ajax.reload();
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
        }).then(() => {
          $("#user").DataTable().ajax.reload();
          $("#form").trigger("reset");
        });
      },
    });
  });
});

$(".select2").select2({ tags: true, dropdownParent: $("#createUser") });
