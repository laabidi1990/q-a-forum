@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width:80%">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h2>ALL Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">
                                Ask a Question
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('partials._messages')
                    @foreach ($questions as $question)
                        <div class="media">
                            <div class="d-flex flex-column counters">
                                <div class="vote">
                                    <strong>{{ $question->votes_count }} </strong>{{ str_plural('vote', $question->votes_count) }}
                                </div>
                                <div class="status {{ $question->status}}">
                                    <strong>{{ $question->answers_count }} </strong>
                                    {{ str_plural('answer', $question->answers_count) }}
                                </div>
                                <div class="view mt-2">
                                    {{ $question->views ." ". str_plural('view', $question->views) }}
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="mt-0">
                                    <a href="{{ $question->url }}">{{ $question->title }}</a> 
                                </h3>
                                <p class="lead">
                                    Asked by
                                    <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                    <small class="text-muted">{{ $question->created_date }}</small>
                                </p>
                                {{ str_limit(strip_tags($question->body), 250) }}
                            </div>
                        </div>

                        <hr class="my-4">
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $questions->links() }}
                    </div>
        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
