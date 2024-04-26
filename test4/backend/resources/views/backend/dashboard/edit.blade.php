<form action="{{ url($api) }}" method="POST" id="formData" enctype="application/x-www-form-urlencoded">
    @method('PUT')
    @csrf

    <input type="hidden" name="uuid" value="{{ $record->uuid }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Nama Mahasiswa') }}</label>
                            <select name="mahasiswaId" class="form-control">
                                <option value=""> Pilih Salah Satu</option>
                                @if(count($dataMhs) > 0)
                                    @foreach($dataMhs as $k => $value)
                                        <option value="{{ $value->uuid }}" {{ $record->mahasiswaId == $value->uuid ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
        
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Nama Buku') }}</label>
                            <select name="bukuId" class="form-control">
                                <option value=""> Pilih Salah Satu</option>
                                @if(count($dataBuku) > 0)
                                    @foreach($dataBuku as $k => $value)
                                        <option value="{{ $value->uuid }}" {{ $record->bukuId == $value->uuid ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Tanggal Peminjaman') }}</label>
                            <input id="name" type="date" class="form-control tanggalPinjam0" data-no="0" name="tanggalPinjam" value="{{ $record->tanggalPinjam }}" required autofocus placeholder="Tanggal Peminjaman" maxlength="50">
                        </div>
                    </div>
        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Tanggal Pemulangan') }}</label>
                            <input id="name" type="date" class="form-control tanggalKembali0" data-no="0" name="tanggalKembali" value="{{ $record->tanggalKembali }}" required autofocus placeholder="Tanggal Pemulangan" maxlength="50">
                        </div>
                    </div>
        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Lama Hari') }}</label>
                            <input id="name" type="text" class="form-control lamaPinjam0" name="lamaPinjam" value="{{ $record->lamaPinjam }}" readonly autofocus placeholder="Lama Hari" maxlength="50">
                        </div>
                    </div>
        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Status Pinjam') }}</label>
                            <select name="status" class="form-control">
                                <option value=""> Pilih Salah Satu</option>
                                <option value="0" {{ $record->status == 0 ? 'selected' : '' }}>Dipinjam</option>
                                <option value="1" {{ $record->status == 1 ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="flaticon-circle"></i>
        Tutup
    </button>
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 saveData">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
</div>

</form>

<script>

$(document).on('change', '[name="tanggalPinjam"]', function(){
        var no = $(this).data('no');
        
        var awal = new Date($(this).val());
        var akhir = new Date($('.tanggalKembali'+no).val());
        
        const diffInMilliseconds = akhir.getTime() - awal.getTime();
        const diffInDays = Math.ceil(diffInMilliseconds / (1000 * 60 * 60 * 24));

        $('.lamaPinjam'+no).val(diffInDays)
    })

    $(document).on('change', '[name="tanggalKembali"]', function(){
        var no = $(this).data('no');
        
        var akhir = new Date($(this).val());
        var awal = new Date($('.tanggalPinjam'+no).val());
        
        const diffInMilliseconds = akhir.getTime() - awal.getTime();
        const diffInDays = Math.ceil(diffInMilliseconds / (1000 * 60 * 60 * 24));

        $('.lamaPinjam'+no).val(diffInDays)
    })

    // SSave Data
    $(document).on('click', '.saveData', function (e) {
        var form = $(this).data('form');
        var callback = $(this).data('callback');
        resLamaPinjam = [];
        var checkLamaPinjam = $('.lamaPinjam').serializeArray();
        if(checkLamaPinjam.length > 0){
            $.each(checkLamaPinjam, function(v,k){
                total = parseInt(k.value);
                if(total > 20){
                    resLamaPinjam.push(1)
                }
            })
        }
        
        if(resLamaPinjam.length > 0){
            Swal.fire({
                type: 'error',
                title: 'Gagal Simpan',
                text: 'Terdapat Data Lama Hari Yang Melebihi Waktu Dari 20 Hari Silahkan Di Sesuaikan',
            })
        }
        if(!form){
          form = 'formData';
        } 
        console.log('form',form)
        console.log('callback',callback)
        if(!callback){
            callback = null;
        } 
        saveDataNew(form,callback);

    });

    function saveDataNew(formid, callback) {

        $('#'+formid).append(`
            <div class="loadings" >Loading&#8230;</div>
        `);
        $("#" + formid).ajaxSubmit({
            success: function (resp) {
                console.log('resp', resp)
                if(resp.status != 200){
                    Swal.fire({
                        type: 'info',
                        title: 'Terjadi Kesalahan',
                        html: showBoxValidation(resp),
                    });
                }else{
                    Swal.fire({
                        type: 'success',
                        title: 'Sukses',
                        text: 'Proses penyimpan data berhasil',
                        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Kembali !',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                        // footer: '<a href>Why do I have this issue?</a>'
                    }).then(function(){
                        if(callback != null){
                            location.href = callback;
                        }else{
                            if(resp.url){
                                window.open(resp.url, '_blank');
                            }else if(resp.status){
                                window.location.reload();
                            }else if(resp.loadModal){
                                if(resp.dataK){
                                    loadModal({
                                        'url': resp.loadUrl,
                                        'modal': '#largeModal'
                                    }, function (resp) {
                                            onShow();
                                    }); 
                                    // $('.loadModalPdf'+resp.dataK).attr('data-url', resp.loadUrl);
                                    // $('.loadModalPdf'+resp.dataK).click();
                                }else{
                                    $('.loadModalPdf').attr('data-url', resp.loadUrl);
                                    $('.loadModalPdf').click();
                                }
                                
                                
                            }
                        }
                    });

                }
            },
            error: function (resp) {
                console.log('eroor',resp)
                $('.loadings').hide();
                var response = resp.responseJSON;
                var addErr = {};

                Swal.fire({
                    type: 'info',
                    title: 'Terjadi Kesalahan',
                    html: showBoxValidation(response),
                });
                
                var intrv = setInterval(function(){
                    $('.form-group .error-label').slideUp(500, function(e) {
                        $(this).remove();
                        $('.form-group.has-error').removeClass('has-error');
                        clearTimeout(intrv);
                    });
                }, 14000)

            }
        });
    }
</script>
