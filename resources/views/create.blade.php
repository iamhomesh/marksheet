@extends('layouts.app', ['pageTitle' => 'Create Student'])
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Create Student Mark sheet</h5>
        </div>
        <div class="card-body">
            <p><strong class="text-danger">All the fields are required</strong></p>
            <form id="studentForm" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="student_name" class="col-sm-2 col-form-label">Student Name *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="student_name" name="student_name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roll_no" class="col-sm-2 col-form-label">Roll No *</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="roll_no" name="roll_no" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="photo" class="col-sm-2 col-form-label">Photo *</label>
                    <div class="col-sm-10">
                        <div>
                            <img src="{{ asset('student.jpg') }}" alt="Passport size photo" id="photo-preview" height="200px">
                        </div>
                        <input class="form-control" type="file" accept=".jpeg,.jpg,.png" id="photo" name="photo" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="class" class="col-sm-2 col-form-label">Class *</label>
                    <div class="col-sm-10">
                        @foreach($classes as $class)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="class" value="{{ $class }}" id="class_{{ $class }}" {{ $loop->index == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="class_{{ $class }}">
                                {{ $class }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $index => $subject)
                        <tr>
                            <td>
                                {{ $subject->name }}
                                <input class="form-control" type="hidden" value="{{ $subject->id }}" id="subjects_{{ $index }}_subject_id" name="subjects[{{$index}}][subject_id]" required>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td>
                                <input class="form-control" type="number" placeholder="Ex. 55" id="subjects_{{ $index }}_score" name="subjects[{{$index}}][score]" required>
                                <div class="invalid-feedback"></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    <button class="btn btn-danger" id="submit-button">Submit</button>
                    <button type="button" class="btn btn-success" id="cancel-button">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>

        $(document).on('click', '#cancel-button', function () {
            if (confirm('Are sure want to cancel?')) {
                window.location = "{{ route('index') }}";
            }
        });

        $('#photo').change(function() {
            $('#photo-preview').attr('src', window.URL.createObjectURL(this.files[0]))
        })

        $('#studentForm').submit(function (event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);
            $('button').prop('disabled', true)
            $('.is-invalid').removeClass('is-invalid')
            $.ajax({
                url: "{{ route("store") }}",
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.status) {
                        alert(result.message);
                        setTimeout(function () {
                            window.location = "{{ route('index') }}"
                        }, 100);
                    } else {
                        alert(result.message);
                    }
                    $('button').prop('disabled', false)
                },
                error: function (jqXhr, json, errorThrown) {
                    let data = jqXhr.responseJSON;
                    if (data.errors) {
                        $.each(data.errors, function (index, item) {
                            index = index.replace(/\./g, "_")
                            $(`#${index}`).addClass("is-invalid");
                            $(`#${index}`).next('.invalid-feedback').text(item[0]);
                        })
                    }
                    $('button').prop('disabled', false)
                },
            });
        });


    </script>
@endsection
