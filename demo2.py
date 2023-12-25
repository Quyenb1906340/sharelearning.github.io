from flask import Flask, render_template, request
from pymongo import MongoClient

demo2 = Flask(__name__)



# Kết nối đến MongoDB
client = MongoClient("mongodb://localhost:27017/")
db = client["Test"]
collection = db["demo"]

# Xóa chỉ mục cũ
# collection.drop_index("custom_text_index")

# existing_indexes = collection.index_information()
# print(existing_indexes)

# Tạo chỉ mục nghịch đảo 
collection.create_index([("name", "text")], name="custom_text_index")


@demo2.route("/", methods=["GET", "POST"])
def index():
    # if request.method == "POST":
    #     keyword = request.form.get("keyword")
    #     query = {"$text": {"$search": keyword}}
    #     result = collection.find(query)
    #     documents = [document for document in result]
    #     return render_template("index.html", documents=documents)
    # else:
    #     return render_template("index.html", documents=[])

    per_page = 2  # Số văn bản trên mỗi trang
    page = request.args.get("page", default=1, type=int)
    keyword = request.args.get("keyword", default="", type=str)
    
    query = {"$text": {"$search": keyword}}
    result = collection.find(query).skip((page - 1) * per_page).limit(per_page)
    documents = [document for document in result]
    
    total_documents = collection.find(query).count()
    total_pages = (total_documents + per_page - 1) // per_page
    
    return render_template("index.php", documents=documents, keyword=keyword, page=page, total_pages=total_pages)




if __name__ == "__main__":
    demo2.run(debug=True)
