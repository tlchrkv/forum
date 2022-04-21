<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/form.css">

  <link rel="stylesheet" href="/assets/css/pages/add-user.css">
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
    <h1 class="title">Add user</h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/users">Users</a>
        </li>
        <li class="breadcrumbs-item active">New</li>
      </ol>
    </nav>

    {% if error is not null %}
      <div class="error max-width-280 margin-bottom-16" style="color: #e30000;width: 100%;">
        {{ error }}
      </div>
    {% endif %}

    <form action="/add-user" method="post">
      <div class="margin-bottom-16 max-width-280">
        <input class="form-input" name="name" placeholder="Username" {% if name is not null %} value="{{ name }}" {% endif %} required />
      </div>
      <div class="max-width-280">
        <input class="form-input" type="password" name="password" placeholder="Password" required />
      </div>
      <button class="form-button" type="submit">Add user</button>
    </form>
  </div>
</main>
</body>
</html>
