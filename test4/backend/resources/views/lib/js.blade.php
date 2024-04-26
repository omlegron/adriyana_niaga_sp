<style nonce="{{ csp_nonce() }}">
    .alert-label-login{
        margin-top: 0.25rem;
        font-size: smaller;
        color: #ea5455;
    }

    .error-label{
        margin-top: 0.25rem;font-size: smaller;color: #ea5455;
    }
</style>

<script nonce="{{ csp_nonce() }}" src="{{ asset('assets/plugins/custom/select/select2.min.js') }}"></script>

<script type="text/javascript" nonce="{{ csp_nonce() }}">

    $(document).on('keypress',function(e) {
        if(e.which == 13) {
        }
    });

    //ACTION COMMAND ----------------------------------------------------------------------------//
    $('.alphabetonly').keypress(function (e) {
        var regex = new RegExp(/^[a-zA-Z\s]+$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else
        {
            e.preventDefault();
            return false;
        }
    });
    
    // DYNAMIC Input SELECT
    $(document).on('change', '.option-ajax', function () {
        var append = $(this).data('append');
        var value = $(this).val();
        if (value != null) {
            $.ajax({
                url: '{{ url("option") }}/' + append + '/' + value,
                type: 'GET',
                success: function (resp) {
                    console.log('asd')
                    $('#' + append).html(resp);
                },
                error: function (resp) {
                    console.log('haha');
                }
            });
        }
    });  

    $(document).on('change', '.option-attribute', function () {
        var append = $(this).data('append');
        var value = $(this).val();
        if (value != null) {
            $.ajax({
                url: '{{ url("option") }}/' + append + '/' + value,
                type: 'GET',
                success: function (resp) {
                    console.log('asd')
                    $('#' + append).val(resp);
                },
                error: function (resp) {
                    console.log('haha');
                }
            });
        }
    });  


    $(document).on('change', '.option-ajax-multiple', function () {
        var append = $(this).data('append');
        var id = $('#'+$(this).data('id')).val();
        var value = $(this).val();
        console.log('hehe');
        if (value != null) {
            $.ajax({
                url: '{{ url("option") }}/' + append + '/' + id + '/' + value,
                type: 'GET',
                success: function (resp) {
                    $('#' + append).html(resp);
                },
                error: function (resp) {
                }
            });
        }
    });  

    // OPEN MODAL FOR CREATE DATA
    $(document).on('click', '.add-modal', function (e) {
        var modal = $(this).data('modal')
        var url = $(this).data('url');
        
        loadModal({
            url: (url) ? url : "{!! isset($route) ? route($route.'.create') : '' !!}",
            modal: modal,
        }, function (resp) {
            onShow();
        }); 
    }); 

    // OPEN CREATE PAGE 
    $(document).on('click', '.add-page', function(event) {
        var url = "{!! isset($route) ? route($route.'.create') : '' !!}";
        window.location = url;

    });

     // OPEN CUSTOM CREATE PAGE 
     $(document).on('click', '.add-custome-page', function(event) {
        url = $(this).data('url');
        window.location = url;

    });

     $(document).on('click', '.delete-data', function (e) {
        var idx = $(this).data('id');
        var callback = $(this).data('callback');
        var url = '{!! isset($route) ? route($route.'.index') : '' !!}/' + idx
        deleteData(url, callback);
    });

    $(document).on('click', '.send-notif', function (e) {
        var idx = $(this).data('id');
        var callback = $(this).data('callback');
        var url = $(this).data('url')
        sendNotif(url, callback);
    });

    // OPEN MODAL FOR ADD URL DATA
    $(document).on('click', '.custome-modal', function (e) {
        var modal = $(this).data('modal');
        var url = $(this).data('url');
        console.log('url', url);
        loadModal({
            url: "{{ url('/') }}/" + url,
            modal: modal,
        }, function (resp) {
            onShow();
        });

    });

    // SAVE DATA
    $(document).on('click', '.save', function (e) {
        var form = $(this).data('form');
        var callback = $(this).data('callback');
        if(!form){
          form = 'formData';
        } 
        console.log('form',form)
        console.log('callback',callback)
        if(!callback){
            callback = null;
        } 
        saveData(form,callback);

    });

    // Login
    $(document).on('click', '.loginKt', function(e){
        var form = $(this).data('form');
        var callback = $(this).data('callback');
        if(!form){
          form = 'formData';
        } 
        console.log('form',form)
        console.log('callback',callback)
        if(!callback){
            callback = null;
        } 
        $("#" + form).ajaxSubmit({
            success: function (resp) {
                location.href  = resp.url;
            },
            error: function (resp) {
                $('.loadings').hide();
                var response = resp.responseJSON;
                var addErr = {};
                console.log('resp',resp)
                if(resp.responseJSON || resp.responseJSON.errors || resp.responseJSON.error){
                    $.each(response.error, function (index, val) {

                        var response = resp.responseJSON;
                        if (index.includes(".")) {
                            res = index.split('.');
                            index = '';
                            for (i = 0; i < res.length; i++) {
                                if (i == 0) {
                                    res[i] = res[i];
                                } else {
                                    if (res[i] == 0) {
                                        res[i] = '['+res[i]+']';
                                    } else {
                                        res[i] = '[' + res[i] + ']';
                                    }
                                }
                                index += res[i];
                            }
                        }
                        clearFormError(index,val,form);

                        var name = index.split('.').reduce((all, item) => {
                            all += (index == 0 ? item : '[' + item + ']');
                            return all;
                        });
                        console.log('naem',name)
                        var fg = $('[name="' + name + '"], [name="' + name + '[]"]').closest('.form-group');
                        fg.addClass('has-error');

                        fg.append('<small class="control-label error-label font-bold alert-label-login">' + val + '</small>')
                    });

                    $("html, body").animate({ scrollTop: 0 }, "slow");

                    // Swal.fire({
                    //     type: 'info',
                    //     title: 'Terjadi Kesalahan',
                    //     html: showBoxValidation(resp),
                    // });
                }else{
                    Swal.fire({
                        type: 'info',
                        title: 'Terjadi Kesalahan',
                        html: showBoxValidation(resp),
                    });
                }
                
                var intrv = setInterval(function(){
                    $('.form-group .error-label').slideUp(500, function(e) {
                        $(this).remove();
                        $('.form-group.has-error').removeClass('has-error');
                        clearTimeout(intrv);
                    });
                }, 20000)

            }
        });
    })

    $(document).on('click', '.saveModal', function (e) {
        var form = $(this).data('form');
        var callback = $(this).data('callback');
        var url = $(this).data('url');
        if(!form){
          form = 'formData';
        } 
        
        if(!callback){
            callback = null;
        } 

        console.log('url',url)
        
        saveModalData(form, callback, url);

    });

    // GLOBAL FUNCTION DOWNLOAD PDF
    $(document).on('click','.downloadPdf',function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        $.ajax({
            url: "{{ url('') }}/"+url,
            type: "POST",
            data : {
              '_token' : "{{ csrf_token() }}",
              'id' : id,
          },
          success: function(resp){
            window.open(resp,'_blank');
        },
        error : function(resp){
            toastr.error('Terjadi Kesalahan / data tidak ada', 'Gagal Mendownload');
        },
    });
    });

    $(document).on('click','.approve-modal',function(e){
        var callback = $(this).data('callback');
        var url = $(this).data('url');
        var status = $(this).data('status');
        var id = $(this).data('id');
        var data = $('.removeAll').serializeArray();
        var title = $(this).data('title');
        var messageData = $(this).data('message');
        var approvalID = $(this).data('approval');
        var description = $('[name="descriptionReject"]').val();
        var dataId = [];

        var approval = (title) ? 2 : 1;

        if(!id){
            $.each(data, function(k,v){
                dataId.push({ id: v.value, description:"", approval:approvalID });
            });
        }else{
            dataId.push({ id: id, description:description, approval:approvalID });
        }

        approveData(url, callback, dataId, status, title, messageData, approval);
    })
    
    // FUNCTION ---------------------------------------------------------------------------------------------------------
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    
    $(document).ready(function(){
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Pilih Data"
        });
        $('.pickadate').pickadate({
            format: 'yyyy-mm-dd',
            selectYears: 100,
            selectMonths: true
        });
        $('.dropify').dropify();

        $('.summernote').summernote({
            height : 240,
            maximumImageFileSize: 409715,
            lineHeight : 10,
            fontSizes: ['8', '9', '10', '11', '12', ,'13', '14', '15', '16', '17', '18'],
            fontName: 'Arial',
            toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ],
            callbacks: {
              onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();

                  // Firefox fix
                  setTimeout(function () {
                    document.execCommand('insertText', false, bufferText);
                }, 10);
              },
              onImageUpload: function(image) {
                  uploadImage(image[0]);
              }
          }
      });    

    });

    // APPROVE DATA
    function approveData(url, callback, dataPost = {}, status = 1, title = "Apakah Anda Yakin Akan Mengapprove Data?", messageData = "Silahkan Pilih Approve Data Atau Anda Dapat Mengcancel Approval!", approval = 1) 
    {
        var confirmTitle = (approval == 1) ? 'Approve' : 'Reject';

        Swal.fire({
            title: title,
            text: messageData,
            type: "question",
            showCancelButton: true,
            confirmButtonText: 'Ya, '+confirmTitle+'!',
            confirmButtonColor:'#0BB7AF',
            cancelButtonText: 'Tidak, Batalkan!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        Accept: "application/json, text/javascript, */*; q=0.01",
                        'Authorization': 'Bearer ' + "{{ (\Auth::check()) ? auth()->user()->getToken() : '' }}"
                    },
                    url: url,
                    type: 'POST',
                    data: {
                        '_token' : '{{ csrf_token() }}',
                        'data' : dataPost,
                        'status': status
                    }
                })
                .done(function(response) {
                    Swal.fire({
                      type: 'success',
                      title: ''+confirmTitle+'',
                      text: 'Data Berhasil Di '+confirmTitle+'!',
                      button: true,
                      confirmButtonText:'Tutup',
                      confirmButtonColor:'#0BB7AF'
                    }).then((res) => {
                        if (result.value) {
                            if(callback){
                                location.href = callback;
                            }else{
                                location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                            }
                        }
                    })
                }).fail(function(response) {
                            // console.log(response);
                            if(response.responseJSON.status == false){
                                Swal.fire({
                                type: 'info',
                                title: 'Data Tidak Berhasil Di '+confirmTitle+' !',
                                text: 'Data Tidak Ditemukan',
                                button: true,
                                confirmButtonText:'Tutup',
                                confirmButtonColor:'#0BB7AF'
                            }).then((res) => {
                                if (result.value) {
                                    if(callback){
                                        location.href = callback;
                                    }else{
                                        location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                                    }
                                }
                            })
                        }else{
                            Swal.fire({
                            type: 'error',
                            title: 'Data Tidak Berhasil Di '+confirmTitle+' !',
                            text: 'Sepertinya ada kesalahan',
                            button: true,
                            confirmButtonText:'Close',
                            confirmButtonColor:'#0BB7AF'
                        }).then((res) => {
                            if (result.value) {
                                if(callback){
                                    location.href = callback;
                                }else{
                                    location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                                }
                            }
                        })
                    }
                })

            }
        })
    }

    // DYNAMIC SHOW MODAL
    function loadModal(param, callback) {

        var url = (typeof param['url'] === 'undefined') ? '#' : param['url'];
        var modal = (typeof param['modal'] === 'undefined') ? 'mediumModal' : param['modal'];
        var formId = (typeof param['formId'] === 'undefined') ? 'formData' : param['formId'];
        var onShow = (typeof callback === 'undefined') ? function () {} : callback;
        var modals = $(modal);

        $.ajax({
            url: url,
            type: 'GET',
        })
        .done(function(response){
            modals.modal('show');
            modals.off('shown.bs.modal');
            modals.find('.modal-content').empty();

            modals.on('shown.bs.modal', function (event) {
                event.preventDefault();
                modals.find('.modal-content').html(response);
                $('.modal-backdrop').remove()
                onShow();
            });
        })
        .fail(function(response){
            if(response.status == 401){
                Swal.fire({
                  type: 'info',
                  title: "Sorry Your's Session Has Expired",
                  text: 'Please to Re-login',
                  button: true,
                  confirmButtonText:'Close',
                  confirmButtonColor:'#0BB7AF'
              }).then((res) => {
                if (res.value) {
                    location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                }
            })
          }
      })
    } 

    // DYNAMIC SAVE DATA
    function saveData(formid, callback) {

        $('#'+formid).append(`
            <div class="loadings" >Loading&#8230;</div>
        `);
        $("#" + formid).ajaxSubmit({
            success: function (resp) {
                console.log('resp', resp)
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

            },
            error: function (resp) {
                console.log('resp',resp)
                $('.loadings').hide();
                var response = resp.responseJSON;
                var addErr = {};

                if(resp.responseJSON && resp.responseJSON.error){
                    $.each(response.error, function (index, val) {

                        var response = resp.responseJSON;
                        if (index.includes(".")) {
                            res = index.split('.');
                            index = '';
                            for (i = 0; i < res.length; i++) {
                                if (i == 0) {
                                    res[i] = res[i];
                                } else {
                                    if (res[i] == 0) {
                                        res[i] = '\\[\\]';
                                    } else {
                                        res[i] = '[' + res[i] + ']';
                                    }
                                }
                                index += res[i];
                            }
                        }
                        clearFormError(index,val,formid);

                        var name = index.split('.').reduce((all, item) => {
                            all += (index == 0 ? item : '[' + item + ']');
                            return all;
                        });
                        var fg = $('[name="' + name + '"], [name="' + name + '[]"]').closest('.form-group');

                        fg.addClass('has-error');

                        fg.append('<small class="control-label error-label font-bold">' + val + '</small>')
                    });

                    $("html, body").animate({ scrollTop: 0 }, "slow");

                    Swal.fire({
                    type: 'info',
                    title: 'Terjadi Kesalahan',
                    html: showBoxValidation(resp),
                });
                }else{
                    Swal.fire({
                    type: 'info',
                    title: 'Terjadi Kesalahan',
                    html: showBoxValidation(resp),
                });
                }
                
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

    // DYNAMIC SAVE DATA
    function saveModalData(formid, callback, url) {
        $('#'+formid).append(`
            <div class="loadings" >Loading&#8230;</div>
        `);
        Swal.fire({
            title: "Simpan Data",
            text: "Apakah Anda Akan Melanjutkan Ke Hasil UT ?",
            type: "question",
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan Hasil UT',
            confirmButtonColor:'#0BB7AF',
            cancelButtonText: 'Simpan Tetap Di Halaman',
            reverseButtons: true
        }).then((resultModal) => {
            $('.loadings').remove();
            console.log('resultModal',resultModal)
            var dataUrlCallback = '';
            if(resultModal.value){
                dataUrlCallback = 'true';
                $('[name="urlCallback"]').val('true')
            }else if(resultModal.dismiss == 'cancel'){
                dataUrlCallback = 'true';
                $('[name="urlCallback"]').val('false')
            }else if(resultModal.dismiss == 'backdrop'){
                dataUrlCallback = 'false';
                $('[name="urlCallback"]').val('backdrop')
            }
            console.log('dataUrlCallback',dataUrlCallback)
            if(dataUrlCallback == 'true'){
                $("#" + formid).ajaxSubmit({
                    success: function (resp) {
                        Swal.fire({
                            type: 'success',
                            title: 'Sukses',
                            text: 'Proses penyimpan data berhasil',
                            confirmButtonText:'<i class="fa fa-thumbs-up"></i> Kembali !',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                            // footer: '<a href>Why do I have this issue?</a>'
                        }).then(function(){
                            // console.log('resultModal',resultModal)
                            if(callback != null){
                                window.location.reload();
                            }else{
                                if(resp.url){
                                    location.href  = resp.url;
                                }else{
                                    location.href  = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                                }
                            }
                        });
                    },
                    error: function (resp) {
                        console.log('resp',resp)
                        $('.loadings').hide();
                        var response = resp.responseJSON;
                        var addErr = {};

                        if(resp.responseJSON && resp.responseJSON.errors){
                            $.each(response.errors, function (index, val) {

                                var response = resp.responseJSON;
                                if (index.includes(".")) {
                                    res = index.split('.');
                                    index = '';
                                    for (i = 0; i < res.length; i++) {
                                        if (i == 0) {
                                            res[i] = res[i];
                                        } else {
                                            if (res[i] == 0) {
                                                res[i] = '\\[\\]';
                                            } else {
                                                res[i] = '[' + res[i] + ']';
                                            }
                                        }
                                        index += res[i];
                                    }
                                }
                                clearFormError(index,val,formid);

                                var name = index.split('.').reduce((all, item) => {
                                    all += (index == 0 ? item : '[' + item + ']');
                                    return all;
                                });
                                var fg = $('[name="' + name + '"], [name="' + name + '[]"]').closest('.form-group');

                                fg.addClass('has-error');

                                fg.append('<small class="control-label error-label font-bold" style="margin-top: 0.25rem;font-size: smaller;color: #ea5455;">' + val + '</small>')
                            });

                            $("html, body").animate({ scrollTop: 0 }, "slow");

                            Swal.fire({
                                type: 'info',
                                title: 'Terjadi Kesalahan',
                                html: showBoxValidation(resp),
                            });
                        }else{
                            Swal.fire({
                            type: 'info',
                            title: 'Terjadi Kesalahan',
                            html: showBoxValidation(resp),
                        });
                        }
                        
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
        });
    }

    // DELETED DATA
    function deleteData(url, callback) 
    {
        Swal.fire({
            title: "Apakah Anda Yakin Akan Menghapus Data?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data!",
            type: "question",
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            confirmButtonColor:'#0BB7AF',
            cancelButtonText: 'Tidak, Batalkan!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method' : 'DELETE',
                        '_token' : '{{ csrf_token() }}'
                    }
                })
                .done(function(response) {
                    Swal.fire({
                      type: 'success',
                      title: 'Terhapus',
                      text: 'Data Berhasil Dihapus!',
                      button: true,
                      confirmButtonText:'Tutup',
                      confirmButtonColor:'#0BB7AF'
                  }).then((res) => {
                    if (result.value) {
                        if(callback){
                            location.href = callback;
                        }else{
                            location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                        }
                    }
                })
              })
                .fail(function(response) {
                    // console.log(response);
                    if(response.responseJSON.status == false){
                        Swal.fire({
                          type: 'info',
                          title: 'Data Tidak Berhasil Dihapus !',
                          text: 'Data sedang digunakan di modul lain',
                          button: true,
                          confirmButtonText:'Tutup',
                          confirmButtonColor:'#0BB7AF'
                      }).then((res) => {
                        if (result.value) {
                            if(callback){
                                location.href = callback;
                            }else{
                                location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                            }
                        }
                    })
                  }else{
                    Swal.fire({
                      type: 'error',
                      title: 'Data Tidak Berhasil Dihapus !',
                      text: 'Sepertinya ada kesalahan',
                      button: true,
                      confirmButtonText:'Close',
                      confirmButtonColor:'#0BB7AF'
                  }).then((res) => {
                    if (result.value) {
                        if(callback){
                            location.href = callback;
                        }else{
                            location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                        }
                    }
                })
              }
          })

            }
        })
    }

    // SEND NOTIF
    function sendNotif(url, callback){
        Swal.fire({
            title: "Notifikasi Email",
            text: "Apakah Anda Ingin Memberikan Pemberitahuan Kepada Cabang Untuk Mengisi ERESDA!",
            type: "question",
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim Pesan',
            confirmButtonColor:'#0BB7AF',
            cancelButtonText: 'Tidak, Batalkan!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_token' : '{{ csrf_token() }}',
                    }
                })
                .done(function(response) {
                    Swal.fire({
                      type: 'success',
                      title: 'Terkirim',
                      text: 'Notifikasi Berhasil Dikirim!',
                      button: true,
                      confirmButtonText:'Tutup',
                      confirmButtonColor:'#0BB7AF'
                  })
                })
                .fail(function(response) {
                    if(response.responseJSON.status == false){
                        Swal.fire({
                          type: 'info',
                          title: 'Notifikasi Gagal Dikirim !',
                          text: 'Silahkan Coba Beberapa Saat Lagi',
                          button: true,
                          confirmButtonText:'Tutup',
                          confirmButtonColor:'#0BB7AF'
                      });
                  }else{
                    Swal.fire({
                      type: 'error',
                      title: 'Notifikasi Gagal Terkirim !',
                      text: 'Galat Jaringan',
                      button: true,
                      confirmButtonText:'Close',
                      confirmButtonColor:'#0BB7AF'
                  })
              }
          })

            }
        })
    }

    

    var modal = '#mediumModal';
   
    var onShow = function () {
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Pilih Data"
        });
        $('.pickadate').pickadate({
            format: 'yyyy-mm-dd',
            selectYears: 100,
            selectMonths: true
        });
        
        // $('.datetimepicker').datetimepicker({
        //     format:'yyyy-mm-DD hh:mm',
        //     useCurrent: false,
        //     autoclose: true
        // });
        $('.dropify').dropify();

        $('.summernote').summernote({
            height : 240,
            maximumImageFileSize: 409715,
            lineHeight : 10,
            fontSizes: ['8', '9', '10', '11', '12', ,'13', '14', '15', '16', '17', '18'],
            fontName: 'Arial',
            toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ],
            callbacks: {
              onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();

                  // Firefox fix
                  setTimeout(function () {
                    document.execCommand('insertText', false, bufferText);
                }, 10);
              },
              onImageUpload: function(image) {
                  uploadImage(image[0]);
              }
          }
      });
    };

    // SHOW ERROR
    function showBoxValidation(resp, message){
        var temp = ``;
        if(resp.statusText = 'Unprocessable Entity'){
            if(resp.data.name == 'SequelizeValidationError'){
                console.log('if')
                temp += `<div class="sidebar-widget wow fadeInUp outer-top-vs animated" style="visibility: visible; animation-name: fadeInUp;">
                <center><h3 class="section-title "><b>Incomplete Data Input</b></h3></center>
                </div>
                <div class="sidebar-widget-body">
                    <div class="compare-report">
                        <ul class="list text-left bold" style="font-size:16px;list-style:inside;">`;
                if(resp.data){
                    if(resp.data.errors){
                        var data = resp.data.errors;
                        $.each(data,function(key,value){
                            temp += `<li><small>`+value.message+ `</small></li>`;
                        });
                    }
                }
                temp += `</ul></div></div>`;
            }else{
                console.log('else')
                temp += `<div class="sidebar-widget wow fadeInUp outer-top-vs animated" style="visibility: visible; animation-name: fadeInUp;">
                    <center><h3 class="section-title "><b>Incomplete Data Input</b></h3></center>
                    </div>
                    <div class="sidebar-widget-body">
                        <div class="compare-report">
                            <ul class="list text-left bold" style="font-size:16px;list-style:inside;">`;
                if($.isArray(resp.data)){
                    if(resp.data){
                        var data = resp.data;
                        $.each(data,function(key,value){
                            temp += `<li><small>`+value.error+ `</small></li>`;
                        });
                    }
                }else{
                    if(resp.data == 'invalid input syntax for type uuid: ""'){
                        temp += `<li><small>Silahkan Input Data Keseluruhan</small></li>`;
                    }else{
                        temp += `<li><small>`+resp.data+ `</small></li>`;
                    }
                }
                temp += `</ul></div></div>`;
            }
        }else{
            console.log('resp.data.name', resp.data.name)
            if(resp.data.name == 'SequelizeValidationError'){
                temp += `<div class="sidebar-widget wow fadeInUp outer-top-vs animated" style="visibility: visible; animation-name: fadeInUp;">
                <center><h3 class="section-title "><b>Incomplete Data Input</b></h3></center>
                </div>
                <div class="sidebar-widget-body">
                    <div class="compare-report">
                        <ul class="list text-left bold" style="font-size:16px;list-style:inside;">`;
                if(resp.data){
                    if(resp.data.errors){
                        var data = resp.data.errors;
                        $.each(data,function(key,value){
                            temp += `<li><small>`+value.message+ `</small></li>`;
                        });
                    }
                }
                temp += `</ul></div></div>`;
            }else{
                temp += `<div class="sidebar-widget wow fadeInUp outer-top-vs animated" style="visibility: visible; animation-name: fadeInUp;">
                    <center><h3 class="section-title "><b>Incomplete Data Input</b></h3></center>
                    </div>
                    <div class="sidebar-widget-body">
                        <div class="compare-report">
                            <ul class="list text-left bold" style="font-size:16px;list-style:inside;">`;
                temp += `<li><small>`+resp.data+ `</small></li>`;
                temp += `</ul></div></div>`;
            }
        }
        return temp;
    }

    function upperCase(data){
        var result = data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        return result;
    }

    function showFormError(key, value) {
        if (key.includes(".")) {
            res = key.split('.');
            key = res[0] + '[' + res[1] + ']';
            if (res[1] == 0) {
                key = res[0] + '\\[\\]';
            }
            if (res[2]) {
                key = res[0] + '[' + res[1] + ']' + '[' + res[2] + ']';
                if (res[2] == 0) {
                    key = res[0] + '[' + res[1] + ']' + '\\[\\]';
                }
            }
            if (res[3]) {
                key = res[0] + '[' + res[1] + ']' + '[' + res[2] + ']' + '[' + res[3] + ']';
                if (res[3] == 0) {
                    key = res[0] + '[' + res[1] + ']' + '\\[\\]';
                }
            }
        }
        var elm = $("#dataForm").find('[name="' + key + '"]').closest('.field');
        $(elm).addClass('error');
        
        var message = `<div class="ui basic red pointing prompt label transition visible">` + value + `</div>`;

        var showerror = $("#dataForm").find('[name="' + key + '"]').closest('.field');
        $(showerror).append('<div class="ui basic red pointing prompt label transition visible">' + value + '</div>');
    }

    function clearFormError(key, value, formData) {
        if (key.includes(".")) {
            res = key.split('.');
            key = res[0] + '[' + res[1] + ']';
            if (res[1] == 0) {
                key = res[0] + '\\[\\]';
            }
            // 
        }
        var elm = $("#" + formData).find('[name="' + key + '"]').closest('.form-group');
        $(elm).removeClass('has-error');
        var showerror = $("#" + formData).find('[name="' + key + '"]').closest('.form-group').find('.control-label.error-label.font-bold').remove();
    }
    // END SHOW ERROR

    function changeFormatDate(data){
        var  tgl= new Date(data);
        if(tgl){
            var year = tgl.getFullYear();
            var month = new Array();
            month[0] = "Januari";
            month[1] = "Februari";
            month[2] = "Maret";
            month[3] = "April";
            month[4] = "Mei";
            month[5] = "Juni";
            month[6] = "Juli";
            month[7] = "Agustus";
            month[8] = "September";
            month[9] = "Oktober";
            month[10] = "November";
            month[11] = "Desember";
            var month = month[tgl.getMonth()];
            var day = tgl.getDate();
            return  day + ' ' + month + ' ' + year; 
        }else{
            return '';
        }

    }
    function changeFormatDateWithHours(data){
        var  tgl= new Date(data);
        if(tgl){
            var year = tgl.getFullYear();
            var month = new Array();
            month[0] = "Januari";
            month[1] = "Februari";
            month[2] = "Maret";
            month[3] = "April";
            month[4] = "Mei";
            month[5] = "Juni";
            month[6] = "Juli";
            month[7] = "Agustus";
            month[8] = "September";
            month[9] = "Oktober";
            month[10] = "November";
            month[11] = "Desember";
            var month = month[tgl.getMonth()];
            var day = tgl.getDate();
            var hour = tgl.getHours();
            var minutes = tgl.getMinutes();
            return  day + ' ' + month + ', ' + year +'<br/>'+ hour + '.' +minutes; 
        }else{
            return '';
        }

    }

    function fromNow(date, type = "YYYYMMDDhmmss"){
        return moment(date, type).fromNow();
    }

    function showLoadingInput(elemchild) {
        var loading = `<div class="ui active mini centered inline loader"></div>`;

        $('#' + elemchild).parent().closest('.field').addClass('disabled');
        $('#' + elemchild).parent().closest('.field').append(loading);
    }

    function stopLoadingInput(elemchild) {
        $('#' + elemchild).parent().closest('.field').removeClass('disabled');
        $('#' + elemchild).parent().closest('.field').find('.inline.loader').remove();
    }

    function convertToRupiah(angka)
    {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            var hasil = ''+rupiah.split('',rupiah.length-1).reverse().join('');
        if(hasil == 'NaN'){
            hasil = '';
        }
        return angka.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    }

    function convertToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

    // GLOBAL FUNCTION CHECK IMG
    function checkImg(url){
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return (http.status!=404) ? url : "{{ asset('no-images.png') }}";
    }

    //pickdate
    $('.pickadate').pickadate({
        format: 'yyyy-mm-dd',
        selectYears: 100,
        selectMonths: true
    });

    //Capital
    $('.capital').keyup(function() {
        var v = $(this).val();
        var u = v.toUpperCase();
        if( v != u ) $(this).val( u );
    })


    $(".numberonly").keyup(function(e) {
        if (/\D/g.test(this.value))
        {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
}
});

    // DYNAMIC Multiple Input SELECT
    $(document).on('change', '.box1,.box2,.box3', function () {

        var append = $(this).data('append');
        var append2 = $(this).data('append2');
        console.log($(this).data('append'))
        console.log($(this).data('append2'))
        if(append != null && append2 ==null){
           var append = $(this).data('append');
           var value = $(this).val();
           if (value != null) {
            $.ajax({
                url: '{{ url("option") }}/' + append + '/' + value,
                type: 'GET',
                success: function (resp) {
                    $('#' + append).html(resp);
                },
                error: function (resp) {
                }
            });
        }
    }else if(append==null && append2 != null){
        var append = $(this).data('append2');
        var package = document.getElementById("package").value;
        var subpackage = document.getElementById("subpackage").value;

        if (package != null && subpackage != null) {
            $.ajax({
                url: '{{ url("option") }}/' + append2 + '/' + package + '/' + subpackage,
                type: 'GET',
                success: function (resp) {
                    $('#' + append2).html(resp);
                },
                error: function (resp) {
                }
            });
        }
    }
    
}); 


</script>
