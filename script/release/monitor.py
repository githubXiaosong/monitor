#这个脚本应该不断执行 一旦中断或者执行出错应该被通知 
#每过一个固定的间隔时间 和 WEB同步数据
import pyinotify
import time
import os
import config
from utils import logging,http_notify,get_path_dir

#送网络
def getLabel(stream_id,image_path):
    model_path = os.path.join(config.MODEL_PATH,str(stream_id))
    #检查模型是否存在
    if(os.path.isfile(model_path) == False):
        pass
    #得出label
    return 1,80;

class MyEventHandler(pyinotify.ProcessEvent):
    def process_IN_CREATE(self, event):
        print("Create event:", event.pathname)
        logging.info("Create event : "+ event.pathname)
        if(os.path.isdir(event.pathname)):
            watch_manager.add_watch(event.pathname,config.MONTIOR_MASK,rec=True)
        else:
            if(os.path.splitext(event.pathname)[1] == config.IMAGE_FORMAT):#这里只用后缀来判断 不严谨
                stream_id = get_path_dir(event.pathname,-1)
                label,percent = getLabel(stream_id,event.pathname)
                if(label != -1):
                    #发送label 
                    logging.info("stream: "+ str(stream_id) + " | label " + str(label) + " | percent" + str(percent))
                    http_notify(config.CLASSIFY_CALLBACK_ADDR,{'stream_id':stream_id,'label':label,'percent':percent})
                else:
                    #发送流失败消息
                    logging.warning("stream "+ stream_id + " get -1 from the getLabl")
                    http_notify(config.STREAM_STATUS_CALLBACK_ADDR,{'stream_id':stream_id,'code':config.CALLBACK_CODE_ONLINE_ERROR_2})
                if(percent > config.DEFAULT_MIN_PERCENT):    
                    os.remove(event.pathname)
            else:
                logging.warning("There are error format into! : "+ event.pathname)
    def process_IN_DELETE(self, event):
        print("Delete event:", event.pathname)
        logging.info("Delete event : "+ event.pathname)
        if(os.path.isdir(event.pathname)):
            watch_manager.rm_watch(event.pathname)

# watch manager
watch_manager = pyinotify.WatchManager()
watch_manager.add_watch(config.MONTIOR_DIR,config.MONTIOR_MASK,rec=True)

# event handler
event_handler = MyEventHandler()

# notifier
notifier = pyinotify.Notifier(watch_manager,event_handler)
print("pyinotify on ......")
notifier.loop()

    