@extends('layout/secretarylayout')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">จองห้อง</div>
                <p class="card-description">
                    จองห้องประชุม {{$room->roomName}}
                </p>
                <form class="forms-sample"  action="/booking/addbooking" method="post" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="roomnameInput">ชื่อห้องประชุม</label>
                        <input type="text" class="form-control" id="roomnameInput" name="roomName" placeholder="ระบุชื่อห้อง" value="{{$room->roomName}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="roomnameInput">หัวข้อการประชุม</label>
                        <input type="text" class="form-control" id="roomnameInput" name="bookingAgenda" placeholder="ห้องการประชุม" required>
                    </div>
                    <div class="form-group">
                        <label for="roomnameInput">วันที่ใช้ห้อง</label>
                        <input type="date" class="form-control" id="roomnameInput" name="bookingDate" >
                    </div>
                    <div class="form-group">
                        <label for="time">เวลาที่ใช้ห้อง</label>
                        <div class="row" id="time">
                            <div class="col-sm-6">
                                <label for="timestart">เวลาเริ่ม</label>
                                <input type="time" class="form-control" id="timestart" name="bookingTimeStart" >
                            </div>
                            <div class="col-sm-6">
                                <label for="timeend">เวลาสิ้นสุด</label>
                                <input type="time" class="form-control" id="timeend" name="bookingTimeFinish">
                            </div>
                        </div>

                    </div>
                    {{-- userid => 1 --}}
                    <input type="hidden" name="roomId" value="{{$room->roomId}}">
                    <input type="submit" class="btn btn-warning" value="จองห้อง">
                </form>
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
</div>
@endsection
