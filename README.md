# SHA-piaget-2017cvd`s API

### 1. 提交信息API

Method: POST

##### API URL:

```html
domian/api/submit
```
##### Get Parameter

taTitle: taTitle, taName: taName, taTel:taTel, taAddress:taAddress, ownTitle:ownTitle, ownName:ownName, ownTel:ownTel, ownEmail:ownEmail,

```javascript
{
	'taTitle': taTitle,
	'taName': taName,
	'taTel': taTel,
	'taAddress': taAddress,
	'ownTitle': ownTitle,
	'ownName': ownName,
	'ownTel': ownTel,
	'ownEmail': ownEmail
}
```

##### Response

##### status 1

```javascript
{
	status: '1',
	msg: '信息提交成功！',
}
```

#####  status 0

```javascript
{
	status: '0',
	msg: '信息提交失败！',
}
```


#####  status 2

```javascript
{
	status: '2',
	msg: '您已经提交过信息！',
}
```

---


### 2. 判断是否提交信息API

Method: POST

##### API URL:

```html
domian/api/checkSubmit
```
##### Get Parameter

null

```javascript
{

}
```

##### Response

##### status 1

```javascript
{
	status: '1',
	msg: 'ok',
}
```

#####  status 0

```javascript
{
	status: '0',
	msg: 'failed',
}
```

---


### 3. 合成图片API

Method: POST

##### API URL:

```html
domian/api/createPic
```
##### Get Parameter

toName: toName, toMsg: toMsg, fromName: fromName, fs: 12, isCenter: 1, color:(0,0,0)

```javascript
{
	'toName': 'toName',
	'toMsg': 'toMsg',
	'fromName': 'fromName',
	'fs': '12',
	'isCenter': 1,
	'color' : (0,0,0) 
}
```

##### Response

##### status 1

```javascript
{
	status: '1',
	msg: 'ok',
}
```

#####  status 0

```javascript
{
	status: '0',
	msg: 'failed',
}
```

---

### 4. JSSDK API

Method: GET

##### API URL:

```html
domian/wechat/jssdk/config/js?debug=true
```

##### return jssdk javascript


---

### 4. 模拟登陆 API

Method: GET

##### API URL:

```html
domian/login?openid=1234
```
##### Get Parameter

openid: 1332

```javascript
{
	'openid': '1332',
}
```

##### Response

##### status 1

```javascript
{
	status: '1',
	msg: 'openid: 1332login success',
}
```

#####  status 0

```javascript
{
	status: '0',
	msg: 'login failed',
}
```

#####  status 2

```javascript
{
	status: '2',
	msg: 'param failed',
}
```

