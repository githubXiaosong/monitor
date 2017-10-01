import time

from keras.applications.resnet50 import ResNet50
from keras.preprocessing import image
from keras.applications.resnet50 import preprocess_input, decode_predictions
import numpy as np





def image2label(path):
    img = image.load_img(path, target_size=(224, 224))
    x = image.img_to_array(img)
    x = np.expand_dims(x, axis=0)
    x = preprocess_input(x)
    print(x);


images = ["/data/image/collect/37/1506440882_1.jpeg","/data/image/collect/37/1506440882_1.jpeg","/data/image/collect/37/1506440882_1.jpeg","/data/image/collect/37/1506440882_1.jpeg"]

for i in images:
    image2label(i)


