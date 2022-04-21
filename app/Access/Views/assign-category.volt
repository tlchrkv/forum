<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/form.css">

  <link rel="stylesheet" href="/assets/css/pages/assign-category.css">
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
    <h1 class="title">Assign category</h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/users">Users</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/users/{{ user1.id }}">{{ user1.name }}</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/access/users/{{ user1.id }}/moderate-categories">Moderate categories</a>
        </li>
        <li class="breadcrumbs-item active">Assign category</li>
      </ol>
    </nav>

    <form action="/access/users/{{ user1.id }}/assign-category" method="post">
      <div>
        <select name="category_id" class="form-input">
          {% for category in categories %}
            <option value="{{ category.id }}">{{ category.name }}</option>
          {% endfor %}
        </select>
      </div>
      <button type="submit" class="form-button">Assign</button>
    </form>
  </div>
</main>
</body>
</html>
