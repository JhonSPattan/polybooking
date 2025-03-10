@extends('layout/secretarylayout')
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Room Table</h4>
                <p class="card-description">
                    Show all room
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ลำดับที่</th>
                                <th>ชื่อห้อง</th>
                                <th>เมนู</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomlist as $room)
                            <tr>
                                <td>{{$room->roomId}}</td>
                                <td>{{$room->roomName}}</td>
                                <td>
                                    <a class="btn btn-info" href="/booking/{{$room->roomId}}">จองห้อง</a>
                                </td>
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
