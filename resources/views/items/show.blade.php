<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>View Item</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $item->name }}</h5>
                <p class="card-text"><strong>Status:</strong> {{ $item->status }}</p>
                <p class="card-text"><strong>Created At:</strong> {{ $item->created_at }}</p>
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</body>
</html>