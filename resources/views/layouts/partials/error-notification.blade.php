@if(count($errors->all()) > 0)
    @foreach($errors->all() as $error)
        <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2"
             role="alert">
            <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {{$error}}
        </div>
    @endforeach
@endif