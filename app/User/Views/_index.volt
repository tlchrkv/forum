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
      <li class="breadcrumb-item active" aria-current="page">Users</li>
    </ol>
  </nav>

  <h1 class="card-title" style="margin-bottom: 2rem">Users</h1>

  <a href="/add-user" class="btn btn-primary" style="margin-bottom: 2rem">Add user</a>

  {% for user in users %}
    <div class="" style="margin-bottom: 1rem;">
      <div class="">
        <div class="d-flex justify-content-between">
          <div class="fw-bold">{{ user.name }} ({{ user.role }})</div>
          <div>
            {% if user.role == 'moderator' %}
              <a href="/access/users/{{ user.id }}/moderate-categories" style="margin-right: 5px">Moderate categories</a>
            {% endif %}
            <a href="/access/users/{{ user.id }}/assign-role" style="margin-right: 5px">Assign role</a>
            <a href="/users/{{ user.id }}/delete" style="margin-right: 5px">Delete</a>
          </div>
        </div>
      </div>
    </div>
  {% endfor %}

  {% if pages > 1 %}

    <nav style="margin-top: 2rem">
      <ul class="pagination">
        {% for i in 1..pages %}
          <li class="page-item {% if page is i %} active {% endif %}">
            <a class="page-link" href="/users?page={{ i }}">{{ i }}</a>
          </li>
        {% endfor %}
      </ul>
    </nav>

  {% endif %}

</div>
</body>
</html>
