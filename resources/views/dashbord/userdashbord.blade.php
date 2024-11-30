@extends('layout/secretarylayout')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" style="background-color: white">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="card-title">การจองของฉัน</div>
                        <p class="card-description">
                            ประวัติการจองห้อง
                        </p>
                    </div>
                    <div>
                        <form method="post" action="/user/search" class="input-group form-control-sm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" placeholder="ค้นหาด้วยชื่อห้อง" name="roomName" style="background-color: rgba(245, 245, 245, 0.39)">
                            <input type="hidden" value="{{$offset}}" name="offset">
                            <input type="hidden" value="{{$limit}}" name="limit">
                            <input type="submit" class="btn btn-primary" value="ค้นหา" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (!empty($bookingList))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">หัวข้อการประชุม</th>
                                    <th style="text-align: center">วันที่ใช้งาน</th>
                                    <th style="text-align: center">เวลาเริ่ม</th>
                                    <th style="text-align: center">เวลาสิ้นสุด</th>
                                    <th style="text-align: center">ผู้จอง</th>
                                    <th style="text-align: center">ลบข้อมูลการจอง</th>
                                    <th colspan="2" style="text-align: center">เมนู</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookingList as $booking)
                                    <tr>
                                        <td style="text-align: center">{{$loop->iteration+((int)$offset-1)*(int)$limit}}</td>
                                        <td style="text-align: center">{{$booking->bookingAgenda}}</td>
                                        <td style="text-align: center">{{$booking->bookingDate}}</td>
                                        <td style="text-align: center">{{$booking->bookingTimeStart}}</td>
                                        <td style="text-align: center">{{$booking->bookingTimeFinish}}</th>
                                        <td style="text-align: center">{{$booking->userbookingName}}</td>
                                        <td style="text-align: center">{{$booking->roomName}}</td>

                                        {{-- <td>{{\Carbon\Carbon::now()}}</td> --}}
                                        {{-- <td>{{\Carbon\Carbon::parse($booking->bookingDate." ".$booking->bookingTimeStart)->lt(\Carbon\Carbon::now())}}</td> --}}
                                        @if (\Carbon\Carbon::parse($booking->bookingDate." ".$booking->bookingTimeStart)->lt(\Carbon\Carbon::now()))
                                        <td colspan="2" style="text-align: center">
                                            ไม่สามารถแก้ไขหรือลบได้เนื่องจากเวลาเลยกำหนด
                                        </td>
                                        @else
                                        <td>
                                            <a class="btn btn-danger" {{route('delete',$booking->bookingId)}}
                                                onclick="return confirm('คุณต้องการลบการจอง {{$booking->bookingId}}หรือไม่')"
                                                >
                                                ลบ
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/editbooking/{{$booking->bookingId}}" class="btn btn-warning" >เเก้ไข</a>
                                        </td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <center >
                        <img src="{{asset('images/ui/empty-box.png')}}" alt="empty" style="width: 300px;height: 300px;"/>
                        <h4>ไม่พบข้อมูลห้องที่ต้องการค้นหา</h4>
                        {{-- @if (session('message'))
                            <h4>ไม่พบข้อมูลห้อง '{{session('message')}}' ที่ต้องการค้นหา</h4>
                        @endif --}}
                    </center>
                @endif
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        @if ($offset-1 > 0)
                            <li class="page-item">
                                <a class="page-link" href="{{$stringPage.''.($offset-1)}}">Previous</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" >Previous</a>
                            </li>
                        @endif
                        {{-- <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li> --}}
                        @for ($i=1;$i<=$count;$i++)
                            @if ($i == $offset)
                                <li class="page-item">
                                    <a class="page-link active" href="{{$stringPage.''.$i}}">{{$i}}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{$stringPage.''.$i}}">{{$i}}</a>
                                </li>
                            @endif
                        @endfor

                        @if ($offset+1 <= $count)
                            <li class="page-item">
                                <a class="page-link" href="{{$stringPage.''.($offset+1)}}">Next</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" aria-disabled="true">Next</a>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
