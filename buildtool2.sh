#!/bin/sh

export LC_ALL=zh_CN.GB2312;export LANG=zh_CN.GB2312

###############配置项目名称和路径等相关参数
projectName=Lvmm#项目所在目录的名称
isWorkSpace=false  #判断是用的workspace还是直接project，workspace设置为true，否则设置为false
projectDir=./ #项目所在目录的绝对路径
buildConfig=Debug #编译的方式,默认为Release,还有Debug等



rm -rf ./build
buildAppToDir=./build/$projectName #编译打包完成后.archive .ipa文件存放的目录

###############获取版本号,bundleID
infoPlist="${projectDir}${projectName}/$projectName-Info.plist"
bundleDisplayName=`/usr/libexec/PlistBuddy -c "Print CFBundleDisplayName" $infoPlist`
bundleVersion=`/usr/libexec/PlistBuddy -c "Print CFBundleShortVersionString" $infoPlist`
bundleIdentifier=`/usr/libexec/PlistBuddy -c "Print CFBundleIdentifier" $infoPlist`
bundleBuildVersion=`/usr/libexec/PlistBuddy -c "Print CFBundleVersion" $infoPlist`
###############在网页上显示的名字和bundleDisplayName一致
appName=$bundleDisplayName  

echo "$bundleDisplayName"

###############开始编译app
echo  "开始编译target...." >>$logPath
cd ${projectDir}
xcodebuild -target $projectName -configuration $buildConfig clean build SYMROOT=$buildAppToDir
#判断编译结果
if test $? -eq 0
then
echo "~~~~~~~~~~~~~~~~~~~编译成功~~~~~~~~~~~~~~~~~~~"
else
echo "~~~~~~~~~~~~~~~~~~~编译失败~~~~~~~~~~~~~~~~~~~" >>$logPath
echo "\n" >>$logPath
exit 1
fi

###############开始打包成.ipa
ipaName=`echo $projectName | tr "[:upper:]" "[:lower:]"` #将项目名转小写
appDir=$buildAppToDir/$buildConfig-iphoneos  #app所在路径
echo "开始打包$projectName.xcarchive成$projectName.ipa....." >>$logPath
xcrun -sdk iphoneos PackageApplication -v $appDir/$projectName.app -o $appDir/$ipaName.ipa #将app打包成ipa



#检查文件是否存在
if [ -f "$appDir/$ipaName.ipa" ]
then
echo "打包$ipaName.ipa成功." >>$logPath
else
echo "打包$ipaName.ipa失败." >>$logPath
exit 1
fi


###############计算文件大小和最后更新时间
fileSize=`stat $appDir/$ipaName.ipa |awk '{if($8!=4096){size=size+$8;}} END{print "文件大小:", size/1024/1024,"M"}'`
lastUpdateDate=`stat $appDir/$ipaName.ipa | awk '{print "最后更新时间:",$13,$14,$15,$16}'`
echo "$fileSize"  >>$logPath
echo "$lastUpdateDate" >>$logPath
 echo "结束时间:$(date_Y_M_D_W_T)" >>$logPath
echo "~~~~~~~~~~~~~~~~~~~结束编译~~~~~~~~~~~~~~~~~~~" >>$logPath
echo "~~~~~~~~~~~~~~~~~~~结束编译，处理成功~~~~~~~~~~~~~~~~~~~"
echo "\n" >>$logPath
