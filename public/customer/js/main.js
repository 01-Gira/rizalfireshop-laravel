// $(document).ready(function () {
//     // Ketika pilihan provinsi diubah
//     $('select[name="province"]').on("change", function () {
//         let provinceId = $(this).val();

//         if (provinceId) {
//             jQuery.ajax({
//                 url: "/province/" + provinceId + "/cities",
//                 type: "GET",
//                 dataType: "json",
//                 success: function (data) {
//                     $("select[name=city_destination]").empty();
//                     $.each(data, function (key, value) {
//                         $('select[name="city_destination"]').append(
//                             '<option value="' + key + '">' + value + "</option>"
//                         );
//                     });
//                 },
//             });
//         } else {
//             $('select[name="city_destination"]').empty();
//         }
//     });
// });

// $(document).ready(function () {
//     // Ketika pengguna memilih kurir
//     $("select[name=courier]").on("change", function () {
//         var courier = $(this).val(); // Ambil nilai kurir yang dipilih
//         var city_destination = $("select[name=city_destination]").val(); // Ambil nilai destination
//         var weight = $("input[name=weight]").val(); // Ambil nilai weight

//         // Buat permintaan ajax ke API RajaOngkir
//         $.ajax({
//             url: "/checkout/cost",
//             method: "POST",
//             data: {
//                 courier: courier,
//                 city_destination: city_destination,
//                 weight: weight,
//                 _token: $('meta[name="csrf-token"]').attr("content"),
//             },
//             success: function (response) {
//                 $("select[name=courier_service]").empty();
//                 // Tampilkan data ongkos kirim ke pengguna
//                 var costs = response[0].costs;
//                 var options = "";
//                 for (var i = 0; i < costs.length; i++) {
//                     options +=
//                         '<option value="' +
//                         costs[i].service +
//                         '" data-cost="' +
//                         costs[i].cost[0].value +
//                         '">' +
//                         costs[i].service +
//                         " - Rp" +
//                         costs[i].cost[0].value +
//                         "</option>";
//                 }
//                 $("select[name=courier_service]").html(options);
//                 updateTotal();
//             },
//             error: function (xhr) {
//                 console.log(xhr.responseText);
//             },
//         });
//     });

//     // Ketika pengguna memilih layanan pengiriman
//     $("select[name=courier_service]").on("change", function () {
//         updateTotal();
//     });
//     // Fungsi untuk memperbarui total biaya
//     function updateTotal() {
//         var cost = $("select[name=courier_service] option:selected").data(
//             "cost"
//         ); // Ambil biaya layanan pengiriman yang dipilih
//         var subtotal = $("span#subtotal").data("subtotal"); // Ambil subtotal belanja
//         var subcharge = $("span#subcharge").data("subcharge");

//         // Jika cost tidak valid, set nilai default 0
//         if (isNaN(cost)) {
//             cost = 0;
//         }

//         var total = subtotal + subcharge + parseFloat(cost); // Hitung total biaya
//         // Tampilkan total biaya ke pengguna
//         $("span#total").text("Rp." + number_format(total, 0, ",", "."));
//         $("input[name=total_price]").val(total);
//     }

//     function number_format(number, decimals, dec_point, thousands_sep) {
//         decimals = decimals || 0;
//         number = parseFloat(number);

//         if (isNaN(number) || !isFinite(number)) {
//             return "-";
//         }

//         var parts = [];
//         var sign = number < 0 ? "-" : "";
//         var integer = Math.abs(Math.round(number)).toString();
//         var fraction =
//             decimals > 0
//                 ? dec_point +
//                   (Math.abs(number) - integer).toFixed(decimals).slice(2)
//                 : "";
//         var thousands = thousands_sep === undefined ? "," : thousands_sep;
//         while (integer.length > 3) {
//             parts.unshift(integer.slice(-3));
//             integer = integer.slice(0, -3);
//         }
//         parts.unshift(integer);
//         return sign + parts.join(thousands) + fraction;
//     }
// });
