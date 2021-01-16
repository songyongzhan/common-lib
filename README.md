# common-lib
工具、资源、公共库


## Aes加解密

### 加密
```php
    $str = 'james';
    $str = Aes::encrypt($str, '123');
    echo $str;
```
### 解密

```php
    $str = 'NL7rrUNodNkSMvdBtDbob334VRnlM25/TPjkCcga9mE=';
    $data = Aes::decrypt($str, '123');
    var_dump($data);
```

## 验证码-api base64
```php
$img = Captcha::createImg("1234");
print_r($img);
```
参数讲解
* @param string $code   验证码 选
* @param int $width     图片宽度 选 默认 70
* @param int $height    图片高度 选 默认 25
* @param int $len       验证码长度 选 默认4  如果你传递的code是5位，这里就写5
* @param bool $border   图片是否有边框 选
* @param string $fontPath  验证码文字路径 选

## 身份证验证

### 返回年龄、生日、性别 相关的信息
```php
 $idCardInfo = Card::idCardInfo("130182198411201911");
```
### 根据身份证获取生日
```php
$birthDay = Card::getBirthDay("130182198411201911", "/");
```

## Rsa 非对称加密

请参考 `tests/RsaTest.php`


## Jwt jsonToken使用

### jwt token 数据加密
```php
    $token = '';
    $jwtService = new JwtService($token, $this->jwt_rsa_public, $this->jwt_rsa_private, $this->jwt_expire);
    $token = $jwtService->getToken(1, ['name' => 'james']);
    echo $token;
```
其他功能请参考 `tests/JwtTest.php`

## Tree 递归、分类
请参考 `tests/TreeTest.php`

## Tools 工具类

