# import logging 
# from vncorenlp import VnCoreNLP


# def simple_usage():

#     # Uncomment this line for debugging

#     # logging.basicConfig(level=logging.DEBUG)



#     vncorenlp_file = r'./VnCoreNLP-1.0.1.jar'



#     sentences = 'VTV đồng ý chia sẻ bản quyền World Cup 2018 cho HTV để khai thác. ' \
#     'Nhưng cả hai nhà đài đều phải chờ sự đồng ý của FIFA mới thực hiện được điều này.'



#     # Use "with ... as" to close the server automatically

#     with VnCoreNLP(vncorenlp_file) as vncorenlp:

#         print('Tokenizing:', vncorenlp.tokenize(sentences))

#         print('POS Tagging:', vncorenlp.pos_tag(sentences))

#         print('Named-Entity Recognizing:', vncorenlp.ner(sentences))

#         print('Dependency Parsing:', vncorenlp.dep_parse(sentences))

#         print('Annotating:', vncorenlp.annotate(sentences))

#         print('Language:', vncorenlp.detect_language(sentences))



#     # In this way, you have to close the server manually by calling close function

#     vncorenlp = VnCoreNLP(vncorenlp_file)

#     print('Tokenizing:', vncorenlp.tokenize(sentences))

#     print('POS Tagging:', vncorenlp.pos_tag(sentences))

#     print('Named-Entity Recognizing:', vncorenlp.ner(sentences))

#     print('Dependency Parsing:', vncorenlp.dep_parse(sentences))

#     print('Annotating:', vncorenlp.annotate(sentences))

#     print('Language:', vncorenlp.detect_language(sentences))

#     # Do not forget to close the server

#     vncorenlp.close()

#########################################
# import py_vncorenlp

# # Automatically download VnCoreNLP components from the original repository
# # and save them in some local working folder
# py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')

# # Load VnCoreNLP from the local working folder that contains both `VnCoreNLP-1.2.jar` and `models` 
# model = py_vncorenlp.VnCoreNLP(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
# # Equivalent to: model = py_vncorenlp.VnCoreNLP(annotators=["wseg", "pos", "ner", "parse"], save_dir='/absolute/path/to/vncorenlp')

# # Annotate a raw corpus
# model.annotate_file(input_file="text.txt", output_file="ketqua.xlsx")

# # Annotate a raw text
# model.print_out(model.annotate_text("Trước khi có CSS, các thẻ như phông chữ, màu sắc, kiểu nền, các sắp xếp phần tử, đường viền và kích thước phải được lặp lại trên mọi trang web. Đây là một quá trình rất dài tốn thời gian và công sức. Ví dụ: Nếu bạn đang phát triển một trang web lớn nơi phông chữ và thông tin màu được thêm vào mỗi trang, nó sẽ trở thành một quá trình dài và tốn kém. CSS đã được tạo ra để giải quyết vấn đề này. Đó là một khuyến cáo của W3C. Nhờ CSS mà source code của trang Web sẽ được tổ chức gọn gàng hơn, trật tự hơn. Nội dung trang web sẽ được tách bạch hơn trong việc định dạng hiển thị. Từ đó, quá trình cập nhập nội dung sẽ dễ dàng hơn và có thể hạn chế tối thiểu làm rối cho mã HTML."))


#########################################

# from flask import Flask, render_template, request
# import py_vncorenlp

# demo = Flask(__name__)

# @demo.route("/", methods=["GET", "POST"])
# def index():
#     if request.method == "POST":
#         uploaded_file = request.files["file"]
#         if uploaded_file.filename != "":
#             save_path = f"C:/xampp/htdocs/VnCoreNLP-master/uploads/{uploaded_file.filename}"
#             uploaded_file.save(save_path)
            
#             # Automatically download VnCoreNLP components and load the model
#             py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
#             model = py_vncorenlp.VnCoreNLP(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
            
#             # Annotate the uploaded file and save the result in Excel format
#             output_path = f"C:/xampp/htdocs/VnCoreNLP-master/uploads/{uploaded_file.filename.replace('.txt')}"
#             model.annotate_file(input_file=save_path, output_file=output_path)
            
#             return render_template("text.php", result_path=output_path)
    
#     return render_template("text.php", result_path=None)

# if __name__ == "__main__":
#     demo.run(debug=True)
import py_vncorenlp
from pymongo import MongoClient
import os

# Kết nối đến MongoDB
client = MongoClient("mongodb://localhost:27017/")
db = client["Test"]  # Thay thế bằng tên thực tế của cơ sở dữ liệu
input_collection = db["baiviet"]  # Thay thế bằng tên bộ sưu tập chứa dữ liệu đầu vào
output_collection = db["tachtu"]  # Thay thế bằng tên bộ sưu tập mong muốn cho dữ liệu đã đánh dấu

# Automatically download VnCoreNLP components and load the model
py_vncorenlp.download_model(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')
model = py_vncorenlp.VnCoreNLP(save_dir='C:/xampp/htdocs/VnCoreNLP-master/models/')

# Lấy tất cả tài liệu từ bộ sưu tập baiviet
all_documents = input_collection.find()
for input_document in all_documents:
    input_text = input_document["text"]  # Lấy dữ liệu từ trường "text"
    
    # Annotate dữ liệu đầu vào
    annotated_text = model.annotate_text(input_text)

    # Chuyển đổi annotated_text từ điển thành chuỗi JSON
    annotated_text_str = str(annotated_text)
    
    # Lưu dữ liệu đã đánh dấu vào tệp văn bản
    annotated_file_path = "C:/xampp/htdocs/VnCoreNLP-master/ketqua.txt"
    with open(annotated_file_path, "w", encoding="utf-8") as file:
        file.write(annotated_text_str)
        doc_id = input_document["_id"]  # Lấy _id của tài liệu
    
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
                'index': word_info['index'],
                'wordForm': word_info['wordForm'],
                'posTag': word_info['posTag'],
                'nerLabel': word_info['nerLabel'],
                'head': word_info['head'],
                'depLabel': word_info['depLabel']
            })

print("Đã chú thích và lưu dữ liệu vào các tài liệu thành công!")













