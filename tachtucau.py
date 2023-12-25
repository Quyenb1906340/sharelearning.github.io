import py_vncorenlp
import re
from pymongo import MongoClient

# Kết nối đến MongoDB
client = MongoClient("mongodb://localhost:27017/")
db = client["Test"]
input_collection = db["tachcaunoidung"]
output_collection = db["tachtucau"]

delete_result = output_collection.delete_many({})

# Load model VnCoreNLP
py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
model = py_vncorenlp.VnCoreNLP(annotators=["wseg"], save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')


# Lấy tất cả tài liệu từ bộ sưu tập baiviet
all_documents = input_collection.find()
for input_document in all_documents:
    input_text = input_document["wordForm"]  # Lấy dữ liệu từ trường "text"
    
    # Annotate dữ liệu đầu vào
    annotated_text = model.annotate_text(input_text)

    # Chuyển đổi annotated_text từ điển thành chuỗi JSON
    annotated_text_str = str(annotated_text)
    
    # Lưu dữ ljiệu đã đánh dấu vào tệp văn bản
    annotated_file_path = "C:/xampp/htdocs/VnCoreNLP-master/ketqua.txt"
    with open(annotated_file_path, "w", encoding="utf-8") as file:
        file.write(annotated_text_str)
        doc_id = input_document["doc_id"]  # Lấy _id của tài liệu
        id_cau = input_document["id_cau"]
    
    # Đọc dữ liệu từ tệp văn bản đã chú thích
    with open(annotated_file_path, "r", encoding="utf-8") as file:
        annotated_content = file.read()

    # Chuyển đổi chuỗi JSON thành từ điển
    annotated_data = eval(annotated_content)

    # Lưu từng từ trong annotated_data vào cơ sở dữ liệu đã đánh dấu
    for doc_index, words_info in annotated_data.items():
        for word_info in words_info:
            output_collection.insert_one({
                'id_cau': id_cau,
                'doc_id': doc_id,  # Thêm _id của tài liệu
                'wordForm': word_info['wordForm']
            })
       
print("Đã chú thích và lưu dữ liệu theo từng câu thành công!")
