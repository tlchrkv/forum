<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/content.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/append-button.css">
  <link rel="stylesheet" href="/assets/css/clickable-list.css">
  <link rel="stylesheet" href="/assets/css/pagination.css">

  <link rel="stylesheet" href="/assets/css/pages/category.css">
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
      <h1 class="title">
        <span>{{ category['name'] }}</span>
        {% if categoryAccess.canChange(category['id']) %}
          <a href="/categories/{{ category['id'] }}" class="icon material-icons">edit</a>
        {% endif %}
      </h1>

      <nav>
        <ol class="breadcrumbs">
          <li class="breadcrumbs-item">
            <a href="/">All categories</a>
          </li>
          <li class="breadcrumbs-item active">{{ category['name'] }}</li>
        </ol>
      </nav>

      {% if topicAccess.canAdd() %}
        <a class="append-button margin-bottom-16" href="/{{ category['slug'] }}/add-topic">
          <div>Add topic</div>
          <span class="icon material-icons">add</span>
        </a>
      {% endif %}

      <div class="clickable-list">
        {% for topic in topics %}
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

      {% if pages > 1 %}
        <div class="pagination">
          <span>{{ page }} of {{ pages }} pages</span>
          <div>
            {% if page > 2 %}
              <a class="pagination-action" href="/{{ category['slug'] }}?page=1">First page</a>
            {% endif %}
            {% if page > 1 %}
              <a class="pagination-action" href="/{{ category['slug'] }}?page={{ page - 1 }}">Back</a>
            {% endif %}
            {% if page < pages %}
              <a class="pagination-action" href="/{{ category['slug'] }}?page={{ page + 1 }}">Next</a>
            {% endif %}
            {% if page < pages and (pages - page) > 1 %}
              <a class="pagination-action" href="/{{ category['slug'] }}?page={{ pages }}">Last page</a>
            {% endif %}
          </div>
        </div>
      {% endif %}
    </div>
  </main>

  <br/>
</body>
</html>
