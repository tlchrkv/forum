<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/form.css">
  <link rel="stylesheet" href="/assets/css/clickable-list.css">

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
    <h1 class="title">Edit comment</h1>

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
        <li class="breadcrumbs-item active">Edit comment</li>
      </ol>
    </nav>

    {% if error is not null %}
      <div class="error" style="color: #e30000;
    width: 100%;
    margin-bottom: 24px;margin-top: -8px;">
        {{ error }}
      </div>
    {% endif %}

    <form action="/comments/{{ comment.id }}" method="post" enctype="multipart/form-data">
      <div class="margin-bottom-16">
        <textarea class="form-input" name="content" rows="3" placeholder="Content">{{ content is not null ? content : comment.content }}</textarea>
      </div>
      <div>
        <input name="images[]" type="file" multiple />
      </div>
      <button class="form-button" type="submit">Update</button>
    </form>

    <div class="clickable-list margin-top-24 margin-bottom-32">
      {% for image in images %}
        <div class="clickable-list-item">
          <div>
            <a href="/images/{{ image.id }}" target="_blank">
              <img style="max-width: 160px;max-height: 160px;" src="{{ image.getImageBase64Content() }}">
            </a>
          </div>
          <a href="/files/{{ image.id }}/delete?redirect_to=/comments/{{ comment.id }}" class="icon material-icons">delete</a>
        </div>
      {% endfor %}
    </div>
  </div>
</main>
</body>
</html>
