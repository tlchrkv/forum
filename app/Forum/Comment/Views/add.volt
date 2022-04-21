<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
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
    <h1 class="title">Add comment</h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/">All categories</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/{{ category.slug }}">{{ category.name }}</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/{{ category.slug }}/{{ topic.slug }}">{{ topic.name }}</a>
        </li>
        <li class="breadcrumbs-item active">Add comment</li>
      </ol>
    </nav>

    {% if replyTo is not null %}
      <div style="padding-left: 4px;
    border-left: 2px solid #6d757d;
    margin-bottom: 24px;
    margin-left: 4px;
    color: #6d757d;
    font-size: 14px;">
        {{ replyTo.content }}
      </div>
    {% endif %}

    {% if error is not null %}
      <div class="error" style="color: #e30000;
    width: 100%;
    margin-bottom: 24px;margin-top: -8px;">
        {{ error }}
      </div>
    {% endif %}

    <form action="/{{ category.slug }}/{{ topic.slug }}/add-comment" method="post" enctype="multipart/form-data">
      {% if replyTo is not null %}
        <input type="hidden" name="reply_to" value="{{ replyTo.id }}" />
      {% endif %}
      <div class="margin-bottom-16">
        {% if content is not null %}
          <textarea class="form-input" name="content" rows="3" placeholder="Type your comment here..." required>{{ content }}</textarea>
        {% else %}
          <textarea class="form-input" name="content" rows="3" placeholder="Type your comment here..." required></textarea>
        {% endif %}
      </div>
      <div>
        <input name="images[]" type="file" multiple />
      </div>
      <button class="form-button" type="submit">Add comment</button>
    </form>
  </div>
</main>
</body>
</html>
