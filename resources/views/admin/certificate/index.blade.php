@extends('layouts.app')

@push('before-css')
    <link href="{{ asset('plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Certificate</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Home</li>
                        <li class="breadcrumb-item active">Certificate</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right">
                <a class="btn btn-info mb-1" href="{{ url('admin/course/create') }}">Add Course</a>
            </div>
        </div> --}}
    </div>

    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Certificate Info</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="">
                                <table class="table table-striped table-bordered zero-configuration" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Course</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($course as $item)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->user->email }}</td>
                                                <td>{{ $item->course->product_title }}</td>
                                                <td>
                                                    <a href="javascript:void(0);"
                                                    class="{{ $item->status == 1 ? 'update-status-disabled' : 'update-status' }}"
                                                    data-status="1"
                                                    data-id="{{ $item->id }}"
                                                    id="approve-{{ $item->id }}"
                                                    title="Approve" {{ $item->status == 1 ? 'disabled' : '' }}>
                                                        <button class="btn {{ $item->status == 1 ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ $item->status == 1 ? 'Approved' : 'Approve' }}
                                                        </button>
                                                    </a>

                                                    <a href="javascript:void(0);"
                                                    class="{{ $item->status == 0 ? 'update-status-disabled' : 'update-status' }}"
                                                    data-status="0"
                                                    data-id="{{ $item->id }}"
                                                    id="decline-{{ $item->id }}"
                                                    title="Decline" style="display: none">
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Decline
                                                        </button>
                                                    </a>

                                                    <!-- Placeholder for showing the approved or declined status -->
                                                    {{-- <span id="status-label-{{ $item->id }}"></span> --}}
                                                </td>
                                            </tr>
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Course</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- ============================================================== -->
    <script src="{{ asset('plugins/components/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
        $(function() {
            $('#myTable').DataTable();
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 18,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group +
                                '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
        });

        $(document).on('click', '.update-status', function(e) {
            e.preventDefault();

            let status = $(this).data('status');
            let id = $(this).data('id');
            let url = "{{ route('admin.certificate.status') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    id: id
                },
                success: function(response) {

                    if (status === 1) {
                        // Show "Approved" status and disable buttons
                        // $('#status-label-' + id).text('Approved').css('color', 'green');
                        $('#approve-' + id).find('button').prop('disabled', true);
                        $('#decline-' + id).hide(); // Hide Decline button
                        $(".update-status").attr('class', 'update-status-disable');
                        window.location.reload();
                    } else {
                        // Show "Declined" status and disable buttons
                        // $('#status-label-' + id).text('Declined').css('color', 'red');
                        $('#decline-' + id).find('button').prop('disabled', true);
                        $('#approve-' + id).hide(); // Hide Approve button
                        $(".update-status").attr('class', 'update-status-disable');
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {

                    alert("An error occurred: " + error);
                }
            });
        });
    </script>
@endpush
