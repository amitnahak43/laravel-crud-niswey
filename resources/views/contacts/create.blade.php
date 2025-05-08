<!DOCTYPE html>
<html>
    <head>
        <title>Create Contact</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Add New Contact</h1>

            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone:</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('contacts.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </body>
</html>