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

  <link rel="stylesheet" href="/assets/quill/quill.snow.css">
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
    <h1 class="title">Add topic</h1>

    <nav>
      <ol class="breadcrumbs">
        <li class="breadcrumbs-item">
          <a href="/">All categories</a>
        </li>
        <li class="breadcrumbs-item">
          <a href="/{{ category.slug }}">{{ category.name }}</a>
        </li>
        <li class="breadcrumbs-item active">New topic</li>
      </ol>
    </nav>

    {% if error is not null %}
      <div class="error" style="color: #e30000;
    width: 100%;
    margin-bottom: 24px;margin-top: -8px;">
        {{ error }}
      </div>
    {% endif %}

    <form action="/{{ category.slug }}/add-topic" method="post" enctype="multipart/form-data">
      <div class="margin-bottom-16">
        <input class="form-input" name="name" placeholder="Name of the topic" {% if name is not null %} value="{{ name }}" {% endif %} />
      </div>
      <div id="editor" style="display: none;height: 375px;" class="margin-bottom-16"></div>
      <div class="margin-bottom-16">
        {% if content is not null %}
          <textarea class="form-input" name="content" rows="9" placeholder="Content">{{ content }}</textarea>
        {% else %}
          <textarea class="form-input" name="content" rows="9" placeholder="Content"></textarea>
        {% endif %}
      </div>
      <div>
        <input type="file" name="images[]" multiple />
      </div>
      <button class="form-button" type="submit">Add topic</button>
    </form>
  </div>
</main>
<script src="/assets/quill/quill.js"></script>
<script>
  var textarea = document.querySelector('textarea[name=content]');
  textarea.style.display = 'none';

  document.querySelector('#editor').style.display = 'block';

  var quill = new Quill('#editor', {
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline'],
        ['code-block']
      ]
    },
    placeholder: 'Content',
    theme: 'snow'
  });

  var form = document.querySelector('form');
  form.onsubmit = function() {
    textarea.value = document.querySelector('.ql-editor').innerHTML;
  }
</script>
</body>
</html>
