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

    // $result = Reservation::where(function($q) use($check_in, $check_out) {
    //     $q->where('check_in', '>', $check_in);
    //     $q->where('check_in', '>=', $check_out);
        
    // })->orWhere(function($q) use($check_in, $check_out) {
    //     $q->where('check_out', '<=', $check_in);
    //     $q->where('check_out', '<', $check_out);
        
    // })->get(); //  To return empty array
    

   $result = DB::table('rooms')->whereNotExists(function ($query) use ($check_in, $check_out) {
        
         $query->select('reservations.id')
                ->from('reservations')
                ->join('reservation_room', 'reservations.id', '=', 'reservation_room.reservation_id')
                ->whereRaw('rooms.id = reservation_room.room_id')
                ->where(function($q) use($check_in, $check_out) {
            
                $q->where('check_out', '>', $check_in);
                $q->where('check_in', '<', $check_out);
                
            })->limit(1);    
        })->paginate(10);
        
    

        
    
    dump($result);
    
    
    return view('welcome');
});