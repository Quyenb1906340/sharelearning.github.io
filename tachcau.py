import py_vncorenlp
import re
from pymongo import MongoClient

# Kết nối đến MongoDB
client = MongoClient("mongodb://localhost:27017/")
db = client["Test"]
input_collection = db["baiviet"]
output_collection = db["tachcaunoidung"]

delete_result = output_collection.delete_many({})

# Load model VnCoreNLP
py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
model = py_vncorenlp.VnCoreNLP(annotators=["wseg"], save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')

# Lấy tất cả tài liệu từ bộ sưu tập baiviet
all_documents = input_collection.find()

for input_document in all_documents:
    input_text = input_document["bv_noidung"]

    # Chia dữ liệu thành các câu
    # sentences = input_text.split('.')
    sentences = re.split(r'(?<=[.!?])\s+', input_text)

    doc_id = input_document["id"]
    # trangthai = input_document["trangthai"]
    i = 0


    for sentence in sentences:
        i += 1
    
        output_collection.insert_one({
            'id_cau': i,
            'doc_id': doc_id,
            'wordForm': sentence.strip(),
            # 'trangthai': trangthai
        })
       
print("Đã chú thích và lưu dữ liệu theo từng câu thành công!")
