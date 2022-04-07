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

    <div>
      <h1 class="card-title" style="margin-bottom: 2rem">All categories</h1>

      {% if categoryAccess.canAdd() %}
        <a href="/add-category" class="btn btn-primary" style="margin-bottom: 2rem">New category</a>
      {% endif %}

      {% for category in categories %}
        <div class="card" style="margin-bottom: 1rem;">
          <div class="card-body" style="padding: 2rem;">
            <h3 class="card-title" style="margin-bottom: 1rem">
              <a style="text-decoration: none;" href="/{{ category.slug }}">{{ category.name }}</a>
            </h3>
            <ul class="list-group list-group-flush">
              {% for topic in category.getLastTopics(5) %}
                <li class="list-group-item" >
                  <a style="text-decoration: none;" href="/{{ category.slug }}/{{ topic.slug }}">{{ topic.name }}</a>
                </li>
              {% endfor %}
            </ul>
          </div>
        </div>
      {% endfor %}
    </div>
  </div>
</body>
</html>
