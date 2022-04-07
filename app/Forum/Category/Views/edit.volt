<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <style>
      a {
          color: #135083;
      }
  </style>
</head>
<body>
<div class="container" style="max-width: 720px">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-3 mt-3">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">. . .</a>

    <div class="col-md-3 text-end">
      {% if user is null %}
        <a href="/login" class="text-dark text-decoration-none">Login</a>
      {% else %}
        <span style="color: gray">{{ user.name }}</span>
        <span style="color: gray"> | </span>
        {% if userAccess.canManageUsers() %}
          <a href="/users" class="text-dark text-decoration-none">Users</a>
          <span style="color: gray"> | </span>
        {% endif %}
        <a href="/logout" class="text-dark text-decoration-none">Logout</a>
      {% endif %}
    </div>
  </header>

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">All categories</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit {{ category.name }}</li>
    </ol>
  </nav>

  <h1 class="card-title" style="margin-bottom: 2rem">Edit {{ category.name }}</h1>

  <form action="/categories/{{ category.id }}" method="post" style="margin-bottom: 2rem">
    <div class="mb-3">
      <input class="form-control" name="name" placeholder="Category name" value="{{ category.name }}" />
    </div>
    <button type="submit" class="btn btn-primary">Save changes</button>
  </form>

</div>
</body>
</html>
