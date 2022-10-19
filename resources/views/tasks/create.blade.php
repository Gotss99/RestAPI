<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Task</title>
</head>
<body>
    <div>
        <a href="{{ route('tasks.index') }}">Back</a>
    </div>

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($error = Session::get('error'))
            <p>{{ $error }}</p>
        @endif
        <div>
            <label for="">Name</label>
            <input type="text" name="name" >
        </div>
        <div>
            <label for="">Description</label>
            <input type="text" name="desc" >
        </div>
        <button type="submit">Submit</button>

    </form>
</body>
</html>
