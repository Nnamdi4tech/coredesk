@extends('layouts.admin')

@section('content')
<h3>Students in Class</h3>

<table border="1" width="100%">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Action</th>
    </tr>

    @foreach($students as $index => $student)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $student->name }}</td>
        <td>
            <a href="{{ route('tenant.admin.results.student', $subdomain) . '?student_id=' . $student->id]) }}">
                View Result
            </a>
        </td>
    </tr>
    @endforeach
</table>
@endsection  