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
      <li class="breadcrumb-item active" aria-current="page">{{ category.name }}</li>
    </ol>
  </nav>

  <h1 class="card-title" style="margin-bottom: 1rem">{{ category.name }}</h1>

  <div class="d-flex" style="margin-bottom: 2rem">
    {% if categoryAccess.canChange(category.id) %}
      <a href="/categories/{{ category.id }}" style="margin-right: 5px">Edit</a>
    {% endif %}

    {% if categoryAccess.canDelete() %}
      <a href="/categories/{{ category.id }}/delete" style="margin-right: 5px">Delete</a>
    {% endif %}
  </div>

  {% if topicAccess.canAdd() %}
    <a href="/{{ category.slug }}/add-topic" class="btn btn-primary" style="margin-bottom: 2rem">New topic</a>
  {% endif %}

  <div class="" style="margin-bottom: 1rem;">
    <div class="" style="">
      <ul class="list-group list-group-flush">
        {% for topic in topics %}
          <li class="list-group-item">
            <a style="text-decoration: none;" href="/{{ category.slug }}/{{ topic.slug }}">{{ topic.name }}</a>
          </li>
        {% endfor %}
      </ul>
    </div>
  </div>

  {% if pages > 1 %}

  <nav style="margin-top: 2rem; margin-bottom: 2rem">
    <ul class="pagination">
      {% for i in 1..pages %}
        <li class="page-item {% if page is i %} active {% endif %}">
          <a class="page-link" href="/{{ category.slug }}?page={{ i }}">{{ i }}</a>
        </li>
      {% endfor %}
    </ul>
  </nav>

  {% endif %}

</div>
</body>
</html>
