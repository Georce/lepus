#!/usr/bin/env python
#coding:utf-8
import sys

try:
    import MySQLdb
    print "MySQL python drivier is ok!"

except Exception, e:
    print e
    sys.exit(1)

finally:
    sys.exit(1)



