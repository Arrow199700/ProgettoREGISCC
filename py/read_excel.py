# -*- coding: utf-8 -*-
"""
Created on Fri May 14 12:06:27 2021

@author: luigi
"""
import pymysql
import pandas as pd
import time

tablenew = pd.read_excel(r'C:\xampp\htdocs\definitivo\py\datigiusti.xlsx') 




     
connection = pymysql.connect(host='localhost',
                             user='root',
                             password='',
                             db = 'mask_cam')


cursor = connection.cursor() 
               
#cursor.execute(
#           "create table tablenew (secondi varchar(5), ObjectId varchar(2), label varchar(20), Istante char(19))"
#             )

 
if connection:
    print('conection successfull')
    
cols = "`,`".join([i for i in tablenew.columns.tolist()])


sql = "DELETE FROM TABLENEW"
cursor.execute(sql)

for i,row in tablenew.iterrows():
    sql = "INSERT INTO TABLENEW (`" +cols + "`) VALUES (" + "%s,"*(len(row)-1) + "%s)"
    cursor.execute(sql, tuple(row))
                
    connection.commit()
            
  
    print("Send it")
            
    time.sleep(.2)

    