@extends('layouts.app', ['pageTitle' => 'Student List'])
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Student List</h5>
                <a class="btn btn-success" href="{{ route('create') }}">Add New</a>

            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Student Name</th>
                    <th>Roll No</th>
                    <th>Class</th>
                    <th>Score</th>
                    <th>Score</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('table').DataTable().destroy();
        datatable = $('table').DataTable({
            "order": [
                [5, "DESC"]
            ],
            responsive: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('students-dt') }}",
                type: "POST",
                error: function () {}
            },
            columns: [
                {
                    name: 'id',
                    data: 'id'
                },
                {
                    name: null,
                    data: null,
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'student_name',
                    name: 'student_name',
                },
                {
                    name: 'roll_no',
                    data: 'roll_no',
                },
                {
                    name: 'class',
                    data: 'class',
                },
                {
                    name: 'scores_sum_score',
                    data: 'scores_sum_score',
                    searchable: false
                },
                {
                    name: 'scores.score',
                    data: 'scores',
                    visible: false
                },
            ],
            columnDefs: [
                {
                    targets: 1,
                    render: function(type, row, data, meta) {
                        return `<img src="${data.photo}" height="50px">`;
                    }
                },
            ],
        });
    </script>
@endsection
