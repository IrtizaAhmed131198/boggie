@extends('layouts.app')

@push('before-css')
    <link href="{{ asset('plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Course</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Home</li>
                        <li class="breadcrumb-item active">Course</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right">
                <a class="btn btn-info mb-1" href="{{ url('admin/course/create') }}">Add Course</a>
            </div>
        </div>
    </div>

    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Course Info</h4>
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
                                            <th>Course Title</th>
                                            <th>Course Price</th>
                                            <th>Course Category</th>
                                            <th>Course Image</th>
                                            <th>Course Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($product as $item)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td class="text-dark weight-600">
                                                    {{ \Illuminate\Support\Str::limit($item->product_title, 50, $end = '...') }}
                                                </td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->categorys->name }}</td>
                                                <td><img src="{{ asset($item->image) }}" alt="" title=""
                                                        width="150"></td>
                                                <td>
                                                    <!-- Verify button or verified text based on is_verified status -->
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-sm toggle-status {{ $item->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                        data-id="{{ $item->id }}">
                                                        {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary move-up"
                                                        data-id="{{ $item->id }}" style="display: none">↑ Up</button>
                                                    <button class="btn btn-sm btn-secondary move-down"
                                                        data-id="{{ $item->id }}" style="display: none">↓ Down</button>
                                                    <a href="{{ url('/admin/course/' . $item->id . '/edit') }}">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"> </i> Edit
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('course.delete', $item->id) }}"
                                                        onclick='return confirm("Confirm delete?")'>
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Title</th>
                                            <th>Course Price</th>
                                            <th>Course Category</th>
                                            <th>Course Image</th>
                                            <th>Course Status</th>
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
        var courseColumns = [
            { data: 'id', name: 'id' },
            { data: 'product_title', name: 'product_title' },
            { data: 'price', name: 'price' },
            { data: 'category', name: 'category' },
            { data: 'image', name: 'image' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ];

        $(document).ready(function () {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('course.getIndex') }}", // Replace with the actual route
                columns: courseColumns,
                initComplete: function () {
                    console.log(this.api().ajax.json()); // Log the response data
                }
            });
        });
    </script>
    <script>
        // $(function() {
        //     $('#myTable').DataTable();
        //     var table = $('#example').DataTable({
        //         "columnDefs": [{
        //             "visible": false,
        //             "targets": 2
        //         }],
        //         "order": [
        //             [2, 'asc']
        //         ],
        //         "displayLength": 18,
        //         "drawCallback": function(settings) {
        //             var api = this.api();
        //             var rows = api.rows({
        //                 page: 'current'
        //             }).nodes();
        //             var last = null;
        //             api.column(2, {
        //                 page: 'current'
        //             }).data().each(function(group, i) {
        //                 if (last !== group) {
        //                     $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group +
        //                         '</td></tr>');
        //                     last = group;
        //                 }
        //             });
        //         }
        //     });
        // });

        $(document).on('click', '.toggle-status', function() {
            let itemId = $(this).data('id');
            let button = $(this);
            button.prop('disabled', true);

            $.ajax({
                url: "{{ url('course-status') }}/" + itemId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        let newStatus = response.data.status;

                        if (newStatus) {
                            button.text('Active')
                                .removeClass('btn-danger')
                                .addClass('btn-success');
                        } else {
                            button.text('Inactive')
                                .removeClass('btn-success')
                                .addClass('btn-danger');
                        }
                    }
                    button.prop('disabled', false);
                },
                error: function() {
                    alert('Something went wrong. Please try again.');
                }
            });
        });

        $(document).ready(function() {
            // Move item up
            $('.move-up').on('click', function() {
                let row = $(this).closest('tr');
                let id = $(this).data('id');
                moveItem(row, id, 'up');
            });

            // Move item down
            $('.move-down').on('click', function() {
                let row = $(this).closest('tr');
                let id = $(this).data('id');
                moveItem(row, id, 'down');
            });

            function moveItem(row, id, direction) {
                $.ajax({
                    url: "{{ route('course.move') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        direction: direction,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (direction === 'up' && row.prev().length) {
                                row.insertBefore(row.prev());
                            } else if (direction === 'down' && row.next().length) {
                                row.insertAfter(row.next());
                            }
                        } else {
                            alert('Failed to move item');
                        }
                    },
                    error: function() {
                        alert('Error occurred');
                    }
                });
            }
        });
    </script>
@endpush
