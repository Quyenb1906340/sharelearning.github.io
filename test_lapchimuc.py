import py_vncorenlp
from pymongo import MongoClient
import json

# Kết nối tới MongoDB
mongo_client = MongoClient("mongodb://localhost:27017")
database = mongo_client["Test"]
# collection = database["chimuc"]
input_collection = database["baiviet"]  # Thay thế bằng tên bộ sưu tập chứa dữ liệu đầu vào
output_collection = database["chimuc"]  # Thay thế bằng tên bộ sưu tập mong muốn cho dữ liệu đã đánh dấu
# # Văn bản cần xử lý
# van_ban = "MongoDB là một cơ sở dữ liệu NoSQL, một dạng database hướng tài liệu. Chúng thường được sử dụng để lưu trữ dữ liệu khối lượng lớn. MongoDB không sử dụng cấu trúc dạng bảng như relational database. Thay vào đó, MongoDB sẽ lưu trữ dữ liệu dưới dạng Document JSON. Vì vậy, mỗi một collection sẽ các các kích cỡ và các document khác nhau. Bên cạnh đó, việc các dữ liệu được lưu trữ trong document kiểu JSON dẫn đến chúng được truy vấn rất nhanh."

# Tải xuống và khởi tạo vnCoreNLP
py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
model = py_vncorenlp.VnCoreNLP(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')


# Lấy tất cả tài liệu từ bộ sưu tập baiviet
all_documents = input_collection.find({"status": "0"})
for input_document in all_documents:
    van_ban = input_document["text"]  # Lấy dữ liệu từ trường "text"

    # Sử dụng vnCoreNLP để tách từ và lấy danh sách tokens
    van_ban_duoc_chia = model.annotate_text(van_ban)

    # Chuyển đổi annotated_text từ điển thành chuỗi JSON
    van_ban_chua_danh_dau_str = json.dumps(van_ban_duoc_chia, ensure_ascii=False)

    # Ghi dữ liệu đã đánh dấu vào tệp văn bản
    duong_dan_tep_chua_danh_dau = "C:/xampp/htdocs/VnCoreNLP-master/ketqua.json"
    with open(duong_dan_tep_chua_danh_dau, "w", encoding="utf-8") as file:
        file.write(van_ban_chua_danh_dau_str)

    # Đọc dữ liệu từ tệp văn bản đã chú thích
    with open(duong_dan_tep_chua_danh_dau, "r", encoding="utf-8") as file:
        du_lieu_danh_dau = json.load(file)

    # Hiển thị nội dung của du_lieu_danh_dau để xem cấu trúc
    print(json.dumps(du_lieu_danh_dau, indent=4, ensure_ascii=False))

    thong_tin_tokens = du_lieu_danh_dau['0']

    # Xây dựng chỉ mục nghịch đảo
    for thong_tin_token in thong_tin_tokens:
        tu = thong_tin_token['wordForm'].lower()  # Chuẩn hóa token thành chữ thường
        
        # Kiểm tra xem từ đã có trong chỉ mục chưa
        mien_entry = output_collection.find_one({'tu': tu})
        
        if mien_entry:
            cac_tai_lieu_da_co = mien_entry['cac_tai_lieu']
            cac_tuong_dong_da_co = mien_entry.get('cac_tuong_dong', [])
            
            # Tính tỷ lệ phần trăm tương đồng giữa tài liệu mới và các tài liệu đã có
            ty_le_tuong_dong = []
            for tai_lieu_da_co in cac_tai_lieu_da_co:
                tu_chung = set(tai_lieu_da_co.split()) & set(van_ban.split())
                ty_le = (len(tu_chung) / len(set(tai_lieu_da_co.split()))) * 100
                ty_le_tuong_dong.append(ty_le)
            
            ty_le_tb_tuong_dong = sum(ty_le_tuong_dong) / len(ty_le_tuong_dong)
            
            # Lưu chi tiết thông tin tài liệu tương đồng
            cac_tai_lieu_tuong_dong = []
            for idx, tai_lieu_da_co in enumerate(cac_tai_lieu_da_co):
                tu_chung = set(tai_lieu_da_co.split()) & set(van_ban.split())
                ty_le_tuong_dong = ty_le_tuong_dong[idx]
                cac_tai_lieu_tuong_dong.append({
                    'tai_lieu': tai_lieu_da_co,
                    'tu_chung': list(tu_chung),
                    'ty_le_tuong_dong': ty_le_tuong_dong
                })
            
            # Cập nhật tài liệu chứa từ và thông tin tài liệu tương đồng
            output_collection.update_one(
                {'tu': tu},
                {'$addToSet': {'cac_tai_lieu': van_ban},
                '$set': {'ty_le_tb_tuong_dong': ty_le_tb_tuong_dong,
                        'cac_tuong_dong': cac_tuong_dong_da_co + cac_tai_lieu_tuong_dong}
                }
            )
        else:
            # Nếu từ chưa có trong chỉ mục, thêm mới một mục vào chỉ mục
            output_collection.insert_one({
                'tu': tu,
                'cac_tai_lieu': [van_ban],
                'ty_le_tb_tuong_dong': 100,  # Tỷ lệ phần trăm tương đồng với chính nó là 100%
                'cac_tuong_dong': []
            })
    # Cập nhật trạng thái của tài liệu thành "1" sau khi đã lập chỉ mục
    input_collection.update_one(
        {'_id': input_document['_id']},
        {'$set': {'status': '1'}}
    )
print("Chỉ mục nghịch đảo đã được cập nhật.")
