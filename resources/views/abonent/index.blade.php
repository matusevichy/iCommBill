<div>
    {{--    <h3>{{__('Abonents')}}</h3>--}}
</div>
<a href="{{route('abonents.create', $organization->id)}}" class="btn btn-primary"
   role="button">{{__("Add")}} </a>
<table class="table table-striped table-responsive-md">
    <thead>
    <tr>
        <th scope="col">{{__("Account number")}}</th>
        <th scope="col">{{__("Location number")}}</th>
        <th scope="col">{{__("Street")}}</th>
        <th scope="col">{{__("Square")}},{{__('m')}}<sup>2</sup></th>
        <th scope="col">{{__("Owner")}}</th>
        <th scope="col">{{__("Arrears")}}</th>
        <th scope="col">{{__("Actions")}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($abonents as $abonent)
        <tr>
            <th scope="row"><a href="{{route('abonents.show', $abonent->id)}}"> {{$abonent->account_number}}</a></th>
            <td>{{$abonent->location_number}}</td>
            <td>{{$abonent->street}}</td>
            <td>{{$abonent->square}}</td>
            <td>{{$abonent->user->name}}</td>
            <td>{{get_abonent_saldo($abonent->id)}}</td>
            <td>
                <div class="row">
                    <div class="col col-sm-auto px-0">
                        <a href="{{route('abonents.edit', $abonent->id)}}" class="btn btn-primary"
                           role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </div>
                    <div class="col col-sm-auto px-0">
                        {{--                    <form action="{{ route('abonents.destroy', $abonent->id) }}" method="POST">--}}
                        {{--                        @csrf--}}
                        {{--                        @method('DELETE')--}}
                        {{--                        <button class="btn btn-primary" onclick="return confirm('Are you sure?')"><i
                                                title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i></button>--}}
                        {{--                    </form>--}}
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
