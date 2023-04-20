<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddQuestionRequest;
use App\Models\Answer;
use App\Models\Question;

class QuestionController extends Controller
{
    public function add_question(AddQuestionRequest $request){
        
        $validated =  $request->validated();
        return $validated;
        /*$question = new Question;
        $answer = new Answer();
        if($request->hasFile('image')){
        $image_name = time().rand(1,10000).$request->Image_book->extension();
        $image_path = 'uploads/'.auth()->user()->name.'/'.$image_name;
        $question->image = $image_path;
    }
    $question->body = $validated['body'];
    $question->test_id = $validated['test_id'];
    $question->save();
    return response()->json([
        'message' => 'question has been added',
        'status code ' => 200
    ]);*/
    }
}
