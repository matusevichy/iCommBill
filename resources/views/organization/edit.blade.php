@extends('layouts.app')

@section('title', __('Edit organization'))

@section('content')
    <form action="{{route('organizations.update', $organization)}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ $organization->name }}" required autocomplete="name" autofocus>
            <label for="name">{{__('Organization name')}}</label>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" id="location" name="location"
                   class="form-control @error('location') is-invalid @enderror" value="{{ $organization->location }}"
                   required autocomplete="location">
            <label for="location">{{__('Organization location')}}</label>

            @error('location')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="number" id="user_limit" name="user_limit"
                   class="form-control @error('user_limit') is-invalid @enderror"
                   value="{{ $organization->user_limit }}"
                   required autocomplete="user_limit">
            <label for="user_limit">{{__('Abonents limit')}}</label>

            @error('user_limit')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="number" id="accrual_date" name="accrual_date"
                   class="form-control @error('accrual_date') is-invalid @enderror"
                   value="{{ $organization->accrual_date }}"
                   min="1" max="31" autocomplete="accrual_date">
            <label for="user_limit">{{__('Accrual date')}}</label>

            @error('accrual_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div>
            <select name="organizationtype_id" id="organizationtype_id"
                    class="form-select  @error('organizationtype_id') is-invalid @enderror" required>
                @foreach($types as $type)
                    <option
                        value="{{$type->id}}"
                        {{$type->id == $organization->organizationtype_id? 'selected':''}}>{{__($type->name)}}
                    </option>
                @endforeach
            </select>

            @error('organizationtype_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div>
            <div class="list-group" name="owners" id="owners">
                @foreach($users as $user)
                    <label class="list-group-item">
                        <input class="form-check-input" type="checkbox" name="users[]" value="{{$user->id}}"
                            {{in_array($user->id, $organization->users()->allRelatedIds()->toArray())? 'checked' : ''}}
                        >
                        {{$user->name}}&nbsp;{{$user->phone}}
                    </label>
                @endforeach
            </div>
        </div>
        <div>
            <label>
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                       value="1" {{$organization->is_active ? 'checked' : ''}}>
                Active
            </label>
        </div>
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
        @method('PUT')
    </form>
@endsection
