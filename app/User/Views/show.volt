<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/clickable-list.css">

  <link rel="stylesheet" href="/assets/css/pages/user.css">
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
    <h1 class="title">
      <span class="icon material-icons-outlined" style="font-size: 36px;vertical-align: middle;">account_box</span>
      {{ user1.name }}
    </h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/users">Users</a>
        </li>
        <li class="breadcrumbs-item active">{{ user1.name }}</li>
      </ol>
    </nav>

    <div class="clickable-list">
      <a class="clickable-list-item" href="/access/users/{{ user1.id }}/assign-role">
        <div>
          <div style="display: flex;align-items: center;">
            <span class="icon material-icons-outlined" style="margin-right: 8px;margin-top: 2px;font-size: 18px;">switch_access_shortcut</span>
            <span>Assign new role</span>
          </div>
          <div class="clickable-list-item-sub" style="font-size: 12px; text-transform: uppercase;margin-top: 1px;margin-left: 27px;color: #b4b6ba;">
            <span>{{ user1.role }}</span>
          </div>
        </div>
        <span class="icon material-icons-outlined">keyboard_arrow_right</span>
      </a>

      {% if user1.role == 'moderator' %}
        <a class="clickable-list-item" href="/access/users/{{ user1.id }}/moderate-categories">
          <div>
            <div style="display: flex;align-items: center;">
              <span class="icon material-icons-outlined" style="margin-right: 8px;margin-top: 2px;font-size: 18px;">checklist</span>
              <span>Moderate categories</span>
            </div>
          </div>
          <span class="icon material-icons-outlined">keyboard_arrow_right</span>
        </a>
      {% endif %}

      <a class="clickable-list-item" href="/users/{{ user1.id }}/delete">
        <div>
          <div style="display: flex;align-items: center;">
            <span class="icon material-icons-outlined" style="margin-right: 8px;margin-top: 2px;font-size: 18px;color: #e30000;">delete</span>
            <span style="color: #e30000;">Delete user</span>
          </div>
        </div>
        <span class="icon material-icons-outlined">keyboard_arrow_right</span>
      </a>
    </div>
  </div>
</main>

<br/>
</body>
</html>
