//Auto Numeric
$(document).ready(function() {
  $('#modal').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
  });
  $('#harga_jual').autoNumeric('init', {
    aSep: ',',
    aDec: '.',
    mDec: '0'
});
$('#nominal_kas').autoNumeric('init', {
  aSep: ',',
  aDec: '.',
  mDec: '0'
});
});


//Flash Data
const swal = $('.users').data('users'); //Ambil Data FlashDatanya
if ( swal ){
    //Kalau Ada isinya jalankan sweetalert
    Swal.fire({
        title: 'Data User ',
        text: 'Berhasil ' + swal,
        icon: 'success'
    })
}

const produk = $('.produk').data('produk'); //Ambil Data FlashDatanya
if ( produk ){
    //Kalau Ada isinya jalankan sweetalert
    Swal.fire({
        title: 'Data Produk ',
        text: 'Berhasil ' + produk,
        icon: 'success'
    })
}

//Tombol-hapus
$('.tombol-hapus').on('click',function(e){
    //Matikan fungsi A href nya
    e.preventDefault();
    //Ambil Isi Hrefnya
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Data Akan Dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          //Tampilkan Href
          document.location.href = href;
        }
      })
});