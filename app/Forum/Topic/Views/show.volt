<h1>{{ topic.name }}</h1>
<div>
  <div>
    {{ topic.content }}
  </div>
  <div>
    {% for comment in topic.comments %}
      <div>
        <div>{{ comment.author }}</div>
        <div>{{ comment.content }}</div>
        <div>{{ comment.createdAt }}</div>
      </div>
    {% endfor %}
  </div>
  <div>
    <a href="#">Previous</a>
    <a href="#">Next</a>
  </div>
</div>
