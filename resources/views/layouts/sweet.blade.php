<!-- Sweet alert untuk Hapus User -->
<script>
    $('.confirm-delete').on('click', function (event) {
        event.preventDefault();
        var form = event.target.form; // storing the form
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // submitting the form when user press yes
            }
        });
    });
</script>

<!-- Sweet Alert untuk Log out -->
<script>
    function logout() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan keluar dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Tidak, batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>