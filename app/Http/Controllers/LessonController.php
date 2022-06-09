<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                
        return Lesson::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        return Lesson::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        return $lesson;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {        
        $response = new Response();
        $form = new StoreLessonRequest();
        
        if ($request->has('name')){
            $lesson->name = $request->name;
        }
        if ($request->has('start')){
            $lesson->start = $request->start;
        }
        if ($request->has('end')){
            $lesson->end = $request->end;
        }
        if ($request->has('capacity')){
            $lesson->capacity = $request->capacity;
        }
        $validator = Validator::make(
            $lesson->attributesToArray(), 
            $form->rules()
        );
        if ($validator->fails()){
            $response->setContent(['errors' => $validator->errors()]);
            $response->setStatusCode(422);
        }
        else{
            $lesson->update();
            $response->setContent($lesson);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return response($lesson, 204);
    }
}
