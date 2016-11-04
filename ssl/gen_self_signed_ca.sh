#!/bin/sh
openssl req -config ./openssl.cnf -newkey rsa:4096 -nodes -keyform PEM -keyout ca.key -x509 -days 3650 -extensions certauth -outform PEM -out ca.cer
