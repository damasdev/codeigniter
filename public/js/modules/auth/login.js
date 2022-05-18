$("#submit").click(function (e) {
  e.preventDefault();

  let data = $("#form").serialize();

  $.ajax({
    url: `${baseURL}auth/login`,
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
        const url = `${baseURL}auth/index`;
        if (result.isConfirmed) {
          window.location.replace(url);
        } else {
          window.location.replace(url);
        }
      });
    },
  });
});
