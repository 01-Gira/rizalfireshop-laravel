// (function ($) {
//     "use strict";
// })(jQuery);

// $(function () {
//     $(".navbar-toggler").on("click", function () {
//         $(".navbar-collapse").toggleClass("show");
//     });
// });

$(document).ready(function () {
    // Ketika pilihan provinsi diubah
    $('select[name="province"]').on("change", function () {
        let provinceId = $(this).val();

        if (provinceId) {
            jQuery.ajax({
                url: "/province/" + provinceId + "/cities",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("select[name=city_destination]").empty();
                    $.each(data, function (key, value) {
                        $('select[name="city_destination"]').append(
                            '<option value="' + key + '">' + value + "</option>"
                        );
                    });
                },
            });
        } else {
            $('select[name="city_destination"]').empty();
        }
    });
});

// $(document).ready(function () {
//     // Ketika pengguna memilih kurir
//     $("select[name=courier]").on("change", function () {
//         var courier = $(this).val(); // Ambil nilai kurir yang dipilih
//         var destination = $("input[name=city_destination]").val(); // Ambil nilai destination
//         var weight = $("input[name=weight]").val(); // Ambil nilai weight

//         // Buat permintaan ajax ke API RajaOngkir
//         $.ajax({
//             url: "/checkout/cost",
//             method: "POST",
//             data: {
//                 courier: courier,
//                 destination: destination,
//                 weight: weight,
//                 _token: $('meta[name="csrf-token"]').attr("content"),
//             },
//             success: function (response) {
//                 // Tampilkan data ongkos kirim ke pengguna
//                 var costs = response.rajaongkir.results[0].costs;
//                 var options = "";
//                 for (var i = 0; i < costs.length; i++) {
//                     options +=
//                         '<option value="' +
//                         costs[i].service +
//                         '">' +
//                         costs[i].service +
//                         " - Rp" +
//                         costs[i].cost[0].value +
//                         "</option>";
//                 }
//                 $("select[name=service]").html(options);
//             },
//             error: function (xhr) {
//                 console.log(xhr.responseText);
//             },
//         });
//     });
// });
