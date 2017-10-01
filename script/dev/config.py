import pyinotify

#Web Api Addr 
GET_LIST_ADDR = "https://xiaosong1234.cn/api/getStreamList"
STREAM_STATUS_CALLBACK_ADDR = "https://xiaosong1234.cn/api/streamStatusCallBack"
SERVER_STATUS_CALLBACK_ADDR = "https://xiaosong1234.cn/api/serverStatusCallBack"
CLASSIFY_CALLBACK_ADDR = "https://xiaosong1234.cn/api/streamClassifyCallBack" 


MODEL_PATH = '/data/model'
IMAGE_PATH = '/data/image'
MODEL_PATH = "/data/model"
MONTIOR_DIR = "/data/image/online"
MONTIOR_MASK = pyinotify.IN_DELETE | pyinotify.IN_CREATE
IMAGE_FORMAT = ".jpeg"
DEFAULT_ONLINE_INTERVAL = 2 #默认上线的间隔

#Stream Status
STREAM_STATUS_COLLECTION = 100#收集图片中
STREAM_STATUS_MANUAL = 200#打标签/训练网络中 等待上传模型
STREAM_STATUS_ONLINE = 300#线上运行中

#Stream CallBack Code
CALLBACK_CODE_COLLECT_OK = 200 #本次截图成功 返回图片数量和其他信息
CALLBACK_CODE_COLLECT_ERROR_1 = 500 #本次截图失败 返回错误码和其他信息
CALLBACK_CODE_MANUAL_MODEL_EXISTS = 230  #本次截图成功 返回图片数量和其他信息
CALLBACK_CODE_MANUAL_MODEL_NOT_EXISTS = 530 #本次截图失败 返回错误码和其他信息
CALLBACK_CODE_ONLINE_OK = 260 #本次截图成功
CALLBACK_CODE_ONLINE_ERROR_1 = 560 #本次截图失败
CALLBACK_CODE_ONLINE_ERROR_2 = 561 #getLabel 返回 -1

#Server CallBack Code
CALLBACK_CODE_SERVER_OK = 200 #截图服务器良好
CALLBACK_CODE_SERVER_ERROR = 500 #截图服务器脚本运行异常















