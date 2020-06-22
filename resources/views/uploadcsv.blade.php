@extends('layouts.app')
@section('content')
    <div class="container">
        <!-- Message -->
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif

        <h1 style="font-family: 'Montserrat', sans-serif;">Upload New Dataset</h1>
        <!-- Upload Form -->
        @if((Auth::user()->username)=='admin')
            <form class="form" method='post' action='{{ url('uploadFile') }}' enctype='multipart/form-data'
                  id="submitFile">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="year">Year</label>
                        <select id="year" name="year" class="form-control" required>
                            <option selected>2019</option>
                            <option>2020</option>
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                            <option>2024</option>
                            <option>2025</option>
                            <option>2026</option>
                            <option>2027</option>
                            <option>2028</option>
                            <option>2029</option>
                            <option>2030</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exam">Exam</label>
                        <select id="exam" name="exam" class="form-control" required>
                            <option selected>Grade 5 Scholarship</option>
                            <option>Ordinary Level</option>
                            <option>Advanced Level</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputCSV">CSV File</label>
                        <input type='file' id="inputCSV" name='file' required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="submitBtn"></label>
                        <input type='submit' name='submit' value='Import' id="submitBtn"
                               class="btn btn-block btn-danger">
                    </div>
                </div>
            </form>
        @else
            <div class="h1">Access denied. Log in as admin!</div>
        @endif

    </div>
    <hr>
    <div class="container">
        <h1 style="font-family: 'Montserrat', sans-serif;">Upload History
            <button type="button" class="btn btn-outline-dark">
                Datasets <span
                    class="badge badge-dark">{{\DB::table('exam_students_upload')->count()}}</span>
            </button>
            <button type="button" class="btn btn-dark">
                Processed Students <span
                    class="badge badge-light">{{$studentCount=\DB::table('examination_students')->count()}}</span>
            </button>
        </h1>
        <br>
        <div class="panel panel-default">
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Filename</th>
                            <th>Year</th>
                            <th>Exam</th>
                            <th>NSID Status</th>
                            <th>SIS DB Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $.fn.dataTable.ext.errMode = 'throw';
            $('#table').DataTable({
                processing: false,
                serverSide: true,
                ajax: '{{ url('uploadFileData') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'filename', name: 'filename'},
                    {data: 'year', name: 'year'},
                    {data: 'exam', name: 'exam'},
                    {data: 'nsid_status', name: 'nsid_status'},
                    {data: 'db_status', name: 'db_status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });

        function downloadFile() {
            window.location.href = '{{ url('exportexamination') }}'
        }
    </script>
@endsection

