#!/bin/bash

# no work
# echo "$1"
# for i in {1..$1}
# do
    # echo $i
# done

for (( i=1; i<=$1; i++ ))
do
	echo "$i.js"
    touch "$i.js"
done

# for i in {1..10}
# do
    # echo "$i"
# done

# for i in {1..10}
# do
    # echo "$i"
# done

# for i in $(seq 1 5)
# do
    # echo "$i"
# done

# for ((i=1;i<=10;i++))
# do
  # echo "$i"
# done

# n=${1}
# echo "$n"

