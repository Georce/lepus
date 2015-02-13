#!/bin/env python
#-*-coding:utf-8-*-
import os
import sys
import time
import string
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

        ###############################################
        return True
    except Exception, e:
        print str(e)
        return False
