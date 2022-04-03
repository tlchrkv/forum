<h1>{{ category.name }}</h1>
<div>
  <div>
    {% for topic in category.topics %}
      <a href="#">{{ topic.name }}</a>
    {% endfor %}
  </div>
  <div>
    <a href="#">Previous</a>
    <a href="#">Next</a>
  </div>
</div>
