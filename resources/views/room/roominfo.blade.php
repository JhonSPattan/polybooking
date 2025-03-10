@extends('layout/adminlayout')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <div class="card-title">แก้ไขห้อง</div>
                <p class="card-description">
                    แก้ไขห้องประชุม
                </p>
                <form class="forms-sample"  action="/room/update" method="post" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="roomnameInput">ชื่อห้อง</label>
                        <input type="text" class="form-control" id="roomnameInput" name="roomName" placeholder="ระบุชื่อห้อง" value="{{$room->roomName}}">
                    </div>
                    <input type="hidden" name="roomId" value="{{$room->roomId}}">
                    <input type="submit" class="btn btn-warning" value="แก้ไขห้อง">


                </form>
            </div>
                {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                </div> --}}

            </div>

        </div>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">รายการจองห้อง {{$room->roomName}}</h4>
                <p class="card-description">
                    รายละเอียดการจองห้อง
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ลำดับที่</th>
                                <th>หัวข้อการประชุม</th>
                                <th>วันที่ใช้งาน</th>
                                <th>เวลาเริ่ม</th>
                                <th>เวลาสิ้นสุด</th>
                                <th>ผู้จอง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookingList as $booking)
                            <tr>
                                <th>{{$booking->bookingId}}</th>
                                <th>{{$booking->bookingAgenda}}</th>
                                <th>{{$booking->bookingDate}}</th>
                                <th>{{$booking->bookingTimeStart}}</th>
                                <th>{{$booking->bookingTimeFinish}}</th>
                                <th>{{$booking->userId}}</th>
                                {{-- <th>{{$booking->roomId}}</th> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection






