@if ($model instanceOf App\Question)
    @php
        $name= 'question';
        $route=  route('vote-question', $question->id);
    @endphp
@elseif ($model instanceOf App\Answer)
    @php
        $name= 'answer';
        $route=  route('vote-answer', [$question->id, $answer->id]);
    @endphp
@endif

<a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}">
    <i class="fas fa-caret-up fa-2x" onclick="event.preventDefault; 
        document.getElementById('vote-up-{{ $name }}{{ $model->id }}').submit()">
    </i>
</a>
<form action="{{ $route }}" 
    method="POST" id="vote-up-{{ $name }}{{ $model->id }}" style="display:none;">
@csrf
    <input type="hidden" name="vote" value="1">
</form>

<span class="votes-count">{{ $model->votes_count}}</span>

<a title="This {{ $name }} is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}">
    <i class="fas fa-caret-down fa-2x" onclick="event.preventDefault; 
        document.getElementById('vote-down-{{ $name }}{{ $model->id }}').submit()">
    </i>
</a>
<form action="{{ $route }}" 
    method="POST" id="vote-down-{{ $name }}{{ $model->id }}" style="display:none;">
@csrf
    <input type="hidden" name="vote" value="-1">
</form>