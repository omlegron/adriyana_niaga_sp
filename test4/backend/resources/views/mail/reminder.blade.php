
@extends('mail.panels.index')

@section('styles')
@endsection

@section('toolbars')
@endsection

@section('content')
    <div class="container py-8">
        <p>
            Hi, {{ @$user->email }}
        </p>

        <p>
            Silahkan Mengisi Data Kapal {{ @$record->kapal->name }} - {{ @$record->year }}. Dihalaman ERESDA<br>
            Data Kapal Tersebut Belum Terisi Secara Keseluruhan
            <br>
            <a href="{{ url('input-data-cluster?id='.@$record->formInputID) }}" style="color: white">LINK</a>
        </p>

        <p>
            Thank You,
            <br>
            Regards,
            <br>
            <br>
                <b>Eresda-Noreply</b>
            <br>
            <br>
                <b>PT. ASDP Indonesia Ferry.</b>
            <br>
        </p>
    </div>
@endsection