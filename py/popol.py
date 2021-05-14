#generation of random data

import random
import pandas as pd
import numpy as np
from randomtimestamp import randomtimestamp
import time


person_id = []
for i in range(10):
    n = 1
    person_id.append(n)

confidence = []
for i in range(10):
    n = np.random.uniform(0,1)
    confidence.append(n)
np.array(confidence)

label = []
for i in range(10):
    if confidence[i] > 0 and confidence[i] < 0.10:
        label.append("Truck")
    elif confidence[i] > 0.10 and confidence[i] <= 0.20:
        label.append("Pick-up")
    elif confidence[i] > 0.20 and confidence[i] <= 0.40:
        label.append("Car")
    elif confidence[i] > 0.40 and confidence[i] <= 0.60:
        label.append("Excavator")
    else:
        label.append("Indiviual")

"""
success = []
for i in range(10000):
    n =  round(random.uniform(0, 1))
    if n == 0:
       m = "True"
    else:
         m = "False"
    success.append(m)
    

np.array(success)
"""
import datetime

Time = []
for i in range(10):
   time = datetime.datetime(2021, int(np.random.uniform(1, 12)), int(np.random.uniform(1, 28)), 
             int(np.random.uniform(1, 24)), int(np.random.uniform(1, 59)), int(np.random.uniform(1, 59))
                            )
   Time.append(datetime.datetime.now())


Time.sort()
"""
for i in Time:
    print(i)
"""

data = pd.DataFrame({'person_id': person_id,
                    'label': label,
                    'Istante': Time,
                    'confidence': confidence,
                    'latitude': 41.84504023625275,
                    'longitude': 12.616878084119124
                })


#connection to mysql
import pymysql

connection = pymysql.connect(host='localhost',
                            user='root',
                            password='',
                            db='mask_cam')

#define the connection object
cursor=connection.cursor()

#executor
#cursor.execute("Create database if not exists MaskDetect")


#cursor.execute(
#"create table if not exists Mask(person_id varchar(4), label varchar(10), Time char(19), confidence dec(10,9), latitude varchar(20), longitude varchar(20))"
#             )


cols = "`,`".join([i for i in data.columns.tolist()])

for i,row in data.iterrows():
    sql = "INSERT INTO Mask (`" +cols + "`) VALUES (" + "%s,"*(len(row)-1) + "%s)"
    cursor.execute(sql, tuple(row))

connection.commit()

    
#query = "select * from MaskDetect.Mask"
#cursor.execute(query)
#    # get all records
#records = cursor.fetchall()

connection.commit()



