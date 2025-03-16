<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>File Upload Management System</h1>
    <p class="lead">Upload PDF or DOCX files, and manage them easily!</p>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
@endif

<!-- Form for file upload -->
    <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Choose File</label>
            <input type="file" class="form-control" id="file" accept=".pdf, .docx, .doc" name="file" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <hr>

    <h2>Uploaded Files</h2>
    <ul class="list-group" id="file-list">
        @foreach ($files as $file)
            <li class="list-group-item" id="file-{{ $file->id }}">
                {{ $file->filename }}
                <span class="badge bg-info float-end">{{ $file->created_at->diffForHumans() }}</span>
                <button class="btn btn-danger btn-sm float-end ms-2 delete-file" data-id="{{ $file->id }}">Delete</button>
            </li>
        @endforeach
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.delete-file').on('click', function() {
            var fileId = $(this).data('id');

            if (confirm('Are you sure you want to delete this file?')) {
                $.ajax({
                    url: '/file/delete/' + fileId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: fileId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#file-' + fileId).remove();
                            alert(response.message);
                        } else {
                            alert('Error deleting file.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the file.');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
