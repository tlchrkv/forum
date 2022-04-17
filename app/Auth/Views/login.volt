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

  <main class="full-height">
    <div class="page-box content-centered min-height-380">

      <div class="width-100 max-width-280 margin-bottom-8">
        <div class="header-main">
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

        <div class="header-menu">
          <div>
            <a class="margin-right-8 text-gray" href="/">Topics</a>
            {% if userAccess.canManageUsers() %}
              <a class="margin-right-8 text-gray" href="/users">USERS</a>
            {% endif %}
            <span class="text-primary" href="/login">LOGIN</span>
          </div>
        </div>
      </div>

      <h1 class="width-100 max-width-280 margin-bottom-32 page-name" style="margin-top: 16px;
    margin-bottom: 24px;">Login</h1>

      {% if error is not null %}
      <div class="message-box max-width-280" style="color: #e30000;
    width: 100%;
    margin-top: -24px;height: auto;
    margin-bottom: 8px;">
        {{ error }}
      </div>
      {% endif %}

      <form method="post" class="width-100 max-width-280">
        <div>
          <input class="input margin-bottom-16" name="name" placeholder="username" required />
        </div>
        <div>
          <input class="input margin-bottom-16" name="password" type="password" placeholder="password" required />
        </div>
        <button class="button width-100" type="submit">Login</button>
      </form>
    </div>
  </main>

</body>
</html>
