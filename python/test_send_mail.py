#!/usr/bin/env python
# -*- coding: utf8 -*-
from datetime import *
import sys
path='./include'
sys.path.insert(0,path)
import functions as func

mail_to_list = func.get_option('mail_to_list')
mailto_list=mail_to_list.split(';')

result = func.send_mail(mailto_list," I hope you can learn","Beautiful Day")
print result
if result:
    send_mail_status = "success"
else:
    send_mail_status = "fail"
print "send_mail_status:"+send_mail_status
