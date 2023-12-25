from pyvi import ViTokenizer
from flask import Flask, render_template, request
from pymongo import MongoClient

app = Flask(__name__)
client = MongoClient("mongodb://localhost:27017/")
db = client["Test"]
documents_collection = db["baiviet"]
inverted_index_collection = db["demo2"]

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/search', methods=['POST'])
def search():
    search_word = request.form['search_word']
    result = inverted_index_collection.find_one({"title": search_word})
    print(result)
    relevant_documents = []
    if result:
        doc_ids = result["doc_ids"]
        relevant_documents = documents_collection.find({"doc_id": {"$in": doc_ids}})
    
    return render_template('search_results.html', search_word=search_word, documents=relevant_documents)

if __name__ == '__main__':
    app.run(debug=True)
