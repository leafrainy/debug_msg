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

2.修改相关id信息
  define('CorpID', 'XXXXXX');
  define('Secret', 'XXXXXX');

3.修改应用id
  "agentid": 2,

4.修改接收人id（在通讯录中设置）
  send_text($text,"yywt");

5.网址访问
  http://a.com/send.php?to=yywt&msg=哈哈
  PHP访问
  file_get_contents('http://a.com/send.php?to=yywt&msg='.urlencode('哈哈'));



