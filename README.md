[![Codacy Badge](https://app.codacy.com/project/badge/Grade/9846aeebc05b4d5d96d837af975836c2)](https://www.codacy.com/gh/clopenclassrooms/p7/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=clopenclassrooms/p7&amp;utm_campaign=Badge_Grade)

# Bilemo REST API

## Installation
```Bash
git clone https://github.com/clopenclassrooms/p7.git
cd p7
chmod +x run.sh config.sh config_db.sh
./run.sh
```
when all containers is launch (Ony for first launch)
```Bash
./config.sh
```

## REST API documentation
You can find the complete REST API documentation [here](https://github.com/clopenclassrooms/p7/blob/main/Documentation/documentation.md)

## Test REST API
You can use this [Postman file](https://github.com/clopenclassrooms/p7/blob/main/Documentation/Postman.json) for test the REST API.

The token is automatically add from the "GET /api/login" resquest : 
![](https://github.com/clopenclassrooms/p7/blob/main/Documentation/img/bearer1.png)

You can manually add the token : 
![](https://github.com/clopenclassrooms/p7/blob/main/Documentation/img/bearer2.png)

You can automatically config the host for all test :

![](https://github.com/clopenclassrooms/p7/blob/main/Documentation/img/config_host.png)

## Other
If you want renew JWT SSL keys :
```Bash
./p7/docker/sbash.sh
cd p7
php bin/console lexik:jwt:generate-keypair --overwrite
```