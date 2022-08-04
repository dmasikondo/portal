@extends("layouts.staff-master")

@section("pageTitle",((is_null(request('search')))?"All Users":"Search Results for \"".request('search')."\"..."))

@section("headerTitle",((is_null(request('search')))?"All Users":"Search Results for \"".request('search')."\"..."))

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">All Users</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <form>
                                <fieldset>
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control" placeholder="Search..."
                                               aria-describedby="button-addon2" value="{{request('search')}}">
                                        <div class="input-group-append">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary" type="submit"><i
                                                            class="la la-search"></i>
                                                    Search
                                                </button>
                                                <a class="btn btn-info" href="{{route('staff.users.create')}}"><i
                                                            class="la la-user-plus"></i>
                                                    Add User
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                                <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{session("status")}}
                            </div>
                        @endif
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
                    <!-- Task List table -->
                        <div class="table-responsive">
                            <table class="table table-white-space table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <a class="btn btn-block btn-primary"
                                               href="{{route('staff.users.edit',["user"=>$user->id])}}">Update</a>
                                            <a class="btn btn-block btn-danger delUser" href="#deleteUser"
                                               role="button" data-toggle="modal" data-id="{{$user->id}}">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center bold">
                                            No record found on the system.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $users->appends(Request::only(["search"]))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade text-left" id="deleteUser" tabindex="-1"
         role="dialog" aria-labelledby="Delete User" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Delete Users?</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route'=>'staff.users.destroy',"method"=>"DELETE","role"=>"form"]) !!}
                <div class="modal-body">
                    <div class="form-body">
                        <input name="user_id" id="delUserID" type="hidden">
                        <p>Are you sure you would like to delete the user?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-outline-danger">Delete
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@push('pageJavascript')
    <script>
        $(document).on('click', 'a.delUser', function () {
            $('#delUserID').val($(this).data('id'));
        });
    </script>
@endpush

