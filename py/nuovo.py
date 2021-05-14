import tensorflow
import keras
from keras.models import load_model

import cv2
import numpy as np
import datetime
import pandas as pd
import pymysql

model = load_model('model-017.model')

face_clsfr=cv2.CascadeClassifier('haarcascade_frontalface_default.xml')

source=cv2.VideoCapture(0)


labels_dict={0:'MASK',1:'NO MASK'}
color_dict={0:(0,255,0),1:(0,0,255)}


while(True):

 

    ret,img=source.read()
    gray=cv2.cvtColor(img,cv2.COLOR_BGR2GRAY)
    faces=face_clsfr.detectMultiScale(gray,1.3,5)  

 

    for (x,y,w,h) in faces:
    
        face_img=gray[y:y+w,x:x+w]
        resized=cv2.resize(face_img,(100,100))
        normalized=resized/255.0
        reshaped=np.reshape(normalized,(1,100,100,1))
        result=model.predict(reshaped)

 

        label=np.argmax(result,axis=1)[0]
      
        cv2.rectangle(img,(x,y),(x+w,y+h),color_dict[label],2)
        cv2.rectangle(img,(x,y-40),(x+w,y),color_dict[label],-1)
        cv2.putText(img, labels_dict[label], (x, y-10),cv2.FONT_HERSHEY_SIMPLEX,0.8,(255,255,255),2)
        
        
        mask_confin = result[0, 0]
        no_mask_confin = result[0, 1]
        print("mask_confin" + str(mask_confin))
        print("no_mask_confin" + str(no_mask_confin))
        print(datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"))
        
        if mask_confin > no_mask_confin:
            label = "Mask"
            confidence = mask_confin
        else:
            label = "No Mask"
            confidence = no_mask_confin
        
        Time = np.array(datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"))
        id = np.random.uniform(1,1)
        
        data = pd.DataFrame({
                            'id': id,
                            'label': [label],
                            'Time': Time,
                            'Confidence': confidence
                            })
        
        
        connection = pymysql.connect(host='localhost',
                            user='root',
                            password='',
                            db = 'mask_cam')
 
        if connection:
            print('conection successfull')
        #define the connection object
        cursor=connection.cursor()
 
 
        cursor.execute(
            "create table if not exists Mask(id varchar(4), label varchar(10), Time datetime, confidence dec(10,9))"
             )
 
        cols = "`,`".join([i for i in data.columns.tolist()])
 
        for i,row in data.iterrows():
            sql = "INSERT INTO Mask (`" +cols + "`) VALUES (" + "%s,"*(len(row)-1) + "%s)"
            cursor.execute(sql, tuple(row))
 
        connection.commit()
 

 

        
                     
                    
    cv2.imshow('LIVE',img)
    key=cv2.waitKey(1)
    
    if(key==27):
        break
        
cv2.destroyAllWindows()
source.release()