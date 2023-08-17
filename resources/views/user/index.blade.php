@extends('layouts.app')

@section('title', __('Users'))

@section('content')
    <div class="container">
        @can('create', \App\Models\User::class)
            <a href="{{route('users.create')}}" class="btn btn-primary" role="button">{{__("Add")}} </a>
        @endcan
        <table class="table table-striped table-responsive-md">
            <thead>
            <tr>
                <th scope="col">{{__("Name")}}</th>
                <th scope="col">{{__("Phone number")}}</th>
                <th scope="col">{{__("E-mail")}}</th>
                <th scope="col">{{__("Role")}}</th>
                <th scope="col">{{__("Actions")}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->name}}</th>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{__($user->role->name)}}</td>
                    <td>
                        <div class="row">
                            <div class="col col-sm-auto px-1">
                                @can('update', $user)
                                    <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary"
                                       role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    {{--                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">--}}
                                    {{--                        @csrf--}}
                                    {{--                        @method('DELETE')--}}
                                    {{--                        <button class="btn btn-primary" onclick="return confirm('Are you sure?')">{{__('Delete')}}</button>--}}
                                    {{--                    </form>--}}
                                @endcan
                            </div>
                        </div>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
