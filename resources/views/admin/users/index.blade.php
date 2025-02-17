@extends('layouts.app')

@push('after-css')
    <link href="{{ asset('plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Users</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Home</li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right">
                <a class="btn btn-info mb-1" href="{{ route('admin.user.create') }}">Add Users</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box card">
                    <div class="card-body">
                        <h3 class="box-title pull-left">Users List</h3>

                        <div class="clearfix"></div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $key => $user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    @if ($user->role == 2)
                                                        <td>User</td>
                                                    @else
                                                        <td>Employee</td>
                                                    @endif
                                                    <th>
                                                        @if ($user->role == 3 && $user->status == 0)
                                                            <a class="btn btn-info" data-toggle="modal"
                                                                data-target="#otpModal"
                                                                style="
                                                        color: white;
                                                    "><i
                                                                    class="fa fa-pencil"></i> Verify</a>
                                                            <div class="modal fade" id="otpModal" tabindex="-1"
                                                                role="dialog" aria-labelledby="otpModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="otpModalLabel">
                                                                                Verify Your OTP</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('verify.otp') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="user_id"
                                                                                    value="{{ $user->id }}">
                                                                                <div class="form-group">
                                                                                    <label for="otp">Enter OTP</label>
                                                                                    <input type="text" id="otp"
                                                                                        name="otp" class="form-control"
                                                                                        required>
                                                                                </div>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Verify
                                                                                    OTP</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a class="btn btn-info"
                                                                href="{{ route('admin.user.edit', $user->id) }}"><i
                                                                    class="fa fa-pencil"></i> Edit</a> &nbsp;&nbsp;
                                                            <a class="delete btn btn-danger"
                                                                href="{{ route('admin.user.delete', $user->id) }}"><i
                                                                    class="fa fa-trash"></i> Delete</a>
                                                        @endif
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button to trigger the modal -->
        {{-- <button type="button">Verify Account</button> --}}
        <!-- OTP Verification Modal -->

        @include('layouts.admin.footer')
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/components/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete', function(e) {
                if (confirm('Are you sure want to delete?')) {} else {
                    return false;
                }
            });
            @if (\Session::has('message'))
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '{{ session()->get('message') }}',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif
        })

        $(function() {
            $('#myTable').DataTable({
                "columns": [
                    null, null, null, {
                        "orderable": false
                    }
                ]
            });

        });
    </script>
@endpush
