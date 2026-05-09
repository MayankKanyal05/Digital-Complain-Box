from flask import Flask, request, jsonify
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
import numpy as np
import os
app = Flask(__name__)
model = load_model("models/fake_detector.h5")
IMG_SIZE = 224
@app.route('/')
def home():
    return "Fake Detection AI API Running"
@app.route('/predict', methods=['POST'])
def predict():
    if 'file' not in request.files:
        return jsonify({
            "error": "No file uploaded"
        })
    file = request.files['file']
    filepath = os.path.join("temp.jpg")
    file.save(filepath)
    img = image.load_img(filepath, target_size=(IMG_SIZE, IMG_SIZE))
    img_array = image.img_to_array(img)
    img_array = img_array / 255.0
    img_array = np.expand_dims(img_array, axis=0)
    prediction = model.predict(img_array)[0][0]
    if prediction < 0.5:
        result = "Highly Suspicious"
        confidence = float(prediction * 100)
    elif prediction > 0.5 and prediction < 0.7 :
        result = "Suspicious"
        confidence = float(prediction * 100)
    else:
        result = "Real"
        confidence = float((1 - prediction) * 100)
    os.remove(filepath)
    return jsonify({
        "result": result,
        "confidence": f"{confidence:.2f}%"
    })
if __name__ == '__main__':
    app.run(debug=True)