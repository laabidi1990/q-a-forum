<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\CreateAnswerRequest;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('answers._create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnswerRequest $request, Question $question)
    {
        $answer = $question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'message' => 'answer added succesfully',
            'answer' => $answer->load('user'), 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        return view('questions.show', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        return response()->json([
            'message' => 'your answer updated successfully',
            'body_html' => $answer->body_html,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->json([
            'message' => 'your answer deleted successfully',
        ]);
    }

    public function markBestAnswer(Question $question, Answer $answer)
    {
        $this->authorize('acceptBestAnswer', $answer);

        $question->addBestAnswer($answer);
    }

    public function vote(Answer $answer)
    {
        $vote = (int) request()->vote;
        $votesCount = auth()->user()->voteTheAnswer($answer, $vote);
        return response()->json([
            'message' => 'you have voted for this answer',
            'votesCount' => $votesCount,
        ]);
    }

}
