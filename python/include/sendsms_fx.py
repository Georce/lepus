#!/bin/env python
#-*-coding:utf-8-*-
import os
import sys
import time
import string
path='.'
sys.path.insert(0,path)
import functions as func
reload(sys) 
sys.setdefaultencoding('utf8')
import ConfigParser


def send_sms(sms_to_list,sms_msg,db_type,application,host,port,level,alarm_item,alarm_value,message):
    '''
    sms_to_list:发给谁
    sms_msg:短信内容
    sms_msg='['+level+'] '+db_type+'-'+tags+'-'+server+' '+message+' Time:'+create_time.strftime('%Y-%m-%d %H:%M:%S')
    '''
    '''
    sms_to_list_comma:多个短信接收者，用逗号拼接
    sms_to_list_semicolon:多个短信接收者，用分号拼接
    '''
    sms_to_list_comma = ",".join(sms_to_list)
    sms_to_list_semicolon = ";".join(sms_to_list)
    try:
        ######### you send sms code here ##############
        sms_fetion_user = func.get_option('sms_fetion_user')
        sms_fetion_pass = func.get_option('sms_fetion_pass')
        os.system('fetion --mobile=%s --pwd=%s --to=%s --msg-type=1 --msg-utf8="%s"' %(sms_fetion_user,sms_fetion_pass,sms_to_list_comma,sms_msg)) 
        ###############################################
        return True
    except Exception, e:
        print str(e)
        return False
