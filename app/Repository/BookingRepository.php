<?php

namespace App\Repository;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BookingRepository
{
    public static function addBooking($bookingAgenda, $bookingDate, $bookingTimeStart, $bookingTimeFinish, $userId, $roomId)
    {


        // $isbooking = Booking::select("select * exists(select * from booking where (booking.bookingTimeStart between $bookingTimeStart and $bookingTimeFinish) or (booking.bookingTimeFinish between $bookingTimeStart and $bookingTimeFinish)
        //     or ( booking.bookingTimeStart < $bookingTimeStart and booking.bookingTimeFinish > $bookingTimeFinish) and booking.roomId = $roomId and booking.bookingDate != $bookingDate) as result");

        // if(!$isbooking){
        //     $booking = new Booking();
        //     $booking->bookingAgenda = $bookingAgenda;
        //     $booking->bookingDate = $bookingDate;
        //     $booking->bookingTimeStart = $bookingTimeStart;
        //     $booking->bookingTimeFinish = $bookingTimeFinish;
        //     $booking->userId = $userId;
        //     $booking->roomId = $roomId;
        //     $result = $booking->save();
        //     return $result;
        // }
        // return false;


        $bookingTimeStart = Carbon::parse($bookingTimeStart)->format('H:i:s');
        $bookingTimeFinish = Carbon::parse($bookingTimeFinish)->format('H:i:s');

        // if(!$isbooking){

        // }
        // return false;
        DB::enableQueryLog();
        $isbooking = DB::select('
            select exists(
                select *
                from booking
                where
                    ((booking.bookingTimeStart between ? and ? and booking.bookingTimeFinish between ? and ?)
                    or
                    (booking.bookingTimeStart < ? and booking.bookingTimeFinish > ?))
                    and booking.roomId = ?
                    and booking.bookingDate = ?
            ) as result ', [$bookingTimeStart, $bookingTimeFinish, $bookingTimeStart, $bookingTimeFinish, $bookingTimeStart, $bookingTimeFinish, $roomId, $bookingDate]);


        // dd($isbooking['0']->result == 0);
        // echo "result ".($isbooking != null);

        if ($isbooking['0']->result == 0) {
            $booking = new Booking();
            $booking->bookingAgenda = $bookingAgenda;
            $booking->bookingDate = $bookingDate;
            $booking->bookingTimeStart = $bookingTimeStart;
            $booking->bookingTimeFinish = $bookingTimeFinish;
            $booking->userId = $userId;
            $booking->roomId = $roomId;
            $result = $booking->save();
            return $result;
        }
        return false;
    }
    //update
    public static function getBookingbyId($bookingId)
    {
        $booking = Booking::where('bookingId', '=', $bookingId)->first();
        return $booking;
    }
    public static function update($bookingId, $bookingAgenda, $bookingDate, $bookingTimeStart, $bookingTimeFinish, $roomId)
    {
        DB::enableQueryLog();
        $isbooking = DB::select('
            select exists(
                select *
                from booking
                where
                    ((booking.bookingTimeStart between ? and ? and booking.bookingTimeFinish between ? and ?)
                    or
                    (booking.bookingTimeStart < ? and booking.bookingTimeFinish > ?))
                    and booking.roomId = ?
                    and booking.bookingDate = ?
                    and booking.bookingId != ?
            ) as result ', [$bookingTimeStart, $bookingTimeFinish, $bookingTimeStart, $bookingTimeFinish, $bookingTimeStart, $bookingTimeFinish, $roomId, $bookingDate, $bookingId]);
        if ($isbooking['0']->result == 0) {
            $result = Booking::where('bookingId', '=', $bookingId)->update([
                //this  'bookingAgenda' form database
                'bookingAgenda' => $bookingAgenda,
                'bookingDate' => $bookingDate,
                'bookingTimeStart' => $bookingTimeStart,
                'bookingTimeFinish' => $bookingTimeFinish


            ]);
            return $result;
        }
        return false;
    }
    public static function getBookingInRoombyUserId($roomId, $userId)
    {
        $booking = Booking::where('booking.roomId', '=', $roomId)->where('booking.userId', '=', $userId)->get();
        return  $booking;
    }

    // public static function deletebyUser(){
    //     $booking = DB::table('booking')->where('UserId')->first();
    // }
    // public static function getBookingonalbum()
    // {
    //     $datenow = DB::table('booking')
    //         ->select('bookingAgenda', 'bookingTimeStart', 'bookingTimeFinish', 'userId', 'bookingDate')
    //         ->whereDate('bookingDate', Carbon::today())
    //         ->get();
    //     return $datenow;
    // }


    public static function getBookingDetailinCurrentDate($roomId){
        // SELECT booking.bookingAgenda, booking.bookingDate, booking.bookingTimeStart, booking.bookingTimeFinish, booking.roomId, user.firstName, user.lastName FROM booking INNER JOIN user ON booking.userId = user.userId WHERE booking.bookingDate = CURRENT_DATE AND booking.roomId = 1 ORDER BY booking.bookingTimeStart ASC;
        $bookingDetail = Booking::select(['booking.bookingAgenda', 'booking.bookingDate', 'booking.bookingTimeStart', 'booking.bookingTimeFinish', 'booking.roomId',
        'user.firstName', 'user.lastName'])->join('user','user.userId','=', 'booking.userId')
        ->whereRaw('booking.bookingDate = CURRENT_DATE')->where('booking.roomId','=',$roomId)->orderBy('booking.bookingTimeStart','asc')->get();
        return $bookingDetail;
    }

    public static function getbookingincurrentdate()
    {
        // $bookingList = Booking::select(['booking.bookingAgenda,booking.bookingTimeStart,booking.bookingTimeFinish,booking.userId'])
        // ->whereRow('booking.bookingDate = CURRENT_DATE')->where('booking.roomId','=',$roomId)
        // ->order('booking.bookingTimestart','asc');
        $bookingList = DB::table('booking')
            ->join('user', 'booking.userId', '=', 'user.userId')
            ->select(
                'booking.bookingAgenda',
                'booking.bookingTimeStart',
                'booking.bookingTimeFinish',
                'booking.userId',
                DB::raw('DATE_FORMAT(booking.bookingDate, "%d/%m/%y") AS BookingDate'),
                'user.firstName',
                'user.lastName'
            )
            // ->where('booking.roomId', '=', $roomId)
            ->where('booking.bookingDate', DB::raw('CURDATE()'))
            ->orderBy('booking.bookingTimeStart', 'asc')
            ->get();
        return $bookingList;
        // DB::table('booking')
        // ->join('user', 'booking.userId', '=', 'user.userId')
        // ->select(
        //     'booking.bookingAgenda',
        //     'booking.bookingTimeStart',
        //     'booking.bookingTimeFinish',
        //     'booking.userId',
        //     DB::raw('DATE_FORMAT(booking.bookingDate, "%d/%m/%y") AS BookingDate'),
        //     'user.firstName',
        //     'user.lastName'
        // )
        // // ->where('booking.roomId', $roomId)
        // ->where('booking.bookingDate', DB::raw('CURDATE()'))
        // ->orderBy('booking.bookingTimeStart', 'asc')
        // ->get();

        // dd(DB::table('booking')
        // ->join('user', 'booking.userId', '=', 'user.userId')
        // ->select(
        //     'booking.bookingAgenda',
        //     'booking.bookingTimeStart',
        //     'booking.bookingTimeFinish',
        //     'booking.userId',
        //     DB::raw('DATE_FORMAT(booking.bookingDate, "%d/%m/%y") AS BookingDate'),
        //     'user.firstName',
        //     'user.lastName'
        // )
        // ->where('booking.roomId', $roomId= 1)
        // ->where('booking.bookingDate', DB::raw('CURDATE()'))
        // ->orderBy('booking.bookingTimeStart', 'asc')
        // ->get());
        // dd(DB::table('booking')->select(['booking.bookingAgenda,booking.bookingDate,booking.bookingTimeStart,booking.bookingTimeFinish,booking.userId'])
        // ->whereRaw('booking.bookingDate = CURRENT_DATE')
        // ->orderBy('booking.bookingTimeStart','asc'));

    }
}
