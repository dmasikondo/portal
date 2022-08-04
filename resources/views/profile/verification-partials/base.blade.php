<div class="row justify-content-md-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="from-actions-top-bottom-center">@yield('title')</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content collpase show">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-icon-right alert-success alert-dismissible mb-2"
                             role="alert">
                            <span class="alert-icon"><i class="la la-check"></i></span>
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>{{session("status")}}</strong>
                        </div>
                    @endif

                    @if(count($errors->all()) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-icon-right alert-danger alert-dismissible mb-2"
                                 role="alert">
                                <span class="alert-icon"><i class="la la-warning"></i></span>
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{{$error}}</strong>
                            </div>
                        @endforeach
                    @endif

                    @yield("content")
                </div>
            </div>
        </div>
    </div>
</div>