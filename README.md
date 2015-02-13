# lepus
开源企业级数据库监控系统,MySQL/Oracle/MongoDB/Redis一站式性能监控，让数据库监控更简单

# Quick Start
You can launch the image using the docker command line,

```bash
mkdir -p /opt/mysql

docker run -d --name=lepus -p 80:80 -p 3306:3306 \
-v /opt/mysql:/var/lib/mysql -v /etc/timelocal:/etc/timelocal \
georce/lepus
```

# Available Configuration Parameters
- **USERNAME**: admin
- **PASSWORD**: Lepusadmin

# References
* http://www.lepus.cc/
