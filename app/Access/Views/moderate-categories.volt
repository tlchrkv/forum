<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <style>
      a {
          color: #135083;
          /*text-decoration: none;*/
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
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="/users">Users</a></li>
      <li class="breadcrumb-item active" aria-current="page">Moderate categories for {{ user1.name }}</li>
    </ol>
  </nav>

  <h1 class="card-title" style="margin-bottom: 2rem">Moderate categories for {{ user1.name }}</h1>

  <a href="/access/users/{{ user1.id }}/assign-category" class="btn btn-primary" style="margin-bottom: 2rem">Assign new category</a>

  {% for category in categories %}
    <div class="" style="margin-bottom: 1rem;">
      <div class="">
        <div class="d-flex justify-content-between">
          <div class="fw-bold">{{ category.getCategory().name }}</div>
          <div>
            <a href="/access/users/{{ user1.id }}/moderate-categories/{{ category.category_id }}/delete" style="margin-right: 5px">Delete</a>
          </div>
        </div>
      </div>
    </div>
  {% endfor %}

</div>
</body>
</html>
