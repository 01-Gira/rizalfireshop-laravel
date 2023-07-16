$(document).ready(function () {
    $(".select2").select2({
        theme: "bootstrap4",
    });

    var alertDiv = $("#alertContainer");

    // Mendefinisikan waktu countdown dalam milidetik (misalnya, 5 detik)
    var countdownDuration = 5000;

    // Menjalankan countdown menggunakan jQuery delay() dan fadeOut()
    alertDiv.delay(countdownDuration).fadeOut("slow");
});
