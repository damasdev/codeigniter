$(document).on("change", ".form-check-input", function () {
  const roleId = $(this).attr("data-role");
  const menuId = $(this).attr("data-menu");
  const is_active = $(this).is(":checked") ? 1 : 0;

  $.ajax({
    url: `${baseURL}acl/menu`,
    type: "POST",
    data: {
      role_id: roleId,
      menu_id: menuId,
      is_active: is_active,
    },
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
      });
    },
  });
});
