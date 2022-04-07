<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <style>
      a {
          color: #135083;
      }
  </style>
</head>
<body>
<div class="container" style="max-width: 720px">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-3 mt-3">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">. . .</a>

    <div class="col-md-3 text-end">
      {% if user is null %}
        <a href="/login" class="text-dark text-decoration-none">Login</a>
      {% else %}
        <span style="color: gray">{{ user.name }}</span>
        <span style="color: gray"> | </span>
        {% if userAccess.canManageUsers() %}
          <a href="/users" class="text-dark text-decoration-none">Users</a>
          <span style="color: gray"> | </span>
        {% endif %}
        <a href="/logout" class="text-dark text-decoration-none">Logout</a>
      {% endif %}
    </div>
  </header>

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">All categories</a></li>
      <li class="breadcrumb-item"><a href="/{{ category.slug }}">{{ category.name }}</a></li>
      <li class="breadcrumb-item"><a href="/{{ category.slug }}/{{ topic.slug }}">{{ topic.name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add comment</li>
    </ol>
  </nav>

  <h1 class="card-title" style="margin-bottom: 2rem">Add comment</h1>

  {% if replyTo is not null %}
    <div style="margin-bottom: 2rem">
      <h4 style="margin-bottom: 1rem">Reply to</h4>
      <div>
        <div class="fw-bold">{{ replyTo.created_by is null ? 'anonymous' : replyTo.getAuthorName() }}</div>
        <div style="font-size: 14px; color: gray">{{ replyTo.getReadableDate() }}</div>
        <div>{{ replyTo.content }}</div>
      </div>
    </div>
  {% endif %}

  <form action="/{{ category.slug }}/{{ topic.slug }}/add-comment" method="post" style="margin-bottom: 2rem">
    {% if replyTo is not null %}
      <input type="hidden" name="reply_to" value="{{ replyTo.id }}" />
    {% endif %}
    <div class="mb-3">
      <textarea class="form-control" name="content" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add comment</button>
  </form>

</div>
</body>
</html>
