<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <link rel="stylesheet" href="/assets/css/shared.css">
  <link rel="stylesheet" href="/assets/css/header.css">

  <link rel="stylesheet" href="/assets/css/breadcrumbs.css">
  <link rel="stylesheet" href="/assets/css/pagination.css">
  <link rel="stylesheet" href="/assets/css/form.css">

  <link rel="stylesheet" href="/assets/css/pages/topic.css">
</head>
<body>

  <section class="main-section">
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
        <div class="author">
          <div>
            <span class="icon material-icons-outlined">account_box</span>
            <span>{{ topic['author_name'] }}</span>
          </div>
        </div>

        <h1 class="title">
          <span>{{ topic['name'] }}</span>
          {% if topicAccess.canChange(topic['category_id'], topic['author_id']) %}
            <a href="/topics/{{ topic['id'] }}" class="icon material-icons">edit</a>
          {% endif %}
        </h1>

        <nav>
          <ol class="breadcrumbs">
            <li class="breadcrumbs-item">
              <a href="/">All categories</a>
            </li>
            <li class="breadcrumbs-item">
              <a href="/{{ category['slug'] }}">{{ category['name'] }}</a>
            </li>
            <li class="breadcrumbs-item active">{{ topic['name'] }}</li>
          </ol>
        </nav>

        {% if images|length > 0 %}
          <div class="margin-bottom-16">
            {% for image in images %}
              <a href="/images/{{ image.id }}" target="_blank">
                <img style="max-width: 160px;max-height: 160px;" src="/images/{{ image.id }}">
              </a>
            {% endfor %}
          </div>
        {% endif %}

        <div class="content">{{ topic['content'] }}</div>

      </div>
    </main>

    {% if comments|length > 0 %}
      <section class="comments-section">
        <div class="page-box">
          <div>
            <div class="secondary-title">{{ topic['comments_count'] }} {{ topic['comments_count'] == 1 ? 'Comment' : 'Comments' }}</div>
          </div>

          <div>
            {% for comment in comments %}
              <div class="comment">
                <div class="comment-author">
                  <span class="icon material-icons-outlined">account_box</span>
                  <span>{{ comment['author_name'] }}</span>
                </div>

                {% if comment['reply_to_content'] is not null %}
                  <div style="padding-left: 4px;
    border-left: 2px solid #6d757d;
    margin-bottom: 4px;
    margin-left: 4px;
    color: #6d757d;
    font-size: 13px;">
                    {{ comment['reply_to_content'] }}
                  </div>
                {% endif %}

                {% if commentImages[comment['id']] is not null %}
                  <div style="margin-top: 8px;margin-bottom: 8px;">
                    {% for imageId in commentImages[comment['id']] %}
                      <a href="/images/{{ imageId }}" target="_blank">
                        <img style="max-width: 90px;max-height: 90px;" src="/images/{{ imageId }}">
                      </a>
                    {% endfor %}
                  </div>
                {% endif %}

                <div class="comment-content">
                  {{ comment['content'] }}
                </div>

                <div class="comment-actions">
                  <a href="/{{ category['slug'] }}/{{ topic['slug'] }}/add-comment?reply_to={{ comment['id'] }}">
                    <span class="icon material-icons">reply</span>
                    <span class="comment-action-text">Reply</span>
                  </a>

                  {% if commentAccess.canChange(category['id'], comment['author_id']) %}
                    <a href="/comments/{{ comment['id'] }}">
                      <span class="icon material-icons">edit</span>
                      <span class="comment-action-text">Edit</span>
                    </a>
                  {% endif %}

                  {% if commentAccess.canDelete(category['id'], comment['author_id']) %}
                    <a href="/comments/{{ comment['id'] }}/delete">
                      <span class="icon material-icons">delete</span>
                      <span class="comment-action-text">Delete</span>
                    </a>
                  {% endif %}
                </div>
              </div>
            {% endfor %}
          </div>

          {% if pages > 1 %}
            <div class="pagination">
              <span>{{ page }} of {{ pages }} pages</span>
              <div>
                {% if page > 2 %}
                  <a class="pagination-action" href="/{{ category['slug'] }}/{{ topic['slug'] }}?page=1">First page</a>
                {% endif %}
                {% if page > 1 %}
                  <a class="pagination-action" href="/{{ category['slug'] }}/{{ topic['slug'] }}?page={{ page - 1 }}">Back</a>
                {% endif %}
                {% if page < pages %}
                  <a class="pagination-action" href="/{{ category['slug'] }}/{{ topic['slug'] }}?page={{ page + 1 }}">Next</a>
                {% endif %}
                {% if page < pages and (pages - page) > 1 %}
                  <a class="pagination-action" href="/{{ category['slug'] }}/{{ topic['slug'] }}?page={{ pages }}">Last page</a>
                {% endif %}
              </div>
            </div>
          {% endif %}
        </div>
      </section>
    {% endif %}
  </section>

  <section class="add-comment-section">
    <form class="page-box" method="post" action="/{{ category['slug'] }}/{{ topic['slug'] }}/add-comment" enctype="multipart/form-data">
      <div class="secondary-title">Add comment</div>
      <div>
        <textarea class="form-input" rows="3" name="content" required placeholder="Type your comment here..."></textarea>
      </div>
      <div style="margin-top: 8px;">
        <input name="images[]" type="file" multiple />
      </div>
      <button class="form-button" type="submit">Add comment</button>
    </form>
  </section>

</body>
</html>
