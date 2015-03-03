#!/bin/sh

export LC_ALL=zh_CN.GB2312;export LANG=zh_CN.GB2312

username=dacaiguo
###############配置项目名称和路径等相关参数
projectName='Lvmm' #项目所在目录的名称
isWorkSpace=false  #判断是用的workspace还是直接project，workspace设置为true，否则设置为false
projectDir=/Users/${username}/Documents/workplace/lvmama630/ #项目所在目录的绝对路径
buildConfig=Debug #编译的方式,默认为Release,还有Debug等

cd ${projectDir}
echo ${projectDir}
ipa build -c Debug
echo 0