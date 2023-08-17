@extends('layouts.app')

@section('title', __('Add accrual'))

@section('content')
    <form action="{{route('accruals.update', $accrual)}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                   step="0.01" value="{{ $accrual->value }}" required autocomplete="value">
            <label for="value">{{__('Accrual value')}}</label>

            @error('value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                   value="{{ $accrual->date }}" required autocomplete="value">
            <label for="value">{{__('Accrual date')}}</label>

            @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div>
            <select name="accrualtype_id" id="accrualtype_id"
                    class="form-select  @error('accrualtype_id') is-invalid @enderror" required>
                <option value="">{{__('Select accrual type')}}</option>
                @foreach($accrual_types as $type)
                    <option value="{{$type->id}}" {{$type->id == $accrual->accrualtype->id? 'selected' : ''}}>
                        {{__($type->name)}}
                    </option>
                @endforeach
            </select>

            @error('accrualtype_id')
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
