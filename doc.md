data structure
--------------

**big categrory**
- name

**category**
- big_category
- name

**shop**
- name 名称
- category
- description 详细描述
- latilongi 经纬度
- city
- district 所在区域
- average 人均消费
- phone 电话

**shop image**
- shop
- src

**relationship**
- city 1-m district *in conf*
- shop 1-m image

json standard
-------------

json examples have been move to
https://github.com/So-Me/NumOne/wiki/JSON-example

interfaces
----------

interfaces have been moved to 
https://github.com/So-Me/NumOne/wiki/Interface

request JSON in android

example

example data
------------

**category**

1. 餐饮美食
 1. 西餐
 2. 粤菜
 3. 异国菜
 4. 民族清真
2. 休闲娱乐
 1. 美容美体
 2. 公园/游乐园
3. 酒店住宿
4. 购物
5. 美容美发
6. 便民服务
7. 景点景区
