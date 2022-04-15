<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/material-icons.css">
  <style>
      /*a {*/
      /*    color: #135083; #ce0303; */
      /*}*/
      a {
          color: #212529;
          text-decoration: none;
      }
      .active-link {
          color: #6521ff !important;
      }
      a:hover {
          color: #767676 !important;
          transition: 0.1s;
      }
      .container {
          max-width: 720px;
      }

      /* HEADER */
      .header__main {
          display: flex;
          justify-content: space-between;
          height: 40px;
          align-items: center;
          margin-top: 16px;
      }
      .header__main > .logo {
          font-weight: bold;
          font-size: 24px;
          color: #6521ff;
          display: flex;
          align-items: center;
      }
      .header__main > .logo > img {
          margin-right: 6px;
      }
      .header__main > .username {
          display: flex;
          align-items: center;
      }
      .header__main > .username > span:nth-child(1) {
          margin-right: 4px;
      }
      .header__main > .username > a {
          color: #adafb3;
      }
      .header__main > .username > .material-icons-outlined {
          font-size: 20px;
      }
      .header__sub {
          font-size: 13px;
          font-weight: 500;
          height: 28px;
          display: flex;
          justify-content: space-between;
          align-items: end;
      }
      .header__sub > div > .header-link {
          margin-right: 8px;
      }
      .header__sub > a.header-link, .header__sub > div > a.header-link {
          color: #adafb3;
      }

      /* MAIN */
      .main {
          margin-bottom: 20px;
      }
      .main > h1 {
          margin-top: 16px;
          margin-bottom: 8px;
      }

      .main > .add-category {
          margin-top: 20px;
          margin-bottom: 20px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          border: 1px solid rgba(0,0,0,.125);
          padding: 12px 12px;
          border-radius: 0.25rem;

          font-size: 13px;
          font-weight: 500;
          color: #adafb3;
      }
      .main > .add-category:hover {
          background-color: #fcfcfc;
      }
      .main > .add-category > .material-icons {
          color: #93989f;
          font-size: 20px;
      }

      .main > .topics > .topic {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          border: 1px solid rgba(0,0,0,.125);
          border-bottom: none;
          padding: 12px 12px;
      }
      .main > .topics > .topic:hover {
          background-color: #fcfcfc;
      }
      .main > .topics > .topic:first-child {
          border-radius: 0.25rem 0.25rem 0 0;
      }
      .main > .topics > .topic:last-child {
          border-radius: 0 0 0.25rem 0.25rem;
      }
      .main > .topics > .topic:last-child {
          border-bottom: 1px solid rgba(0,0,0,.125);
      }
      .main > .topics > .topic > .material-icons {
          color: #93989f;
          font-size: 20px;
      }
      .main > .topics > .topic > div > .comments-count {
          color: #93989f;
          font-size: 14px;
          margin-right: 8px;
      }
      .main > .topics > .topic > div > .comments-count > .material-icons-outlined {
          font-size: 14px;
          vertical-align: sub;
      }

      .main > nav > .breadcrumb {
          text-transform: uppercase;
          font-size: 13px;
          font-weight: 500;
          margin-bottom: 8px;
      }
      .main > nav > .breadcrumb > li > a {
          color: #adafb3;
      }

      .main > .next-pagination {
          display: flex;
          justify-content: space-between;
          margin-top: 20px;
      }
      .main > .next-pagination > div > a {
          display: flex;
          justify-content: space-between;
          align-items: center;
          border: 1px solid rgba(0,0,0,.125);
          padding: 12px 12px;
          border-radius: 0.25rem;
          font-size: 13px;
          font-weight: 500;
          color: #adafb3;
          text-transform: uppercase;
      }
      .main > .next-pagination > div > a:first-child {
          margin-right: 12px;
      }
      .main > .next-pagination > div > a:last-child {
          margin-right: 0;
      }

      .footer {

      }

      .topic > div > .material-icons {
          font-size: 20px;
          color: #adafb3;
      }
  </style>
</head>
<body>

<header>
  <div class="container header__main">
    <div class="logo">
      <img src="/assets/png/logo.png" height="22px" />
      <span>Forumium</span>
    </div>
    {% if user is not null %}
      <div class="username">
        <span>{{ user.name }}</span>
        <span class="material-icons-outlined">account_circle</span>
      </div>
    {% endif %}
  </div>

  <div class="container header__sub">
    <div>
      <span class="header-link active-link">FORUM</span>
      {% if userAccess.canManageUsers() %}
        <a class="header-link" href="/users">USERS</a>
      {% endif %}
      {% if user is null %}
        <a class="header-link" href="/login">LOGIN</a>
      {% else %}
        <a class="header-link" href="/logout">LOGOUT</a>
      {% endif %}
    </div>
  </div>
</header>

<main class="container main">
  <h1>Add topic</h1>

  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Categories</a></li>
      <li class="breadcrumb-item"><a href="/{{ category.slug }}">{{ category.name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add topic</li>
    </ol>
  </nav>

  <div>
    <div style="
    /*font-size: 13px;*/
    /*text-transform: uppercase;*/
    color: #adafb3;
    display: flex; align-items: center;margin-bottom: 32px;">
      <span class="material-icons-outlined" style="font-size: 20px;
    margin-right: 4px;">account_circle</span>
      <span>anonymous</span>
    </div>
    <div style="margin-bottom: 16px">
      <input class="form-control" placeholder="Name" />
    </div>
    <div>
      <textarea class="form-control" rows="9" placeholder="Content"></textarea>
    </div>
    <div>
      <button style="display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 12px;
    border-radius: 0.25rem;
    font-size: 13px;
    font-weight: 500;
    text-transform: uppercase;
    margin-top: 16px;
    border: none;
    background-color: #6521ff;
    color: white;">Add topic</button>
    </div>
  </div>
</main>

<footer class="footer"</footer>
</body>
</html>
