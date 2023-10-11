@extends('layouts.app')

@section('title', __('Edit budget item type'))

@section('content')
    <div class="container">
        <form action="{{route('budgetitemtypes.update', $budgetitemtype)}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ $budgetitemtype->name }}" required autocomplete="name" autofocus>
                <label for="name">{{__('Name')}}</label>

                @error('name')
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
    </div>
@endsection
