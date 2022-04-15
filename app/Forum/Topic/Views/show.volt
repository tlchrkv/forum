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

  <section style="min-height: calc(100vh - 340px)">
    <header>
      <div class="page-box header-main">
        <div class="header-logo">
          <img src="/assets/png/logo.png" />
          <span>Forumium</span>
        </div>
        {% if user is not null %}
          <div class="username">
            <span>{{ user.name }}</span>
            <span class="material-icons-outlined">account_circle</span>
          </div>
        {% endif %}
      </div>

      <div class="page-box header-menu">
        <div>
          <span class="margin-right-8 text-primary">FORUM</span>
          {% if userAccess.canManageUsers() %}
            <a class="margin-right-8 text-gray" href="/users">USERS</a>
          {% endif %}
          {% if user is null %}
            <a class="text-gray" href="/login">LOGIN</a>
          {% else %}
            <a class="text-gray" href="/logout">LOGOUT</a>
          {% endif %}
        </div>
      </div>
    </header>

    <main>
      <div class="page-box">
        <h1 class="margin-bottom-8">{{ topic['name'] }}</h1>

        <nav>
          <ol class="breadcrumbs">
            <li class="breadcrumbs-item">
              <a href="/">Categories</a>
            </li>
            <li class="breadcrumbs-item">
              <a href="/{{ category['slug'] }}">{{ category['name'] }}</a>
            </li>
            <li class="breadcrumbs-item active">{{ topic['name'] }}</li>
          </ol>
        </nav>

{#        <div>#}
{#          <div style="display: flex;align-items: center;color: #6c757d;">#}
{#            <span class="material-icons-outlined" style="font-size: 20px; margin-right: 4px;">account_circle</span>#}
{#            <span>mumbarak</span>#}
{#          </div>#}
{#        </div>#}

        <div style="margin-top: 20px; margin-bottom: 20px;">{{ topic['content'] }}</div>

        {% if comments|length > 0 %}
          <div class="title-box">
            <h2 class="title">Comments</h2>
            <span class="title-sub">26</span>
          </div>

          <div class="list">
            {% for comment in comments %}
              <div class="list-item">
                <div>
                  <div>{{ comment.content }}</div>
                  <div class="list-item-sub">
                    <span>author</span>
                  </div>
                </div>
                <div>
                  <a href="#" class="icon material-icons">edit</a>
                  {#            <a href="#" class="material-icons">delete</a>#}
                  <a href="#" class="icon material-icons">reply</a>
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
    </main>
  </section>

  <footer class="light-gray-background vertical-padding-40 margin-top-24">
    <div class="page-box">
      <h2>Add comment</h2>
{#      <div class="title-sub margin-bottom-16">#}
{#        <span class="icon material-icons-outlined margin-right-4">account_circle</span>#}
{#        <span>Anonymous</span>#}
{#      </div>#}
      <div>
        <textarea class="input" rows="3" placeholder="Type your comment here..."></textarea>
      </div>
      <button class="button">Add comment</button>
    </div>
  </footer>
</body>
</html>
