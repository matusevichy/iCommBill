@foreach($notices as $notice)
    <div class="alert alert-info" role="alert">
        {{$notice->text}}
    </div>
@endforeach
