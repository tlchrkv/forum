<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ appName }}</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">{{ appName }}</a>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="/add-category" class="nav-link px-2 link-dark">Add category</a></li>
      </ul>

      <div class="col-md-3 text-end">
        <a href="/login" class="btn btn-outline-primary me-2">Login</a>
      </div>
    </header>

    <div>
      {% for category in categories %}
        <h2>
          <a href="/{{ category.slug }}">{{ category.name }}</a>
        </h2>

{#        <ul>#}
{#          {% for topic in category.topics %}#}
{#            <li>#}
{#              <a href="#">{{ topic.name }}</a>#}
{#            </li>#}
{#          {% endfor %}#}
{#        </ul>#}
      {% endfor %}
    </div>
  </div>
</body>
</html>
