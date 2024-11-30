<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;

use Carbon\Carbon;
use Hamcrest\Text\SubstringMatcher;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    // input time and information for booking
    public static function getBookingInRoom($roomId){
        $room = RoomRepository::getRoomById($roomId);
        $userId = Auth::user()->userId;
        $bookingList = BookingRepository::getBookingInRoombyUserId($roomId,$userId);
        // dd($bookingList->toSql());
        // dd($bookingList['0']);
        // $bookingList = $room->booking;
        return view('booking/bookingroom',compact('room','userId','bookingList'));
        // return view('room/roomalbum',compact('room','userId','bookingList'));
    }

    public static function addBooking(Request $req){
        $bookingAgenda = $req->bookingAgenda;
        $bookingDate = $req->bookingDate;
        $bookingTimeStart = Carbon::parse($req->bookingTimeStart);
        $bookingTimeFinish = Carbon::parse($req->bookingTimeFinish);
        $userId = $req->userId;
        $roomId = $req->roomId;
        $dateNow = Carbon::now();
        $dateSelect = Carbon::parse("$bookingDate {$bookingTimeStart->format('H:i:s')}");
        $bookingDurationMinutes = $bookingTimeStart->diffInMinutes($bookingTimeFinish);

        if ($dateSelect->lt($dateNow)) {
            return redirect('/booking/' . $roomId)->with('message', 'ไม่สามารถจองย้อนหลังได้');
        }


        if ($bookingDurationMinutes < 60) {
            return redirect('/booking/' . $roomId)->with('message', 'ต้องจองเวลาเท่ากับ 1 ชั่วโมงเท่านั้น');
        }


        $result = BookingRepository::addBooking(
            $bookingAgenda,
            $bookingDate,
            $bookingTimeStart->format('H:i:s'),
            $bookingTimeFinish->format('H:i:s'),
            $userId,
            $roomId
        );


        if ($result) {
            // edit redirect to mybooking in user dashbord page
            return redirect('/roombooking')->with('message', 'จองสำเร็จ');
        }

        return redirect('/booking/' . $roomId)->with('message', 'ไม่สามารถจองได้เพราะทับเวลาคนอื่น');
    }

        // can booking
    //     if($dateSelect->gte($dateNow)){
    //         $result = BookingRepository::addBooking($bookingAgenda, $bookingDate, $bookingTimeStart, $bookingTimeFinish, $userId, $roomId);
    //         if($result){
    //             return redirect('/roombooking');
    //         }
    //         return redirect('/booking/'.$roomId)->with('message','ไม่สามารถจองได้เพราะทับเวลาคนอื่น');
    //     }
    //     return redirect('/booking/'.$roomId)->with('message','ไม่สามารถจองย้อนหลังได้');
    // }
    //     if ($dateSelect->lt($dateNow)) {
    //         return redirect('/booking/' . $roomId)->with('message', 'ไม่สามารถจองย้อนหลังได้');
    //     }

    //     // Ensure booking duration is at least 1 hour
    //     if ($bookingTimeStart->gte($bookingTimeFinish) || $bookingTimeStart->diffInMinutes($bookingTimeFinish) < 60) {
    //         return redirect('/booking/' . $roomId)->with('message', 'ต้องจองเวลาอย่างน้อย 1 ชม.');
    //     }

    //     // Attempt to add the booking
    //     $result = BookingRepository::addBooking($bookingAgenda, $bookingDate, $req->bookingTimeStart, $req->bookingTimeFinish, $userId, $roomId);

    //     // Check for success or failure
    //     if ($result) {
    //         return redirect('/roombooking')->with('message', 'จองสำเร็จ');
    //     }

    //     return redirect('/booking/' . $roomId)->with('message', 'ไม่สามารถจองได้เพราะทับเวลาคนอื่น');
    // }

    public static function updateBookingbyId($bookingId){
        $booking = BookingRepository::getBookingbyId($bookingId);
        $room = RoomRepository::getRoomById($booking->roomId);
        return view('booking/bookingupdate',compact('booking','room'));

    }
    public static function editBookingbyId(Request $req){
        $bookingId = $req->bookingId;
        $bookingAgenda = $req->bookingAgenda;
        $bookingDate = $req->bookingDate;
        $bookingTimeStart = $req->bookingTimeStart ;
        $bookingTimeFinish = $req->bookingTimeFinish;
        $roomId = $req->roomId;
        BookingRepository::update( $bookingId,$bookingAgenda,$bookingDate,$bookingTimeStart,$bookingTimeFinish,$roomId);
        return redirect('/booking/'.$roomId);
        // return redirect('/room/'.$roomId);
    }
    public static function showfirstpage(){
        $roomList = RoomRepository::getAll();
        $bookingList = array();
        foreach($roomList as $room){
            $bookingList[] = BookingRepository::getBookingDetailinCurrentDate($room->roomId);
        }
        return view('room/roomalbum',compact('roomList','bookingList'));

    }

    // public function showBooking($roomId) {
    //     $userId = Auth::userId(); // ดึง userId ของผู้ใช้ที่ล็อกอินอยู่
    //     $room = RoomController::find($roomId);

    //     // ดึงรายการการจองเฉพาะผู้ใช้นี้
    //     $bookingList = Booking::where('roomId', $roomId)
    //                           ->where('userId', $userId)
    //                           ->get();

    //     return view('booking.create', compact('room', 'bookingList', 'userId'));
    // }


// public static function getBookinginRoom($roomId){
//     $room = RoomRepository::getRoomById($roomId);
//     $userId = Auth::id(); // ดึง userId ของผู้ใช้งานที่ล็อกอินอยู่
//     $bookingList = $room->booking->where('userId', $userId); // กรองเฉพาะ booking ของผู้ใช้นี้

//     return view('booking/bookinghis', compact('bookingList', 'room'));
// }
// public static function Bookingonalbum(Request $req){
//     $booking = BookingRepository::getBookingonalbum();
//     return view('bookingonalbum',compact('booking'));
// }







}
