$("#submit").click(function (e) {
  e.preventDefault();

  let data = $("#form").serialize();
  const featureId = $("#feature_id").val();

  $.ajax({
    url: `${baseURL}feature/${featureId}`,
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
