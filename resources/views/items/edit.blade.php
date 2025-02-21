<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Редактирование Item</h1>

        <form action="{{ route('items.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Allowed" {{ $item->status == 'Allowed' ? 'selected' : '' }}>Allowed</option>
                    <option value="Prohibited" {{ $item->status == 'Prohibited' ? 'selected' : '' }}>Prohibited</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
</body>
</html>