$(document).ready(function() {
    // Menghilangkan tombol cari
    $('#tombolCari').hide();

    // Event ketika keyword ditulis
    $('#keyword').on('keyup', function() {
        // Munculkan loading
        $('.loader').show();

        // Ajax menggunakan load
        // $('#container').load('ajax/mahasiswa.php?keyword='+$('#keyword').val())
        
        // $.get()
        $.get('ajax/mahasiswa.php?keyword='+$('#keyword').val(), function(data) {
            $('#container').html(data);
            $('.loader').hide();
        })
    
    })
})