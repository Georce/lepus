cat > /usr/local/lepus/etc/config.ini << EOF
###监控机MySQL数据库连接地址###
[monitor_server]
host="127.0.0.1"
port=3306
user="lepus_user"
passwd="password"
dbname="lepus"
EOF