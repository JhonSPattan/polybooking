@extends('layout/adminlayout')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">

        <div class="card-body">
            <div class="card-title">เพิ่มห้อง</div>
            <p class="card-description">
                เพิ่มห้องประชุม
            </p>
            <form class="forms-sample"  action="/room/save" method="post" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="roomnameInput">ชื่อห้อง</label>
                    <input type="text" class="form-control" id="roomnameInput" name="roomName" placeholder="ระบุชื่อห้อง">
                </div>
                <input type="submit" class="btn btn-primary" value="เพิ่มห้อง">
            </form>
        </div>


    </div>
</div>
@endsection
