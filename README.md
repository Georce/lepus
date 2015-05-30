# lepus
国产开源企业级数据库监控系统,MySQL/Oracle/MongoDB/Redis一站式性能监控，让数据库监控更简单

# Quick Start
You can launch the image using the docker command line,

```bash
mkdir -p /opt/mysql

docker run -d --name=lepus -p 80:80 -p 3306:3306 \
-v /opt/mysql:/var/lib/mysql -v /etc/timelocal:/etc/timelocal \
index.alauda.cn/georce/lepus
```

# Available Configuration Parameters
- **USERNAME**: admin
- **PASSWORD**: Lepusadmin

# 智能监控告警聚合仪表盘
智能聚合数据库健康状态，实时告警信息，让您对数据库的健康状态了如指掌。
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_dashboard.jpg"/>

# 远程云中监控
数据库监控无需部署Agent,WEB界面配置,提供授权账号即可远程监控,适合监控远程云中数据库。
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_config.jpg"/>

# 数据库专业级指标监控数据
针对各种数据库的特性，对数据库健康状态,同步,资源,核心参数,事务,索引,缓存提供专业级监控数据
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_index.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_repl.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_innodb.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mongo_index.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mongo_indexes.jpg"/>

# 丰富的数据库内核性能图表展示
对历史数据归档，通过图表展示出数据库近期状态，以便DBA和开发人员能对遇到的问题进行分析和诊断
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_chart.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_chart2.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_chart3.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_oracle_chart1.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_oracle_chart2.jpg"/>

# 慢查询分析系统
创新的慢查询集中分析系统和慢查询报告推送功能，让DBA和开发直接的沟通更加简单。
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_slowquery.jpg"/>

# 完善的告警系统
在数据库偏离设定的正常运行阀值(如连接异常，复制异常，复制延迟) 时发送告警邮件通知到DBA进行处理。
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_alarm.jpg"/>

# 基于时间范围的AWR在线性能报告
创新的基于时间范围的AWR在线性能报告,可以实时查询历史任意时刻的数据库运行健康状态。
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_awr.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_awr1.jpg"/>
<img src="http://www.lepus.cc/themes/default/styles/images/product/lepus_mysql_awr2.jpg"/>

# References
* http://www.lepus.cc/
