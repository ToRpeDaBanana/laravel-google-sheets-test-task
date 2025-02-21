<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Просмотр Item</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $item->name }}</h5>
                <p class="card-text"><strong>Статус:</strong> {{ $item->status }}</p>
                <p class="card-text"><strong>Создано:</strong> {{ $item->created_at }}</p>
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">Редактировать</a>
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Назад</a>
            </div>
        </div>
    </div>
</body>
</html>