<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/append-button.css">
  <link rel="stylesheet" href="/assets/css/clickable-list.css">

  <link rel="stylesheet" href="/assets/css/pages/moderate-categories.css">
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
      {% if userAccess.canManageUsers() %}
        <span class="margin-right-8 text-primary">Users</span>
      {% endif %}
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
    <h1 class="title">Moderate categories</h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/users">Users</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/users/{{ user1.id }}">{{ user1.name }}</a>
        </li>
        <li class="breadcrumbs-item active">Moderate categories</li>
      </ol>
    </nav>

    <a class="append-button margin-bottom-16" href="/access/users/{{ user1.id }}/assign-category">
      <div>Assign category</div>
      <span class="icon material-icons">add</span>
    </a>

    <div class="clickable-list">
      {% for category in categories %}
        <div class="clickable-list-item">
          <div>
            <div>{{ category.getCategory().name }}</div>
          </div>
          <a href="/access/users/{{ user1.id }}/moderate-categories/{{ category.category_id }}/delete" class="icon material-icons">delete</a>
        </div>
      {% endfor %}
    </div>
  </div>
</main>
</body>
</html>
