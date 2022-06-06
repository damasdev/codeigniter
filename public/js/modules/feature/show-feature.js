$(document).on("change", ".form-check-input", function () {
  const roleId = $(this).attr("data-role");
  const featureId = $(this).attr("data-feature");
  const is_active = $(this).is(":checked") ? 1 : 0;

  $.ajax({
    url: `${baseURL}acl/feature`,
    type: "POST",
    data: {
      role_id: roleId,
      feature_id: featureId,
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
