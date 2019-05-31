# About

服务于自己产品的会员管理信息后台，力求简单高效


# 说明

>  如果对您对此项目有兴趣，可以点 "Star" 支持一下 谢谢！

>  开发环境 : macOS 10.13.6  PHP 7.1.23  mysql 5.1.73 

>  部署环境 :

>  如有问题请直接在 Issues 中提，或者您发现问题并有非常好的解决方案，欢迎 PR 👍

>  相关项目地址：[http://www.kapaidashu.org/jiesebang/out.php](http://www.kapaidashu.org/jiesebang/out.php)

>  登陆地址：[http://www.kapaidashu.org/jiesebang/mimi.php](http://www.kapaidashu.org/jiesebang/mimi.php)
   账号:admin 密码 admin

## 技术栈

php + mysql + seajs + aralejs + es5 + bootstrap


## 项目运行


```
git clone git@github.com:tedQB/trading-evil-collect.git  

mac 可使用 MAMP PRO 进行预览

```


## 目标功能

- [x] 添加会员 -- 完成
- [x] 快速搜索会员 --完成
- [x] 编辑会员信息 -- 完成
- [x] 快速修改会员名称 -- 完成
- [x] 快速修改会员微信号码 -- 完成
- [x] 会员天数扣除 -- 完成
- [x] 管理员登陆 -- 完成
- [x] 会员自动打标到期 -- 完成
- [x] 过期会员页面 -- 完成
- [x] 仍在服务期会员页面 -- 完成


## 待实现功能

- [ ] 数据JSONP化 
- [ ] 前端MVVM框架接入


## API接口文档

## 系统截图

## 项目布局

```
.
├── COPYING                         版权信息
├── Db.class.php                    数据库连接类
├── Log.class.php                   日志类
├── README.md                       readme
├── add.php                         添加会员页面
├── collectData.php                 会员信息收集接口
├── deleteId.php                    删除会员信息接口
├── easyCRUD                        小型PHPCURD库
│   ├── Person.class.php
│   ├── easyCRUD.class.php
│   └── index.php
├── edit.php                        编辑会员页面
├── editUp.php                      编辑会员信息接口
├── expire.php                      过期会员信息
├── getInfo.php                     用户信息汇总JSONP接口
├── hastimechange.php               会员累积天数信息修改接口
├── idhui.php                       会员是否加入义工页面
├── idhuistate.php                  会员状态修改接口
├── index.html                      
├── isSexState.php                  会员性别修改接口
├── isShowState.php                 会员状态修改接口
├── login.html                      登陆页面
├── login.php                       登陆接口
├── logs                            日志文件
│   ├── 2014-03-14.txt
│   ├── 2018-03-26.txt
│   └── 2018-05-04.txt
├── main.php                        管理员登陆接口
├── mimi.php                        管理员登陆页面
├── nicknamechange.php              会员名修改
├── out.php                         管理员管理主页面
├── pc.css  
├── phone.css
├── pojie.php                       会员天数扣除页面
├── pojieUp.php                     会员天数扣除接口
├── quickpojie.php                  主页面快速扣除天数接口
├── registernormal.php              管理员注册页面
├── settings.ini.php                数据库配置文件
├── userDetailAdd.php               会员信息添加页面
├── userDetailUp.php                会员信息录入接口
├── userUp.php                      会员提交接口
├── wxidchange.php                  会员微信id修改接口
├── wxnamechange.php                会员微信名称修改接口

.

```

## License

[GPL](https://raw.githubusercontent.com/tedQB/user-manage/master/COPYING)
