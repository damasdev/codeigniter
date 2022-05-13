$("#submit").click(function (e) {
  e.preventDefault();

  let data = $("#form").serialize();
  const userId = $("#user_id").val();

  $.ajax({
    url: `${baseURL}user/${userId}`,
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

$(".select2").select2();