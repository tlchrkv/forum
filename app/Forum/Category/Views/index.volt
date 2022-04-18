<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/clickable-list.css">
  <link rel="stylesheet" href="/assets/css/pagination.css">

  <link rel="stylesheet" href="/assets/css/pages/categories.css">
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
      <h1 class="title">All Categories</h1>

      {% if categoryAccess.canAdd() %}
        <a class="over-list-button" href="/add-category">
          <div>Add category</div>
          <span class="icon material-icons">add</span>
        </a>
      {% endif %}

      {% for category in categories %}
        <div class="secondary-title">
          <h2>
            <a href="/{{ category['slug'] }}">{{ category['name'] }}</a>
          </h2>
          <a class="secondary-title-action" href="/{{ category['slug'] }}">See all {{ category['topics_count']}} topics</a>
        </div>

        <div class="clickable-list">
          {% for topic in category['last_topics'] %}
            <a class="clickable-list-item" href="/{{ category['slug'] }}/{{ topic['slug'] }}">
              <div>
                <div>{{ topic['name'] }}</div>
                <div class="clickable-list-item-sub">
                  <span class="icon material-icons-outlined">mode_comment</span>
                  <span>{{ topic['comments_count'] == 0 ? 'no comments yet' : topic['comments_count'] }}</span>
                </div>
              </div>
              <span class="icon material-icons">keyboard_arrow_right</span>
            </a>
          {% endfor %}
        </div>

      {% endfor %}
    </div>
  </main>

  <br/>
</body>
</html>
