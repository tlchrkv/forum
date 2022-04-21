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
    <h1 class="title">Edit topic</h1>

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
        <li class="breadcrumbs-item active">Edit</li>
      </ol>
    </nav>

    {% if error is not null %}
      <div class="error" style="color: #e30000;
    width: 100%;
    margin-bottom: 24px;margin-top: -8px;">
        {{ error }}
      </div>
    {% endif %}

    <form action="/topics/{{ topic.id }}" method="post" enctype="multipart/form-data">
      <div class="margin-bottom-16">
        <input class="form-input" name="name" placeholder="Name of the topic" value="{{ name is not null ? name : topic.name }}" />
      </div>
      <div id="editor" style="display: none;height: 375px;" class="margin-bottom-16">
        {{ content is not null ? content : topic.content }}
      </div>
      <div class="margin-bottom-16">
        <textarea class="form-input" name="content" rows="9" placeholder="Content">{{ content is not null ? content : topic.content }}</textarea>
      </div>
      <div>
        <input type="file" name="images[]" multiple />
      </div>
      <div style="display: flex; justify-content: space-between;">
        <button class="form-button" type="submit">Update</button>
        {% if topicAccess.canDelete(topic.category_id, topic.created_by) %}
          <a href="/topics/{{ topic.id }}/delete" class="form-button">
            <span class="icon material-icons" style="margin-right: 4px">delete</span>
            Delete topic
          </a>
        {% endif %}
      </div>
    </form>

    <div class="clickable-list margin-top-24 margin-bottom-32">
      {% for image in images %}
        <div class="clickable-list-item">
          <div>
            <a href="/images/{{ image.id }}" target="_blank">
              <img style="max-width: 160px;max-height: 160px;" src="{{ image.getImageBase64Content() }}">
            </a>
          </div>
          <a href="/files/{{ image.id }}/delete?redirect_to=/topics/{{ topic.id }}" class="icon material-icons">delete</a>
        </div>
      {% endfor %}
    </div>
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
