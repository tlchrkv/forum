<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/content.css">
</head>
<body>

  <header>
    <div class="page-box header-main">
      <div class="header-logo">
        <span>{{ appName }}</span>
      </div>
      {% if user is not null %}
        <div class="username" style="display: flex;
    align-items: center;
    color: #adafb3;text-transform: lowercase;
    font-weight: 500;font-size: 15px;">
          <span style="margin-right: 4px">{{ user.name }}</span>
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
      <h1 class="page-name-editable">{{ category['name'] }}</h1>

      <nav>
        <ol class="breadcrumbs">
          <li class="breadcrumbs-item">
            <a href="/">All categories</a>
          </li>
          <li class="breadcrumbs-item active">{{ category['name'] }}</li>
        </ol>
      </nav>

      {% if topicAccess.canAdd() %}
        <a class="over-list-button" href="/{{ category['slug'] }}/add-topic">
          <div>Add topic</div>
          <span class="icon material-icons">add</span>
        </a>
      {% endif %}

      <div class="list">
        {% for topic in topics %}
          <a class="list-item" href="/{{ category['slug'] }}/{{ topic['slug'] }}">
            <div>
              <div>{{ topic['name'] }}</div>
              <div class="list-item-sub">
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
            {% if page > 1 %}
              <a class="pagination-action" href="/{{ category['slug'] }}?page={{ page - 1 }}">Back</a>
            {% endif %}
            {% if page < pages %}
              <a class="pagination-action" href="/{{ category['slug'] }}?page={{ page + 1 }}">Next</a>
            {% endif %}
          </div>
        </div>
      {% endif %}
    </div>
  </main>

  <br/>
</body>
</html>
