#!/usr/bin/env python
#coding:utf-8
import sys

try:
    import pymongo
    import bson
    print "MongoDB python drivier is ok!"

except Exception, e:
    print e
    sys.exit(1)

finally:
    sys.exit(1)



