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

  <section>
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
        <div style="margin-top: 24px">
          <div style="display: flex;align-items: center;color: #6c757d;text-transform: lowercase; font-weight: 500;">
            <span class="material-icons-outlined" style="font-size: 20px; margin-right: 4px;">account_box</span>
            <span>mumbarak</span>
          </div>
        </div>

        <h1 class="page-name-editable" style="margin-top: 4px">{{ topic['name'] }}</h1>

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

        <div style="margin-top: 20px; margin-bottom: 32px;">{{ topic['content'] }}</div>

      </div>
    </main>
  </section>

  <section style="border-top: 8px solid #fcfcfc;padding-top: 16px;padding-bottom: 16px">
    <div class="page-box">
      {% if comments|length > 0 %}
        <div>
          <div class="mini-title">Comments</div>
        </div>

        <div>
          {% for comment in comments %}
            <div class="comment" style="margin-top: 14px;padding-bottom: 14px;border-bottom: 1px solid #f7f7f7;margin-left: 4px">
              <div class="comment-author" style="display: flex;
    align-items: center;
    margin-bottom: 8px;
    color: #adafb3;
    font-size: 13px;text-transform: lowercase; font-weight: 500">
                <span class="material-icons-outlined" style="font-size: 20px;
    margin-right: 4px;">account_box</span>
                <span>{{ comment['author_name'] }}</span>
              </div>

              <div class="comment-content" style="margin-bottom: 8px;margin-left: 1px">
                {{ comment['content'] }}
              </div>

              <div class="comment-sub" style="display: flex; align-items: center;">
                <a href="#" style="display: flex;
    align-items: center;
    margin-right: 12px;">
                  <span class="icon material-icons" style="color: #adafb3; font-size: 14px;margin-right: 3px;">reply</span>
                  <span style="color: #adafb3; font-size: 12px;">Reply</span>
                </a>

                <a href="#" style="display: flex;
    align-items: center;
    margin-right: 12px;">
                  <span class="icon material-icons" style="color: #adafb3; font-size: 14px;margin-right: 3px;">edit</span>
                  <span style="color: #adafb3; font-size: 12px;">Edit</span>
                </a>

                <a href="#" style="display: flex;
    align-items: center;
    margin-right: 12px;">
                  <span class="icon material-icons" style="color: #adafb3; font-size: 14px;margin-right: 3px;">delete</span>
                  <span style="color: #adafb3; font-size: 12px;">Delete</span>
                </a>
              </div>
            </div>
          {% endfor %}
        </div>
      {% endif %}

      {% if pages > 1 %}
        <div class="pagination">
          <span>{{ page }} of {{ pages }} pages</span>
          <div>
            {% if page > 1 %}
              <a class="pagination-action" href="/{{ category['slug'] }}/{{ topic['slug'] }}?page={{ page - 1 }}">Back</a>
            {% endif %}
            {% if page < pages %}
              <a class="pagination-action" href="/{{ category['slug'] }}/{{ topic['slug'] }}?page={{ page + 1 }}">Next</a>
            {% endif %}
          </div>
        </div>
      {% endif %}
    </div>
  </section>

  <section style="background-color: #fcfcfc;padding-top: 16px;padding-bottom: 16px;">
    <div class="page-box">
      <div class="mini-title">Add comment</div>
      <div>
        <textarea class="input" rows="3" placeholder="Type your comment here..."></textarea>
      </div>
      <button class="button">Add comment</button>
    </div>
  </section>

</body>
</html>
