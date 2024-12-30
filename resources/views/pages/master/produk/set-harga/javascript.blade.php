<script>
    function labapersen(id_hpp, id_item) {
        const hpp_final_element = $('#hpp_final' + id_hpp);
        const hasil_laba_element = $('#hasil-laba' + id_item);
        const disc_1_element = $('#disc_1' + id_item);
        const disc_2_element = $('#disc_2' + id_item);
        const harga_jual_element = $('#harga-jual' + id_item);
        const laba_element = $('#laba' + id_item);

        laba_element.on('input', function() {
            let persen = 1 + parseFloat($(this).val()) / 100;
            let hpp_final = parseFloat(hpp_final_element.val().replace(".", ""));
            let result = hpp_final * persen;
            result = parseFloat(result.toFixed(0));
            // Format nilai menjadi format mata uang Rupiah
            var formattedResult = result.toLocaleString('id-ID')

            hasil_laba_element.val(formattedResult);

            if (isNaN(result)) {
                hasil_laba_element.val(hpp_final);
            }

            updateHargaJual();
        });

        hasil_laba_element.on('input', function() {
            // Normalisasi input: hapus titik sebagai pemisah ribuan dan ganti koma desimal dengan titik
            let inputValRaw = $(this).val().replace(/\./g, "").replace(",", ".");
            let hppFinalRaw = hpp_final_element.val().replace(/\./g, "").replace(",", ".");

            // Parsing ke floating point
            let inputVal = parseFloat(inputValRaw);
            let hpp_final = parseFloat(hppFinalRaw);

            // Periksa validitas nilai input dan hpp_final sebelum perhitungan
            if (!isNaN(inputVal) && !isNaN(hpp_final) && hpp_final !== 0) {
                let hasil_persen = ((inputVal - hpp_final) / hpp_final) * 100;
                laba_element.val(hasil_persen.toFixed(2).replace(",", "."));
            } else {
                laba_element.val('Data tidak valid');
            }

            // Format kembali ke bentuk lokal dan set value
            $(this).val(new Intl.NumberFormat('id-ID').format(inputVal));

            updateHargaJual();
        });



        disc_1_element.on('input', function() {
            let hpp_final = parseFloat(hpp_final_element.val().replace(".", ""));
            let result = parseFloat(hasil_laba_element.val().replace(".", ""));
            let disc_1 = parseFloat(disc_1_element.val());
            let disc_2 = parseFloat(disc_2_element.val());

            let hasil_disc_1 = result - (result * disc_1 / 100);
            let hasil_disc_2 = hasil_disc_1 - (hasil_disc_1 * disc_2 / 100);

            let harga_jual = !isNaN(hasil_disc_2) ? Math.round(hasil_disc_2) : hpp_final;
            harga_jual_element.val(harga_jual);
            updateHargaJual();
        });

        disc_2_element.on('input', function() {
            let hpp_final = parseFloat(hpp_final_element.val().replace(".", ""));
            let result = parseFloat(hasil_laba_element.val().replace(".", ""));
            let disc_1 = parseFloat(disc_1_element.val());
            let disc_2 = parseFloat(disc_2_element.val());

            let hasil_disc_1 = result - (result * disc_1 / 100);
            let hasil_disc_2 = hasil_disc_1 - (hasil_disc_1 * disc_2 / 100);

            let harga_jual = !isNaN(hasil_disc_2) ? Math.round(hasil_disc_2) : hpp_final;

            harga_jual_element.val(harga_jual.toLocaleString('id-ID'));

            updateHargaJual();
        });

        function updateHargaJual() {
            let hpp_final = parseFloat(hpp_final_element.val().replace(/\./g, "").replace(",", "."));
            let result = parseFloat(hasil_laba_element.val().replace(/\./g, "").replace(",", "."));
            let disc_1 = parseFloat(disc_1_element.val());
            let disc_2 = parseFloat(disc_2_element.val());

            let hasil_disc_1 = result - (result * disc_1 / 100);
            let hasil_dis_2 = Math.round(hasil_disc_1 - (hasil_disc_1 * disc_2 / 100));
            let formatedHasil = hasil_dis_2.toLocaleString('id-ID');
            harga_jual_element.val(!isNaN(hasil_dis_2) ? formatedHasil : hpp_final.toLocaleString('id-ID'));

            var messageElement = document.getElementById("message");
            if (hasil_dis_2 < hpp_final) {
                messageElement.style.display = "block";
            } else {
                messageElement.style.display = "none";
            }
        }

    }

    //setting input
    $(document).ready(function() {
        $('.number').on('input', function() {
            var sanitized = $(this).val().replace(/[^0-9,.]/g,
                '');
            $(this).val(sanitized);
        });

        function checkPrices() {
            $('input[name$="[harga_jual]"]').each(function() {
                var hargaJualInput = $(this);
                var idItem = hargaJualInput.attr('name').match(/\[(.*?)\]/)[1];
                var hppFinal = parseFloat($('input[name="sets[' + idItem + '][hasil_laba]"]')
                    .val());
                var hargaJual = parseFloat(hargaJualInput.val());

                if (hppFinal > hargaJual) {
                    console.log('kebanyakan');
                }
            });
        }

        // Call the function on page load
        checkPrices();
    });

    function checkInput(e, chars, field) {
        let teks = field.value;
        let teksSplit = teks.split("");
        let teksOke = [];
        for (let i = 0; i < teksSplit.length; i++) {
            if (chars.indexOf(teksSplit[i]) != -1) {
                teksOke.push(teksSplit[i]);
            }
        }
        field.value = teksOke.join("");
    }

    function formatNumber(input) {
        input.value = input.value.replace(/[^\d.]/g, '');

        let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
        input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
    }
</script>
