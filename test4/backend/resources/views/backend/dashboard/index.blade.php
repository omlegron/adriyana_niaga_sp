@extends('layouts/app')

@section('styles')

@endsection

@section('toolbars')
<a href="#" class="btn btn-light-warning font-weight-bolder btn-sm add-modal" data-modal="#xlarge">Tambah Data</a>
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_4">
        <div class="card-header">
                <div class="card-title">
                        <h3 class="card-label">Kelola Data
                                <span class="text-muted pt-2 font-size-sm d-block">Laporan Data </span></h3>
                </div>
                <div class="card-toolbar">
                        <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
                            <i class="ki ki-arrow-down icon-nm"></i>
                        </a>
                </div>
        </div>
		<div class="card-body">
			<div class="card-body pt-4 table-responsive" >
				<nav><b>Filter Data</b></nav>
				<form action="#" method="GET" target="_blank" id="getPdf" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="name" class="">{{ __('Nim Mahasiswa') }}</label>
								<input type="text" class="form-control filter-control" data-post="nim" id="dataFilter" autofocus placeholder="Nim Mahasiswa" maxlength="50">
							</div>
						</div>

						<div class="col-12 col-sm-4 col-lg-4">
							<label for="users-list-role">Nama Mahasiswa</label>
							<fieldset class="form-group">
								<select data-post="mahasiswaId" id="dataFilter" class="form-control filter-control" >
									<option value="">Pilih Salah Satu</option>
									@if(count($dataMhs) > 0)
										@foreach($dataMhs as $k => $value)
											<option value="{{ $value->uuid }}">{{ $value->name }}</option>
										@endforeach
									@endif
								</select>
							</fieldset>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="name" class="">{{ __('Kode Buku') }}</label>
								<input type="text" class="form-control filter-control" data-post="kode" id="dataFilter" autofocus placeholder="Kode Buku" maxlength="50">
							</div>
						</div>

						<div class="col-12 col-sm-4 col-lg-4">
							<label for="users-list-role">Buku</label>
							<fieldset class="form-group">
								<select data-post="bukuId" id="dataFilter" class="form-control filter-control" >
									<option value="">Pilih Salah Satu</option>
									@if(count($dataBuku) > 0)
										@foreach($dataBuku as $k => $value)
											<option value="{{ $value->uuid }}">{{ $value->name }}</option>
										@endforeach
									@endif
								</select>
							</fieldset>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="name" class="">{{ __('Tanggal Peminjaman') }}</label>
								<input type="date" class="form-control filter-control" data-post="tanggalPinjam" id="dataFilter" required autofocus placeholder="Tanggal Peminjaman" maxlength="50">
							</div>
						</div>
			
						<div class="col-md-4">
							<div class="form-group">
								<label for="name" class="">{{ __('Tanggal Pemulangan') }}</label>
								<input type="date" class="form-control filter-control" data-post="tanggalKembali" id="dataFilter" required autofocus placeholder="Tanggal Pemulangan" maxlength="50">
							</div>
						</div>
			
						<div class="col-md-4">
							<div class="form-group">
								<label for="name" class="">{{ __('Lama Hari') }}</label>
								<input type="text" class="form-control filter-control" data-post="lamaPinjam" id="dataFilter" autofocus placeholder="Lama Hari" maxlength="50">
							</div>
						</div>
			
						<div class="col-md-4">
							<div class="form-group">
								<label for="name" class="">{{ __('Status Pinjam') }}</label>
								<select data-post="status" id="dataFilter" class="form-control filter-control">
									<option value=""> Pilih Salah Satu</option>
									<option value="0">Dipinjam</option>
									<option value="1">Dikembalikan</option>
								</select>
							</div>
						</div>
					</div>
					<button type="button" class="btn btn-secondary clear" >
						<i class="flaticon-circle"></i>
						Bersihkan
					  </button>
					  <button type="button" class="btn btn-light-primary filter-data">
						<i class="flaticon-search"></i>
						Cari Data
					  </button>
				</form>
			</div>
		</div>
		<div class="card-body">
			<div class="card-body pt-4 table-responsive" >
			  <table class="table data-thumb-view table-striped" id="listTables">
				<thead>
				  <tr>
				   
					<th>#</th>
					<th>Nim</th>
					<th>Nama Peminjam</th>
					<th>Kode Buku</th>
					<th>Nama Buku</th>
					<th>Tanggal Pinjam</th>
					<th>Tanggal Pemulangan</th>
					<th>Lama Hari</th>
					<th>Status Pinjam</th>
					<th>Aksi</th>
				  </tr>
				</thead>
			  </table>
			</div>
		 </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ csp_nonce() }}">
	$(document).ready(function () {
	  loadList([
		{ data:'DT_RowIndex', name:'DT_RowIndex', searchable: false,orderable: false  },
		{ data:'nim', name:'nim' },
		{ data:'name', name:'name' },
		{ data:'kode', name:'kode' },
		{ data:'namaBuku', name:'namaBuku' },
		{ data:'tanggalPinjam', name:'tanggalPinjam' },
		{ data:'tanggalKembali', name:'tanggalKembali' },
		{ data:'lamaPinjam', name:'lamaPinjam' },
		{ data:'status', name:'status' },
		{ data:'action', name: 'action', searchable: false,orderable: false }
	  ]);
	});
  </script>
@endsection
        