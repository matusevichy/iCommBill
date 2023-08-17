<div>
    {{--    <h3>{{__('Saldo')}}</h3>--}}
    @can('create', [\App\Models\Saldo::class, $abonent])
        <a href="{{route('saldos.create', $abonent->id)}}" class="btn btn-primary"
           role="button">{{__("Add")}} </a>
    @endcan
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th scope="row">{{__('Accrual type')}}</th>
            <th>{{__('Value')}}</th>
            <th>{{__('On date')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($saldos as $saldo)
            <tr>
                <td>{{__($saldo->accrualtype->name)}}</td>
                <td>{{$saldo->value}}</td>
                <td>{{$saldo->date}}</td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $saldo)
                                <a href="{{route('saldos.edit', $saldo->id)}}" class="btn btn-primary"
                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @endcan
                        </div>
                        <div class="col col-sm-auto px-1">
                            @can('delete', $saldo)
                                <form action="{{ route('saldos.destroy', $saldo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary"
                                            onclick="return confirm('Are you sure?')"><i
                                            title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i></button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
