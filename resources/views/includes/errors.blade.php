

@if(count($errors)>0)

    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            {{$error}}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endforeach
@endif