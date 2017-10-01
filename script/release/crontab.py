#V2
import requests
import time
import os
import subprocess
import config
from utils import logging,http_notify

res = requests.get(config.GET_LIST_ADDR) #测试时先把所有的流拿过来
current_time = time.time()
child_arr = []
t = 60

try:
    for stream in res.json():

        if(stream['status'] == config.STREAM_STATUS_COLLECTION):
            print(stream['status'],stream['id'])
            datadir = os.path.join(config.IMAGE_PATH,'collect',str(stream['id']))
            if not os.path.exists(datadir):
               os.makedirs(datadir)
            sh = "ffmpeg -probesize 327680 -i " + stream['url'] +" -y -t " + str(t) + " -ss 0 -f image2 -r " + str(1/(stream['collect_current_interval']['time'])) + " "+ datadir + "/"+ str(int(current_time)) +"_%d.jpeg"
            logging.info(sh)
            child = subprocess.Popen(sh,shell=True)
            child.stream_id = stream['id']
            child.datadir = datadir
            child.stream_status = config.STREAM_STATUS_COLLECTION        
            child_arr.append(child)

        elif(stream['status'] == config.STREAM_STATUS_MANUAL):
            print(stream['status'],stream['id'])
            #检查模型是否存在  这里什么都不做 交到wait child中去做 为了保证不在这里延时
            child = subprocess.Popen('pwd')
            child.stream_id = stream['id']
            child.stream_status = config.STREAM_STATUS_MANUAL
            child_arr.append(child)        

        elif(stream['status'] == config.STREAM_STATUS_ONLINE): 
            print(stream['status'],stream['id'])
            #截图 监听文件夹 回调        
            datadir = os.path.join(config.IMAGE_PATH,'online',str(stream['id']))
            if not os.path.exists(datadir):
               os.makedirs(datadir)
            sh = "ffmpeg -probesize 327680 -i " + stream['url'] +" -y -t " + str(t) + " -ss 0 -f image2 -r " + str(1/(stream['online_interval']['time'])) + " "+ datadir + "/"+ str(int(current_time)) +"_%d.jpeg"           
            logging.info(sh)
            child = subprocess.Popen(sh,shell=True)
            child.stream_id = stream['id']
            child.datadir = datadir
            child.stream_status = config.STREAM_STATUS_ONLINE
            child_arr.append(child)


    for child in child_arr:
        result = child.wait()
        if(result == 0): #进程执行成功
            logging.info("SUCCEED pid is: " + str(child.pid) + " | stream id is "+ str(child.stream_id))
            if(child.stream_status == config.STREAM_STATUS_COLLECTION):
                logging.debug("SUCCESS collect process")
                img_num = sum([len(x) for _, _, x in os.walk(os.path.dirname(child.datadir + "/"))])
                http_notify(config.STREAM_STATUS_CALLBACK_ADDR,{'stream_id':child.stream_id,'code':config.CALLBACK_CODE_COLLECT_OK,'img_num':img_num})
            elif(child.stream_status == config.STREAM_STATUS_MANUAL):
                logging.debug("SUCCESS manual process")
                find_path = os.path.join(config.MODEL_PATH,str(child.stream_id))#文件夹路径 不存在就创建 存在就检查有没有内容
                if not os.path.exists(find_path):
                    os.makedirs(find_path)
                    logging.debug('model not exists and mkdir')
                else:    
                    if os.listdir(find_path):
                        #这边只判断了有没有文件 而没有判断文件是不是  
                        #对应文件夹是/data/model/{{ stream_id }}/
                        logging.debug('model exists')
                        http_notify(config.STREAM_STATUS_CALLBACK_ADDR,
                                    {'stream_id':child.stream_id,'code':config.CALLBACK_CODE_MANUAL_MODEL_EXISTS})
                    else:
                        logging.debug('model not exists')
            elif(child.stream_status == config.STREAM_STATUS_ONLINE):
                logging.debug("SUCCESS online process")            
                #online截图程序运行成功

        else: #进程执行失败
            logging.warning("ERROR! pid is: " + str(child.pid) + " | stream id is "+ str(child.stream_id))        
            if(child.stream_status == config.STREAM_STATUS_COLLECTION):
                logging.warning("ERROR collect process")
                #进程执行错误一般就是断流了 
                http_notify(config.STREAM_STATUS_CALLBACK_ADDR,{'stream_id':child.stream_id,'code':config.CALLBACK_CODE_COLLECT_ERROR_1})  
            elif(child.stream_status == config.STREAM_STATUS_MANUAL):
                logging.warning("ERROR manual process")            
            elif(child.stream_status == config.STREAM_STATUS_ONLINE):
                logging.warning("ERROR online process")  
                http_notify(config.STREAM_STATUS_CALLBACK_ADDR,{'stream_id':child.stream_id,'code':config.CALLBACK_CODE_ONLINE_ERROR_1}) 

    http_notify(config.SERVER_STATUS_CALLBACK_ADDR,{'code':config.CALLBACK_CODE_SERVER_OK})            
    logging.debug("epoch "+str(int(current_time))+" is over -----------------------------------------")
    
except Exception as err:
    print("Script ERROR !!!")
    print(err)
    http_notify(config.SERVER_STATUS_CALLBACK_ADDR,{'code':config.CALLBACK_CODE_SERVER_ERROR,'msg':str(err)})
    logging.warning("Script Run Error !!!, Except is " + str(err) )





