$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

$('#select-provinsi').select2({
    ajax: {
        url: '/select2/getprovinsi',
        dataType: 'json'
    },
    allowClear: true, 
    placeholder: 'Pilih',
});

var provinsi = $("#select-provinsi").val();
var kota = $("#select-kota").val();
var kecamatan = $("#select-kecamatan").val();

$('#select-kota').select2({
    ajax: {
        url: '/select2/getkota?province_id=' + provinsi,
        dataType: 'json'
    }
});

$('#select-kecamatan').select2({
    ajax: {
        url: '/select2/getkecamatan?regency_id=' + kota,
        dataType: 'json'
    }
});

$('#select-desa').select2({
    ajax: {
        url: '/select2/getdesa?district_id=' + kecamatan,
        dataType: 'json'
    }
});

$('#select-provinsi').on('select2:select', function (e) {
    $("#select-kota").select2('destroy');
    var data = e.params.data;
    $('#select-kota').select2({
        ajax: {
            url: '/select2/getkota?province_id=' + data.id,
            dataType: 'json'
        }
    });
});

$('#select-kota').on('select2:select', function (e) {
    $("#select-kecamatan").select2('destroy');
    var data = e.params.data;
    $('#select-kecamatan').select2({
        ajax: {
            url: '/select2/getkecamatan?regency_id=' + data.id,
            dataType: 'json'
        }
    });
});

$('#select-kecamatan').on('select2:select', function (e) {
    $("#select-desa").select2('destroy');
    var data = e.params.data;
    $('#select-desa').select2({
        ajax: {
            url: '/select2/getdesa?district_id=' + data.id,
            dataType: 'json'
        }
    });
});