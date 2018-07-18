
## 说明
- 1.onReceiver实现路由机制，path中通过“/”来区分路由，寻找controller里面的内容，现在只实现了controller的一级目录

- 2.默认路由，indexController中的indexAction，可以在config中自定义文件和action的extend;

- 3.redis连接池和mysql连接池，mysql断线重连

- 4.GLOBAL设置全局变量，包含每个进程的serv（主要是send），fd（链接的fd），from_id（来自于分配的workid或者taskid）

- 5.接受参数为json格式数据，里面包含了两个必要参数的内容：
    1.path：字符串的形式，例如：‘index/test’（indexController下的testAction）；
    2.params：socket交互的内容，json格式，例如{"a":"a","b":"b"}
    socket服务端接受的完整参数格式：{"path":"send\/index","params":{"a":"aaaaa","b":"bbbbbbbb"}}
