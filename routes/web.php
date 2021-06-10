<?php

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $check_in = '2021-6-16';
    $check_out = '2021-6-19';
    $city_id = 2;
    
    // $result = Reservation::where(function($q) use($check_in, $check_out) {
    //     $q->where('check_in', '>', $check_in);
    //     $q->where('check_in', '>=', $check_out);
        
    // })->orWhere(function($q) use($check_in, $check_out) {
    //     $q->where('check_out', '<=', $check_in);
    //     $q->where('check_out', '<', $check_out);
        
    // })->get(); //  To return empty array
    

   
    $result = DB::table('rooms')
    
    ->select('rooms.*', 'room_types.size', 'room_types.price', 'room_types.available', 'hotels.name as hotel_name', 'hotels.id as hotel_id')
    ->join('room_types','rooms.room_type_id','=','room_types.id')
    
    ->join('hotels','rooms.hotel_id', '=', 'hotels.id')
    ->whereNotExists(function ($query) use ($check_in, $check_out) {
        $query->select('reservations.id')
                ->from('reservations')
                ->join('reservation_room', 'reservations.id', '=', 'reservation_room.reservation_id')
                ->whereColumn('rooms.id', 'reservation_room.room_id')
                ->where(function ($q) use ($check_in, $check_out) {
                        $q->where('check_out', '>', $check_in);
                        $q->where('check_in', '<', $check_out);
                    })
                    ->limit(1);
    })
    ->whereExists(function($q) use($city_id) {
        $q->select('hotels.id')
                ->from('hotels')
                ->whereColumn('rooms.hotel_id','hotels.id')
                ->whereExists(function($q) use($city_id) {
                    $q->select('cities.id')
                    ->from('cities')
                    ->whereColumn('cities.id','hotels.city_id')
                    ->where('id', $city_id)
                    ->limit(1);
                })
                ->limit(1);
    })
    ->where('room_types.available', '>', 0)
    ->paginate(10);
        

    //   $result = Room::with('type')
    //     ->whereDoesntHave('reservations' , function($q) use ($check_in, $check_out) {
    //                 $q->where(function($q) use($check_in, $check_out) {
    //                     $q->where('check_out', '>', $check_in);
    //                     $q->where('check_in', '<', $check_out);
    //             });
    //         })
    //         ->whereHas('hotel.city', function($q) use ($city_id) {
    //             $q->where('id', $city_id);
    //         })
    //         ->whereHas('hotel.city', function($q) use ($city_id){
    //             $q->where('id', $city_id);
    //         })
    //         ->whereHas('type', function($q){
    //             $q->where('available', '>', 0);
    //         })
    //         ->paginate(10);
    

        
    
    dump($result);
    
    
    return view('welcome');
});