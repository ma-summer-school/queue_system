#!/bin/bash

#this script installs all the dependencies and gives the appropriate permisions for the emulator to work

sudo apt-get install freeglut3 freeglut3-dev libglew-dev libpng12-dev zlib1g-dev libjpeg-dev socat

git clone https://github.com/hikiko/eqemu.git

cd eqemu/
make
./RUN &
sleep 10
cd /tmp
nuDevice=$(ls -lh ttyeqemu | grep -oE "/dev/pts/[0-9]+")
sudo chmod gou+rwx $nuDevice

