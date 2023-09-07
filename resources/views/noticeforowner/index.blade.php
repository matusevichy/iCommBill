<div>
    {{--    <h3>{{__('Notices')}}</h3>--}}
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th>{{__('Text')}}</th>
            <th>{{__('Date')}}</th>
            <th>{{__('Abonent')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($organization->noticeforowners as $notice)
            <tr>
                <td>{{$notice->text}}</td>
                <td>{{$notice->date}}</td>
                <td><a href="{{route('abonents.show', $notice->abonent->id)}}"> {{$notice->abonent->account_number}}</a>
                </td>
                <td>
                    <div class="row">
                        {{--                        <div class="col col-sm-auto px-1">--}}
                        {{--                            @can('update', $notice)--}}
                        {{--                                <a href="{{route('notices.edit', $notice->id)}}" class="btn btn-primary"--}}
                        {{--                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>--}}
                        {{--                            @endif--}}
                        {{--                        </div>--}}
                        <div class="col col-sm-auto px-1">
                            @can('delete', $notice)
                                <form action="{{ route('noticeforowners.destroy', $notice->id) }}" method="POST"
                                      class="form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary" onclick="return confirm('Are you sure?')"><i
                                            title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </form>
                        </div>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


