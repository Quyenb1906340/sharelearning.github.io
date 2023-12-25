<!-- <!DOCTYPE html>
<html>

<head>
    <title>MongoDB Query Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        
        h1 {
            color: #333;
        }
        
        ul {
            list-style-type: none;
            padding: 0;
        }
        
        li {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>MongoDB Query Results</h1>
        <form action="/" method="POST">
            <label for="keyword">Enter Keyword:</label>
            <input type="text" id="keyword" name="keyword">
            <button type="submit">Search</button>
        </form>
        <ul>
            {% for document in documents %}
            <li>
                <h3>{{ document.name }}</h3>
                <p>Giới tính: {{ document.gender }}</p>
                <p>Sđt: {{ document.phone }}</p>
                <p>Địa chỉ: {{ document.address }}</p>

            </li>
            {% endfor %}
        </ul>
    </div>
</body>

</html> -->

<!DOCTYPE html>
<html>
<head>
    <title>Search Example</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        
        h1 {
            color: #333;
        }
        
        ul {
            list-style-type: none;
            padding: 0;
        }
        
        li {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }
    </style>
<body>
    <div class="container">
    <h1>Search Example</h1>
    <form method="GET">
        <label for="keyword">Keyword:</label>
        <input type="text" id="keyword" name="keyword" value="{{ keyword }}">
        <button type="submit">Search</button>
    </form>
    <h2>Kết quả tìm kiếm cho từ khoá "{{ keyword }}":</h2>
    <ul>
        {% for document in documents %}
            <li><h3>{{ document.name }}</h3>
                <p>Giới tính: {{ document.gender }}</p>
                <p>Sđt: {{ document.phone }}</p>
                <p>Địa chỉ: {{ document.address }}</p>
            </li>
        {% endfor %}
    </ul>
    <div class="pagination">
        {% if page > 1 %}
            <a href="?keyword={{ keyword }}&page={{ page - 1 }}">Previous</a>
        {% endif %}
        {% if page < total_pages %}
            <a href="?keyword={{ keyword }}&page={{ page + 1 }}">Next</a>
        {% endif %}
    </div>
    </div>


</body>
</html>
