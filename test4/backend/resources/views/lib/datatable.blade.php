<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script nonce="{{ csp_nonce() }}" src="{{ asset('assets3/plugins/custom/datatables/datatables.bundle.js') }}"></script>

{{-- <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/plugins/custom/datatables/datatables.min.js') }}"></script> --}}

{{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
<script nonce="{{ csp_nonce() }}">
  function loadList(dataList = [], addButton = [], applyShowButton = true, classTable = '#listTables', page_url = null) {
    if(!page_url){
      @if(@$route)
        var page_url = "{{ (@$routeList) ? url($routeList).'/list' : route($route.'.list') }}";
      @endif
    }
    console.log('page_url', page_url)

    

    if(applyShowButton === true){
      var showButtons = [
        {
          extend: 'excelHtml5',
          text: "<i class='flaticon2-file'></i> Export Excel",
          className: "btn buttons-excel btn btn-light-success font-weight-bold mr-2 buttons-html5",
          // "action": newexportaction,
          exportOptions: {
            columns: [ 0, ':visible' ]
          }
        },
        {
          extend: 'csvHtml5',
          text: "<i class='flaticon2-layers'></i> Export Csv",
          className: "btn buttons-csv btn btn-light-success font-weight-bold mr-2 buttons-html5",
          // "action": newexportaction,
          exportOptions: {
            columns: [ 0, ':visible' ]
          }
        }
      ];
    }else{
      var showButtons = [];
    }
    
    showButtons = $.merge(showButtons,addButton);

    var table = $(classTable).DataTable({
      processing: true,
      serverSide: true,
      responsive: false,
      autoWidth: false,
      scrollX: true,
      scrollY: 400,
      scrollCollapse: true,
      fixedHeader:true,
      lengthChange: false,
      filter: true,
      deferRender: true,
      language: {
        "emptyTable": "Tidak ada Data yang tersedia",
        "sSearch" : "Cari",
        "info": "Menampilkan _PAGES_ Halaman dari _TOTAL_ Data",
        "sProcessing" : "Sedang Memproses",
        "infoEmpty": "Data Tidak Tersedia",
      },
      ajax: {
        headers: {
            Accept: "application/json, text/javascript, */*; q=0.01",
            'Authorization': 'Bearer ' + "{{ (\Auth::check()) ? auth()->user()->getToken() : '' }}"
        },
        url: page_url,
        data: function (d) {
         d._token = "{{ csrf_token() }}";
         $('.filter-control').each(function(idx, el) {
          var name = $(el).data('post');
          var val = $(el).val();
          d[name] = val;
        })
       }
     },
     columns: dataList,
     dom: 'Bfrtip',
     buttons: showButtons,
      initComplete: function (settings, json) {
        $(".dt-buttons .btn").removeClass("btn-secondary")
      },
      drawCallback: function(row, data) {
        var api = this.api();

      }
    });

    // table.on( 'search.dt', function () {
    //   table.draw();
    // });

    $('.group-checkable').on('change',function() {
      $('.removeAll').prop('checked', true);
      var set = $(this).closest('table').find('td:first-child .removeAll');
      var checked = $(this).is(':checked');
      if (checked) {
        $(this).prop('checked', true);
        $('.removeAll').prop('checked', true);
      }else {
        $(this).prop('checked', false);
        $('.removeAll').prop('checked', false);
        
      }
    });

    $('.filter-data').on('click', function(e) {
      table.draw();
    });

    $('.clear').on('click', function(e) {
      $(".filter-control").val('');
      table.draw();
    });
  }


  function loadList2(dataList = [], addButton = [], applyShowButton = true, classTable = '#listTables', page_url = null) {
    console.log('page_url2', page_url)

    if(!page_url){
      @if(@$route)
        var page_url = "{{ (@$routeList) ? url($routeList).'/list' : route($route.'.list') }}";
      @endif
    }
    

    if(applyShowButton === true){
      var showButtons = [
        {
          extend: 'excelHtml5',
          text: "<i class='flaticon2-file'></i> Export Excel",
          className: "btn buttons-excel btn btn-light-success font-weight-bold mr-2 buttons-html5",
          // "action": newexportaction,
          exportOptions: {
            columns: [ 0, ':visible' ]
          }
        },
        {
          extend: 'csvHtml5',
          text: "<i class='flaticon2-layers'></i> Export Csv",
          className: "btn buttons-csv btn btn-light-success font-weight-bold mr-2 buttons-html5",
          // "action": newexportaction,
          exportOptions: {
            columns: [ 0, ':visible' ]
          }
        },
        {
          text: "<i class='flaticon2-paper'></i> Hapus Data Terpilih",
          className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
          action: function () {
            removeSelect()
          }
        }
      ];
    }else{
      var showButtons = [];
    }
    
    showButtons = $.merge(showButtons,addButton);

    var table2 = $(classTable).DataTable({
      processing: true,
      serverSide: true,
      responsive: false,
      autoWidth: false,
      scrollX: true,
      scrollY: 400,
      scrollCollapse: true,
      fixedHeader:true,
      lengthChange: false,
      filter: true,
      deferRender: true,
      language: {
        "emptyTable": "Tidak ada Data yang tersedia",
        "sSearch" : "Cari",
        "info": "Menampilkan _PAGES_ Halaman dari _TOTAL_ Data",
        "sProcessing" : "Sedang Memproses",
        "infoEmpty": "Data Tidak Tersedia",
      },
      ajax: {
        headers: {
            Accept: "application/json, text/javascript, */*; q=0.01",
            'Authorization': 'Bearer ' + "{{ (\Auth::check()) ? auth()->user()->getToken() : '' }}"
        },
        url: page_url,
        data: function (d) {
         d._token = "{{ csrf_token() }}";
         $('.filter-control2').each(function(idx, el) {
          var name = $(el).data('post');
          var val = $(el).val();
          d[name] = val;
        })
       }
     },
     columns: dataList,
     dom: 'Bfrtip',
     buttons: showButtons,
      initComplete: function (settings, json) {
        $(".dt-buttons .btn").removeClass("btn-secondary")
      },
      drawCallback: function(row, data) {
        var api = this.api();

      }
    });

    // table.on( 'search.dt', function () {
    //   table.draw();
    // });

    $('.group-checkable').on('change',function() {
      $('.removeAll').prop('checked', true);
      var set = $(this).closest('table').find('td:first-child .removeAll');
      var checked = $(this).is(':checked');
      if (checked) {
        $(this).prop('checked', true);
        $('.removeAll').prop('checked', true);
      }else {
        $(this).prop('checked', false);
        $('.removeAll').prop('checked', false);
        
      }
    });

    $('.filter-data2').on('click', function(e) {
      table2.draw();
    });

    $('.clear2').on('click', function(e) {
      $(".filter-control2").val('');
      table2.draw();
    });
  }



    
  function removeSelect(){
    var removeAll = $('.removeAll').serializeArray();

    if(removeAll.length == 0){
      Swal.fire({
        type: 'info',
        title: 'Tidak terdapat data yang mau di hapus  !',
        text: 'Silahkan pilih data terlebih dahulu',
        button: true,
        confirmButtonText:'Tutup',
        confirmButtonColor:'#0BB7AF'
      })
    }else{
      Swal.fire({
        title: "Anda Yakin Untuk Menghapus Data?",
        text: "Setelah dihapus, Anda tidak akan dapat memulihkan data!",
        type: "question",
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus ini!',
        confirmButtonColor:'#F64E60',
        cancelButtonText: 'Tidak, Batalkan!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          var valueUuid = removeAll.map(function(value){
            return value.value
          })
          $.ajax({
            url: "{{ (@$route) ? $route.'/removeMulti' : '' }}",
            type: 'POST',
            data: {
              '_method' : 'DELETE',
              '_token' : '{{ csrf_token() }}',
              'id' : valueUuid
            }
          })
          .done(function(response) {
            Swal.fire({
              type: 'success',
              title: 'Terhapus',
              text: 'Data berhasil dihapus!',
              button: true,
              confirmButtonText:'Tutup',
              confirmButtonColor:'#0BB7AF'
            }).then((res) => {
              if (result.value) {
                location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
              }
            })
          })
          .fail(function(response) {
            console.log(response);
            if(response.responseJSON && response.responseJSON.status == false){
              Swal.fire({
                type: 'info',
                title: 'Penghapusan data gagal !',
                text: 'data sedang digunakan oleh modul lain',
                button: true,
                confirmButtonText:'Tutup',
                confirmButtonColor:'#0BB7AF'
              }).then((res) => {
                if (result.value) {
                  location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                }
              })
            }else{
              Swal.fire({
                type: 'error',
                title: 'Penghapusan data gagal !',
                text: 'Terjadi Kesalahan Sistem',
                button: true,
                confirmButtonText:'Tutup',
                confirmButtonColor:'#0BB7AF'
              }).then((res) => {
                if (result.value) {
                  location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                }
              })
            }
          })

        }
      })
    }
  }

  function newexportaction(e, dt, button, config) {
    console.log('asdasd')
      var self = this;
      var oldStart = dt.settings()[0]._iDisplayStart;
      dt.one('preXhr', function (e, s, data) {
          // Just this once, load all data from the server...
          data.start = 0;
          data.length = 2147483647;
          dt.one('preDraw', function (e, settings) {
            console.log('button[0]',button[0])
              // Call the original action function
              if (button[0].className.indexOf('buttons-copy') >= 0) {
                  $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                  $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                      $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                      $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                  $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                      $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                      $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                  $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                      $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                      $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-print') >= 0) {
                  $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
              }
              dt.one('preXhr', function (e, s, data) {
                  // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                  // Set the property to what it was before exporting.
                  settings._iDisplayStart = oldStart;
                  data.start = oldStart;
              });
              // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
              setTimeout(dt.ajax.reload, 0);
              // Prevent rendering of the full data to the DOM
              return false;
          });
      });
      // Requery the server with the new one-time export settings
      dt.ajax.reload();
  }

</script>