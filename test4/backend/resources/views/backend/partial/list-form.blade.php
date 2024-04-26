
<div class="card card-custom mb-5">
 <div class="card-header card-header-right ribbon ribbon-clip ribbon-left">
  <div class="ribbon-target" style="top: 12px;">
    <span class="ribbon-inner bg-success"></span>{{ $title }}
  </div>
</div>
<div class="card-body">
  <div class="appendData" style="max-height: 350px;overflow-y: initial;">
    <div class="row totalData" data-no="0">
      <div class="col-md-10">
        <div class="form-group">
          <label>{{ $title }}</label>
          <input type="text" class="form-control" name="" required placeholder="Pendapatan Daerah" value="*Pendapatan Daerah" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="btn btn-icon btn-success mr-1 mb-1 waves-effect waves-light addData" style="margin-top:25px"><i class="flaticon-add-circular-button"></i></div>
      </div>

    </div>
    @if($records)
    @if(count($records) > 0)
    @foreach($records as $k => $value)
    @foreach($value as $v => $val)

    <div class="row totalData" data-no="{{$v+1}}" id="data{{$v+1}}">
     <div class="col-md-10">
      <input type="hidden" name="sub[id][{{ $v+1 }}]" value="{{ $val->id }}">
      <div class="form-group">
        <label>{{ __('Title Meta') }}</label>
        <input type="text" class="form-control" name="sub[{{ $attribute }}][{{ $v+1 }}]" required placeholder="Title Meta" value="{{$val->title}}" placeholder="sub[{{ $attribute }}]{{ $v+1 }}">
      </div>
    </div>
    <div class="col-md-2">
      <div class="btn btn-icon btn-success waves-effect waves-light addData" style="margin-top:25px"><i class="flaticon-add-circular-button"></i></div>
      <div class="btn btn-icon btn-danger waves-effect waves-light deleteData" style="margin-top:25px" data-length="data{{$v+1}}" data-id="{{ $val->id }}"><i class="flaticon-close" ></i></div>
    </div>
  </div>
  @endforeach
  @endforeach
  @endif
  @endif
  <div class="appendDelete">
    
  </div>
</div> 
</div>
</div>

<script nonce="{{ csp_nonce() }}" type="text/javascript">
 $(document).on('click','.addData',function(){
  var no = $('.totalData:last').data('no')+1;
  console.log('no',no)
  $('.appendData').append(`
    <div class="row totalData" data-no="`+no+`" id="data`+no+`">
    <div class="col-md-10">
    <div class="form-group">
    <label>{{ __('Title Meta') }}</label>
    <input type="text" class="form-control" name="sub[{{ $attribute }}][`+no+`]" required placeholder="Title Meta" >
    </div>
    </div>
    <div class="col-md-2">
    <div class="btn btn-icon btn-success waves-effect waves-light addData" style="margin-top:25px"><i class="flaticon-add-circular-button"></i></div>
    <div class="btn btn-icon btn-danger waves-effect waves-light deleteData" style="margin-top:25px" data-length="data`+no+`"><i class="flaticon-close" ></i></div>
    </div>
    </div>
    `);
});

$(document).on('click','.deleteData',function(){
  var dataDel = $(this).data('length');
  var dataId = $(this).data('id');
  $('.appendDelete').append(`
    <input type="hidden" name="[idDel][]" value="`+dataId+`">
  `)
  $('#'+dataDel).remove();
});

</script>
