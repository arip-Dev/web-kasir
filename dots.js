// fungsi ini sangat penting karena untuk memasukan data ke dalam database
// fungsi ini membuat angka jadi terpisah oleh titik setiap 3 angka contoh 1.000
// agar dapat dibaca dengan mudah oleh user
document.addEventListener('DOMContentLoaded', function () {
  const numberInputs = document.querySelectorAll('.numberInput');
  const forms = document.querySelectorAll('.myForm');

  numberInputs.forEach(input => {
      input.addEventListener('input', function () {
          let value = input.value.replace(/\./g, '');
          input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      });
  });

  forms.forEach(form => {
      form.addEventListener('submit', function (event) {
          numberInputs.forEach(input => {
              input.value = input.value.replace(/\./g, '');
          });
      });
  });
});

// FUNGSI REMOVEFORMAT & REMOVEFORMATTEKS SANGAT PENTING KALO SAMPAI DIHAPUS KM AKAN PUSING :)
// fungsi dibawah adalah untuk menghapus tulisan Rp dan .(titik)/menghapus yang selain angka
// agar sistem hanya membaca angka
function removeFormat(input) {
  input.value = input.value.replace(/[^,\d]/g, '');
}
function formatRupiahteks(input) {
  var value = input.value;
  value = value.replace(/[^,\d]/g, "").toString();
  var split = value.split(",");
  var sisa = split[0].length % 3;
  var rupiah = split[0].substr(0, sisa);
  var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
  if (ribuan) {
    var separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }
  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  input.value = "Rp. " + rupiah;
}
