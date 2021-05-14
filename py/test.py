
import json
import numpy as np
import pymysql as sql

with open("json/tre.json") as file:
    data = json.load(file)
    

#print(data, sep=\n)
#print("LEN DATA=", len(data))
#print("LEN PREDICTIONS=", len(data["predictions"]))
#print("LEN TIMESTAMP=", len(data["time_stamp"]))
#print("LEN SUCCESS=", len(data["success"]))
#print("LEN IDOBJECT=", len(data["idObject"]))

#Lettura parametrica di un json
for key in data:
    if isinstance(data[key], list):
        print("This is an array:", key)
        #print("LEN DATA KEY=", len(data[key]))
        for i in range(0, len(data[key])):
            print("Giro", i)
            #print(data[key][i])
            for names in data[key][i]:
                print(names,":", data[key][i][names])
    else:
        print("This isn't an array:", key,":", data[key])


#Insert into db
data_frame = pd.DataFrame({'idStreamer' : idStreamer,
                           'label': label,
                           'val': val,
                           'success': success,  
                           'Time': time})
                           
import pymysql
connection = pymysql.connect(host='localhost',
                            user='root',
                            password='',
                            db='mask_cam')

cursor=connection.cursor()