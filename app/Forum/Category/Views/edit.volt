<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/append-button.css">
  <link rel="stylesheet" href="/assets/css/form.css">

  <link rel="stylesheet" href="/assets/css/pages/add-category.css">
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
      <span class="margin-right-8 text-primary">Topics</span>
      {% if userAccess.canManageUsers() %}
        <a class="margin-right-8 text-gray" href="/users">Users</a>
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
    <h1 class="title">Edit category</h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/">All categories</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/{{ category.slug }}">{{ category.name }}</a>
        </li>
        <li class="breadcrumbs-item active">Edit</li>
      </ol>
    </nav>

    <form action="/categories/{{ category.id }}" method="post">
      <div>
        <input class="form-input" name="name" placeholder="Name of the category" value="{{ category.name }}" />
      </div>
      <div style="display: flex;justify-content: space-between;">
        <button class="form-button" type="submit">Update</button>

        {% if categoryAccess.canDelete() %}
          <a class="form-button" href="/categories/{{ category.id }}/delete">
            <span class="icon material-icons" style="margin-right: 4px">delete</span>
            Delete category
          </a>
        {% endif %}
      </div>
    </form>
  </div>
</main>
</body>
</html>
