#!/bin/bash

# 提交代码并在服务器上拉取

m=${1:-'更换token'}

git add .
git commit -m "$m"
git push

ssh aliyun "cd /var/www/html/tool; git pull"