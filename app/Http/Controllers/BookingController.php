<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Booking::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        return Booking::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return $booking;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $response = new Response();
        $form = new StoreBookingRequest(['lesson_id' => $booking->lesson_id]);
        
        if ($request->has('member_name')){
            $booking->member_name = $request->member_name;
        }
        if ($request->has('date')){
            $booking->date = $request->date;
        }
        if ($request->has('lesson_id')){
            $booking->lesson_id = $request->lesson_id;
        }
        $validator = Validator::make(
            $booking->attributesToArray(), 
            $form->rules()
        );
        if ($validator->fails()){
            $response->setContent(['errors' => $validator->errors()]);
            $response->setStatusCode(422);
        }
        else{
            $booking->update();
            $response->setContent($booking);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response($booking, 204);
    }
}
