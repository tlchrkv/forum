<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/append-button.css">
  <link rel="stylesheet" href="/assets/css/clickable-list.css">
  <link rel="stylesheet" href="/assets/css/pagination.css">

  <link rel="stylesheet" href="/assets/css/pages/users.css">
</head>
<body>

<header>
  <div class="page-box header-main">
    <div class="header-logo">
      <span>{{ appName }}</span>
    </div>
    {% if user is not null %}
      <div class="username">
        <span>{{ user.name }}</span>
        <span class="material-icons-outlined">account_box</span>
      </div>
    {% endif %}
  </div>

  <div class="page-box header-menu">
    <div>
      <a class="margin-right-8 text-gray" href="/">Topics</a>
      <span class="margin-right-8 text-primary">Users</span>
      {% if user is null %}
        <a class="text-gray" href="/login">Login</a>
      {% else %}
        <a class="text-gray" href="/logout">Logout</a>
      {% endif %}
    </div>
  </div>
</header>

<main>
  <div class="page-box">
    <h1 class="title">Users</h1>

    {% if topicAccess.canAdd() %}
      <a class="append-button margin-bottom-16" href="/add-user">
        <div>Add user</div>
        <span class="icon material-icons">add</span>
      </a>
    {% endif %}

    <div class="clickable-list">
      {% for user in users %}
        <a class="clickable-list-item" href="/users/{{ user.id }}">
          <div>
            <div>{{ user.name }}</div>
            <div class="clickable-list-item-sub">
              <span class="icon material-icons-outlined">group</span>
              <span>{{ user.role }}</span>
            </div>
          </div>
          <span class="icon material-icons">edit</span>
        </a>
      {% endfor %}
    </div>

    {% if pages > 1 %}
      <div class="pagination">
        <span>{{ page }} of {{ pages }} pages</span>
        <div>
          {% if page > 2 %}
            <a class="pagination-action" href="/users?page=1">First page</a>
          {% endif %}
          {% if page > 1 %}
            <a class="pagination-action" href="/users?page={{ page - 1 }}">Back</a>
          {% endif %}
          {% if page < pages %}
            <a class="pagination-action" href="/users?page={{ page + 1 }}">Next</a>
          {% endif %}
          {% if page < pages and (pages - page) > 1 %}
            <a class="pagination-action" href="/users?page={{ pages }}">Last page</a>
          {% endif %}
        </div>
      </div>
    {% endif %}
  </div>
</main>

<br/>
</body>
</html>
