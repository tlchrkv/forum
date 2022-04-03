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
    <form action="/login" method="post">
      <div class="mb-3">
        <label for="nameInput" class="form-label">Name</label>
        <input type="text" class="form-control" id="nameInput" name="name" />
      </div>
      <div class="mb-3">
        <label for="passwordInput" class="form-label">Password</label>
        <input type="password" class="form-control" id="passwordInput" name="password" />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
</body>
</html>
