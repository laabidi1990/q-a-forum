@auth
    <div class="card mt-4 col-md-8 text-center" style="margin:auto;">
        <div class="card-header">
        {{ isset($answer)? 'Edit your answer' : ' Write your answer' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($answer)? route('answers.update', [$question->id, $answer->id]) 
                                        : route('answers.store', $question->id) }}" method="POST">
                @if (isset($answer))
                    @method('PATCH')
                @endif
                @csrf
                <div class="form-group">
                <textarea name="body" id="answer" cols="5" rows="5" 
                    class="form-control {{ $errors->has('body')? 'is-invalid' : '' }}">{{ isset($answer)? $answer->body : old('body') }}
                    </textarea>
                    @error('body')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong> 
                        </div>
                    @enderror 
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-25">
                        {{ isset($answer)? 'Update your answer' : 'Add your answer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endauth
