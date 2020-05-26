<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->only('create', 'store', 'update');
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $question = new Question();

        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));
        return response()->json([
            'message' => 'Your question has been created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // $question->views = $question->views + 1;
        // $question->save();

        $question->increment('views');

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('questions.create', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'body'));
        return response()->json([
            'message' => 'Your question has been updated successfully',
            'body_html' => $question->body_html,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json([
            'message' => 'Your question has been deleted successfully',
        ]);

    }

    public function markfavorited(Question $question)
    {
        $question->favorites()->attach(auth()->user()->id);
    }

    public function unmarkfavorited(Question $question)
    {
        $question->favorites()->detach(auth()->user()->id);
    }

    public function vote(Question $question)
    {
        $vote = (int) request()->vote;
        $votesCount = auth()->user()->voteTheQuestion($question, $vote);
        return response()->json([
            'message' => 'you have voted for this question',
            'votesCount' => $votesCount,
        ]);
    }

}
