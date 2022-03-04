#!/bin/sh
cd ..
echo "PROJECT_PATH="$(pwd) > ./p7/docker/.env
cd ./p7/docker/
docker-compose up