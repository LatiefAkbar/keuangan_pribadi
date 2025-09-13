const inputJumlah = document.getElementById("jumlah");

inputJumlah.addEventListener("input", function(e) {
    let value = this.value.replace(/\D/g, ""); // hapus semua non-digit
    this.value = new Intl.NumberFormat('id-ID').format(value); // format ribuan
});

document.querySelector("form").addEventListener("submit", function() {
    inputJumlah.value = inputJumlah.value.replace(/\./g, ""); // hapus titik sebelum submit
});
