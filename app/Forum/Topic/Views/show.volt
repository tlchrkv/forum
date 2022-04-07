<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <style>
      a {
          color: #135083;
          /*text-decoration: none;*/
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
      <li class="breadcrumb-item active" aria-current="page">{{ topic.name }}</li>
    </ol>
  </nav>

  <h1 class="card-title" style="margin-bottom: 2rem">{{ topic.name }}</h1>

  <div class="" style="margin-bottom: 2rem;">
    <div class="">
      {{ topic.content }}
    </div>
    <div class="d-flex" style="margin-top: 1rem">
      {% if topicAccess.canChange(topic.category_id, topic.created_by) %}
        <a href="/topics/{{ topic.id }}" style="margin-right: 5px">Edit</a>
      {% endif %}
      {% if topicAccess.canDelete(topic.category_id, topic.created_by) %}
        <a href="/topics/{{ topic.id }}/delete" style="margin-right: 5px">Delete</a>
      {% endif %}
    </div>
  </div>

  {% if comments|length > 0 %}

  <h4 class="card-title" style="margin-bottom: 1rem;">Comments</h4>

  {% for comment in comments %}
    <div class="" style="margin-bottom: 1rem;">
      <div class="">
        <div class="d-flex justify-content-between">
          <div class="fw-bold">{{ comment.created_by is null ? 'anonymous' : comment.getAuthorName() }}</div>
          <div>
            {% if commentAccess.canChange(category.id, comment.created_by) %}
              <a href="/comments/{{ comment.id }}" style="margin-right: 5px">Edit</a>
            {% endif %}
            {% if commentAccess.canDelete(category.id, comment.created_by) %}
              <a href="/comments/{{ comment.id }}/delete" style="margin-right: 5px">Delete</a>
            {% endif %}
            <a href="/{{ categorySlug }}/{{ topicSlug }}/add-comment?reply_to={{ comment.id }}">Reply</a>
          </div>
        </div>
        <div style="font-size: 14px; color: gray">{{ comment.getReadableDate() }}</div>
        {% if comment.reply_to is not null %}
          <div style="font-size: 14px;
    font-style: italic;
    margin-bottom: 4px;
    margin-top: 4px;">
            {% if comment.getReplyTo() is null %}
              <div class="fw-bold">"Comment deleted"</div>
            {% else %}
              <div class="fw-bold">"{{ comment.getReplyTo().created_by is null ? 'anonymous' : comment.getReplyTo().getAuthorName() }}</div>
              <div>{{ comment.getReplyTo().content }}"</div>
            {% endif %}
          </div>
        {% endif %}
        <div>{{ comment.content }}</div>
      </div>
    </div>
  {% endfor %}

  {% endif %}

  {% if pages > 1 %}

  <nav style="margin-top: 2rem">
    <ul class="pagination">
      {% for i in 1..pages %}
        <li class="page-item {% if page is i %} active {% endif %}">
          <a class="page-link" href="/{{ categorySlug }}/{{ topicSlug }}?page={{ i }}">{{ i }}</a>
        </li>
      {% endfor %}
    </ul>
  </nav>

  {% endif %}

  <h4 class="card-title" style="margin-bottom: 1rem;margin-top: 2rem">Add comment</h4>

  <form action="/{{ categorySlug }}/{{ topicSlug }}/add-comment" method="post" style="margin-bottom: 2rem">
    <div class="mb-3">
      <textarea class="form-control" id="commentContent" rows="3" name="content" placeholder="Write here..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add comment</button>
  </form>

</div>
</body>
</html>
