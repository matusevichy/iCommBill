@extends('layouts.app')

@section('title', __('Edit expence'))

@section('content')
    <div class="container">
        <form action="{{route('organizationexpences.update', $organizationexpence)}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror" name="name"
                       value="{{ $organizationexpence->name }}" autocomplete="name" autofocus required>
                <label for="name">{{ __('Expence name') }}</label>
                @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                       step="0.01" value="{{ $organizationexpence->value }}" required autocomplete="value">
                <label for="value">{{__('Value')}}</label>
                @error('value')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" id="date" name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ $organizationexpence->date }}" required autocomplete="date">
                <label for="value">{{__('Date')}}</label>

                @error('date')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div>
                <select name="budgetitemtype_id" id="budgetitemtype_id"
                        class="form-select  @error('budgetitemtype_id') is-invalid @enderror" required>
                    <option value="">{{__('Select budget item')}}</option>
                    @foreach($budget_item_types as $type)
                        <option value="{{$type->id}}" {{$type->id == $organizationexpence->budgetitemtype_id? 'selected': ''}}>{{__($type->name)}}</option>
                    @endforeach
                </select>

                @error('budgetitemtype_id')
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
