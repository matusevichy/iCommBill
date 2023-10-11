@extends('layouts.app')

@section('title', __('Add expence'))

@section('content')
    <div class="container">
        <form action="{{route('organizationexpences.store')}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror" name="name"
                       value="{{ old('name') }}" autocomplete="name" autofocus required>
                <label for="name">{{ __('Expence name') }}</label>
                @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                       step="0.01" value="{{ old('value') }}" required autocomplete="value">
                <label for="value">{{__('Value')}}</label>
                @error('value')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" id="date" name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ date('Y-m-d') }}" required autocomplete="date">
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
                    <option value="" selected>{{__('Select budget item')}}</option>
                    @foreach($budget_item_types as $type)
                        <option value="{{$type->id}}">{{__($type->name)}}</option>
                    @endforeach
                </select>

                @error('budgetitemtype_id')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="col-md-6 offset-md-4">
                <input type="hidden" name="organization_id" value="{{$organization->id}}">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection
