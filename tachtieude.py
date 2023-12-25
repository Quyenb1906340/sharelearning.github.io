
import py_vncorenlp
from pymongo import MongoClient
import os

# Kết nối đến MongoDB
client = MongoClient("mongodb://localhost:27017/")
db = client["Test"]  # Thay thế bằng tên thực tế của cơ sở dữ liệu
input_collection = db["baiviet"]  # Thay thế bằng tên bộ sưu tập chứa dữ liệu đầu vào
output_collection = db["tachtutieude"] 
 # Thay thế bằng tên bộ sưu tập mong muốn cho dữ liệu đã đánh dấu
delete_result = output_collection.delete_many({})
# Automatically download VnCoreNLP components and load the model
py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
# model = py_vncorenlp.VnCoreNLP(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
model = py_vncorenlp.VnCoreNLP(annotators=["wseg"], save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')

# Lấy tất cả tài liệu từ bộ sưu tập baiviet
all_documents = input_collection.find()
for input_document in all_documents:
    input_text = input_document["bv_tieude"]  # Lấy dữ liệu từ trường "text"
    
    # Annotate dữ liệu đầu vào
    annotated_text = model.annotate_text(input_text)

    # Chuyển đổi annotated_text từ điển thành chuỗi JSON
    annotated_text_str = str(annotated_text)
    
    # Lưu dữ ljiệu đã đánh dấu vào tệp văn bản
    annotated_file_path = "C:/xampp/htdocs/VnCoreNLP-master/ketqua.txt"
    with open(annotated_file_path, "w", encoding="utf-8") as file:
        file.write(annotated_text_str)
        doc_id = input_document["id"]  # Lấy _id của tài liệu
    
    # Đọc dữ liệu từ tệp văn bản đã chú thích
    with open(annotated_file_path, "r", encoding="utf-8") as file:
        annotated_content = file.read()

    # Chuyển đổi chuỗi JSON thành từ điển
    annotated_data = eval(annotated_content)

    # Lưu từng từ trong annotated_data vào cơ sở dữ liệu đã đánh dấu
    for doc_index, words_info in annotated_data.items():
        for word_info in words_info:
            output_collection.insert_one({
                'doc_id': doc_id,  # Thêm _id của tài liệu
                'wordForm': word_info['wordForm']
            })

print("Đã chú thích và lưu dữ liệu vào các tài liệu thành công!")













