</section>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="reset.js"></script>
<script src="dots.js"></script>;
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>

<script>
function formatRupiahteks(input) {
    var value = input.value;
    value = value.replace(/[^,\d]/g, '').toString();
    var split = value.split(',');
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    input.value = 'Rp. ' + rupiah;
}

document.addEventListener('DOMContentLoaded', (event) => {
    const dropdownItems = document.querySelectorAll('#myDropdown .dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const idBarang = item.getAttribute('data-id');
            const namaBarang = item.textContent;
            document.getElementById('myInput').value = namaBarang;
            document.getElementById('id_barang').value = idBarang;
            hideDropdown();
        });
    });
});

</script>
<script type="text/javascript">	
	$(document).ready(function() {
		$('#id_barang').select2();
	});
</script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        $('#example').DataTable();
    });
</script>
<script>
    // event will be executed when the toggle-button is clicked
    document.getElementById("button-toggle").addEventListener("click", () => {

        // when the button-toggle is clicked, it will add/remove the active-sidebar class
        document.getElementById("sidebar").classList.toggle("active-sidebar");

        // when the button-toggle is clicked, it will add/remove the active-main-content class
        document.getElementById("main-content").classList.toggle("active-main-content");
    });
</script>
</body>

</html>