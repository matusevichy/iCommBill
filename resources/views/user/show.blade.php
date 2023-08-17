@extends('layouts.app')

@section('title', __('Profile'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                {{__('Name')}}
            </div>
            <div class="col">
                {{$user->name}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('Phone number')}}
            </div>
            <div class="col">
                {{$user->phone}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('E-mail')}}
            </div>
            <div class="col">
                {{$user->email}}
            </div>
        </div>
        {{--    @if($user_orgs->count() > 0)--}}
        {{--    <div>--}}
        {{--        <h3>{{__('Organizations')}}</h3>--}}
        {{--        @foreach($user_orgs as $org)--}}
        {{--            <a href="{{route('organizations.show', $org->id)}}"> {{$org->name}}</a>--}}
        {{--        @endforeach--}}
        {{--    </div>--}}
        {{--    @endif--}}
        <div class="row">
            <div class="col">
                <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary"
                   role="button">{{__("Edit")}}</a>
            </div>
        </div>
    </div>
@endsection
