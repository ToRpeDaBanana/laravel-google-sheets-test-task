<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1 class="text-center mb-4">Список</h1>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('items.create') }}" class="btn btn-success">+ Создать новую запись</a>

            <div class="btn-group">
                <form action="{{ route('items.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">📄 Сгенерировать 1000 записей</button>
                </form>
                <a href="{{ route('items.clear') }}" class="btn btn-danger">🗑️ Очистить таблицу</a>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center">{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status == 'Allowed' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('items.show', $item->id) }}" class="btn btn-info btn-sm">Посмотреть</a>
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Пагинация -->
        <div class="d-flex justify-content-center">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    </div>

</body>
</html>
