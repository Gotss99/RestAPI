<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>Task App</title>
</head>
<body>
    <div>
        <a href="{{ route('tasks.create') }}">Create Task</a>
    </div>

    @if ($success = Session::get('success'))
        <p>{{ $success}}</p>
    @endif
    <table>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->desc }}</td>
                <td>
                    <form action="{{ route('tasks.destroy',$task->id) }}" method="POST">

                        <a href="{{ route('tasks.edit',$task->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $tasks->links('pagination::bootstrap-5') !!}
</body>
</html>
