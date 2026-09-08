$(document).ready(function(){
    // alert('XXXX');
    // $("#select-tipe").change();
});
$("#bulan-hik").on('change',function(){
    $("#select-tipe").change();
})
$("#tahun-hik").on('blur',function(){
    $("#select-tipe").change();
})
$('#tahun-hik').on('keypress', function(e) {
    if (e.which == 13) {
		$("#select-tipe").change();
    }
});
$("#updatehikiai").click(function(){
    $("#select-tipe").change();
})
$("#select-tipe").on('change',function(){
    var isi = $(this).val();
    if(isi==''){
        $("#btntambahhikiai").addClass('disabled');
    }else{
        $("#btntambahhikiai").removeClass('disabled');
    }
    $.ajax({
        dataType: "json",
        type: "POST",
        url: base_url + "hikiai/addsession",
        data: {
            tipe: isi,
            bul: $("#bulan-hik").val(),
            tah: $("#tahun-hik").val(),
        },
        success: function (data) {
            // alert(data);
            window.location.href = base_url+'hikiai';
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            kode = thrownError;
        },
    });
});

$("#perpage-produk").on('change',function(){
    $.ajax({
        dataType: "json",
        type: "POST",
        url: base_url + "produk/addsession",
        data: {
            page: $(this).val() ,
        },
        success: function (data) {
            // alert(data);
            window.location.href = base_url+'produk';
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            kode = thrownError;
        },
    });
});

$("#btncariproduk").click(function(){
    $.ajax({
        dataType: "json",
        type: "POST",
        url: base_url + "produk/addsession",
        data: {
            text: $("#textcariproduk").val() ,
        },
        success: function (data) {
            // alert(data);
            window.location.href = base_url+'produk';
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            kode = thrownError;
        },
    });
})