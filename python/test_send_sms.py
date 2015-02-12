#!/usr/bin/env python
# -*- coding: utf8 -*-
from datetime import *
import os
import sys
path='./include'
sys.path.insert(0,path)
import functions as func

send_sms_to_list = func.get_option('send_sms_to_list')
sms_to_list=send_sms_to_list.split(';')
sms_to_list_comma = ",".join(sms_to_list)
sms_fetion_user = func.get_option('sms_fetion_user')
sms_fetion_pass = func.get_option('sms_fetion_pass')
sms_msg = "Hello Lepus!"
result = os.system('fetion --mobile=%s --pwd=%s --to=%s --msg-type=1  --msg-utf8="%s" --debug' %(sms_fetion_user,sms_fetion_pass,sms_to_list_comma,sms_msg))
print result
