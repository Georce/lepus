#!/usr/bin/env python
#coding:utf-8
import sys

try:
    import redis
    print "Redis python drivier is ok!"

except Exception, e:
    print e
    sys.exit(1)

finally:
    sys.exit(1)



