import requests
import time
import os
import logging


LOG_DIR = "/xiaosong/script/log"
logging.basicConfig(level=logging.DEBUG,
                    format='%(asctime)s %(filename)s[line:%(lineno)d] %(process)d %(levelname)s %(message)s',
                    datefmt='%a, %d %b %Y %H:%M:%S',
                    filename=LOG_DIR+'/'+time.strftime('%Y-%m-%d',time.localtime(time.time()))+'.log',
                    filemode='a')

def http_notify(addr,params):
    res = requests.get(addr,params=params)
    if(res.status_code != 200):
        logging.warning("request is error")
    else:
        if(res.text != '1'):
            logging.warning("request res is not 1,and it is "+ res.text)	
        else:
            logging.info("request is ok")
            
#根据图片的路径返回各级文件夹的名称            
def get_path_dir(path,index):
    return (os.path.split(path)[0]).split('/')[index]


    
