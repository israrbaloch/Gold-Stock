#!/bin/bash

if [ -z "$1" ]; then
  echo "Error: command incompleted"
  echo "Example: ./setup-server.sh example.org"
  exit 1
fi

SERVER="$1"

clear

curl -L --fail https://github.com/docker/compose/releases/download/1.25.4/run.sh -o run.sh

ssh-add -K ~/.ssh/id_rsa
scp run.sh rancher@$SERVER:/home/rancher
ssh -t rancher@$SERVER "sudo mv run.sh /usr/bin/docker-compose && sudo chmod +x /usr/bin/docker-compose && docker-compose version"
scp deploy.sh rancher@$SERVER:/home/rancher

rm run.sh
