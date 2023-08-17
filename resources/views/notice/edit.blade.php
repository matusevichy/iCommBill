@extends('layouts.app')

@section('title', __('Add notice'))

@section('content')
    <form action="{{route('notices.update', $notice)}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" id="value" name="text" class="form-control @error('text') is-invalid @enderror"
                   value="{{ $notice->text }}" required autocomplete="text">
            <label for="value">{{__('Notice text')}}</label>

            @error('text')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date_begin" name="date_begin"
                   class="form-control @error('date_begin') is-invalid @enderror"
                   value="{{ $notice->date_begin}}" required autocomplete="date_begin">
            <label for="value">{{__('Date begin')}}</label>

            @error('date_begin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date_end" name="date_end" class="form-control @error('date_end') is-invalid @enderror"
                   value="{{ $notice->date_end}}" autocomplete="date_end">
            <label for="value">{{__('Date end')}}</label>

            @error('date_end')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
        @method('PUT')
    </form>
@endsection
