#!/bin/bash

url="https://api.github.com/users/$1"
echo $url
curl -H "Accept: application/vnd.github.v3+json" $url > user.json
sed -nr 's/"name": "(.+)",/\1/p' user.json
sed -nr 's/"bio": "(.+)",/\1/p' user.json
sed -nr 's/"location": "(.+)",/\1/p' user.json
sed -nr 's/"blog": "(.+)",/\1/p' user.json
rm user.json
