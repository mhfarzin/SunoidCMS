document.addEventListener("DOMContentLoaded", function () {
  if (window.summernoteRichtextInitialized) return;
  window.summernoteRichtextInitialized = true;

  document.querySelectorAll(".richtext-textarea").forEach(function (textarea) {
    $(textarea).summernote({
      height: 450,
      lang: "en-US",
      toolbar: [
        ["style", ["style"]],
        ["font", ["bold", "underline", "clear"]],
        ["fontname", ["fontname"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["table", ["table"]],
        ["insert", ["link", "picture", "video"]],
        ["view", ["codeview", "fullscreen"]],
      ],
      callbacks: {
        onImageUpload: function (files) {
          var data = new FormData();
          data.append("image", files[0]);
          var csrfToken = $('input[name="csrf_token"]').val();
          if (csrfToken) {
            data.append("csrf_token", csrfToken);
          }

          $.ajax({
            url: "/admin/ajax/upload_image.php",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function (response) {
              if (response.success) {
                $(this).summernote("insertImage", response.url);
              } else {
                alert("Upload failed: " + (response.error || "Unknown error"));
              }
            },
            error: function () {
              alert("Upload failed");
            },
          });
        },
      },
    });
  });
});
