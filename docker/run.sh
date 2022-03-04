#!/bin/sh
echo "PROJECT_PATH="$(pwd)"/../../" > .env
docker-compose up
