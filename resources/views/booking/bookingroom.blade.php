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
                @if (session('message'))
                <h6 class="font-weight-bold text-danger">{{session('message')}}</h6>
                @endif
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
                        <input type="date" class="form-control" id="roomnameInput" name="bookingDate" required>
                    </div>
                    <div class="form-group">
                        <label for="time">เวลาที่ใช้ห้อง</label>
                        <div class="row" id="time">
                            <div class="col-sm-6">
                                <label for="timestart">เวลาเริ่ม</label>
                                <input type="time" class="form-control" id="timestart" name="bookingTimeStart" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="timeend">เวลาสิ้นสุด</label>
                                <input type="time" class="form-control" id="timeend" name="bookingTimeFinish" required>
                            </div>
                        </div>

                    </div>
                    {{-- userid => 1 --}}
                    <input type="hidden" name="roomId" value="{{$room->roomId}}">
                    <input type="hidden" name="userId" value="{{$userId}}">
                    <input type="submit" class="btn btn-primary" value="จองห้อง">
                </form>
            </div>

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

                {{-- <p style="position: absolute; right: 0;">เพิ่ม</p> --}}


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
                                <th>ลบข้อมูลการจอง</th>
                                <th>เเก้ไขข้อมูลการจอง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookingList as $booking)
                            <tr>
                                <td>{{$booking->bookingId}}</td>
                                <td>{{$booking->bookingAgenda}}</td>
                                <td>{{$booking->bookingDate}}</td>
                                <td>{{$booking->bookingTimeStart}}</td>
                                <td>{{$booking->bookingTimeFinish}}</td>
                                <td>{{$booking->user->firstName." ".$booking->user->lastName}}</td>
                                <td><a href="{{route('delete',$booking->bookingId)}} " class="btn btn-danger"
                                    onclick="return confirm('คุณต้องการลบบทความ {{$booking->bookingId}}หรือไม่')"
                                     >ลบ </a></td>
                                <td><a href="/bookingedit/{{$booking->bookingId}}" class="btn btn-warning">เเก้ไข</a></td>
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
