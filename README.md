# debug_msg
调试bug的小工具

# 创意来源

http://sc.ftqq.com/ 

创意归原作者所有，对原作者表示感谢。

其实原作者的工具用着挺棒的，无非就是担心自己用的顺手了而工具却无法再使用的问题。

所以才重复造轮子的。

# 依赖

微信企业号

PHP环境

# 使用方式

1.申请微信企业号并创建应用

需要用到的信息：

1.1 agentid即应用的ID，如图获取
![](http://ww4.sinaimg.cn/large/006tNc79ly1ff525yyk6qj30lw09hq3o.jpg)

1.2 CorpID，Secret 即企业号的调用权限key，如图获取，并且配置好管理组成员和权限
![](http://ww1.sinaimg.cn/large/006tNc79ly1ff529kv6n4j311u0dfdhy.jpg)

1.3 信息接收人的id，获取方式如图
![](http://ww2.sinaimg.cn/large/006tNc79ly1ff52cfejnrj313w0ccgnk.jpg)

2.引用类文件后，将第1步中获取到的信息配置到位即可。

假如 

1.1获取到的agentid是999

1.2获取到的CropID是111 ，Secert是2222 

1.3获取或者设置的信息接收人的id是yywt

那么配置方式如下，新建demo.php文件，写入如下代码

```php

include "Msg.class.php";

$config = array('CorpID' =>'111' , 'Secret' =>'2222');
$send = new Msg($config);
var_dump($send->sendMsg('要发的信息','yywt',999));
```

3.企业号发送消息还支持加密or不加密。默认发送消息是不加密的，如果想要信息加密，则在发送消息时配置即可，如下

```php
$send->sendMsg('要发的信息','yywt',999,1);//加密
$send->sendMsg('要发的信息','yywt',999);//不加密
```

4.log模式，默认开启log，如果不想开启，请在初始配置时提前声明，如下

```php
$config = array('CorpID' =>'111' , 'Secret' =>'2222','debug' => 0);
```


