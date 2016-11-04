#!/bin/sh
echo "Génération d'un certificat pour le serveur"
echo "Génération de la clé privée"
openssl genrsa -out server.key 4096

echo "Génération de la demande de signature"
openssl req -config ./openssl.cnf -new -key server.key -out server.req

echo "Génération du certificat avec notre autorité de certification"
openssl x509 -req -in server.req -CA ca.cer -CAkey ca.key -set_serial 100 -extfile openssl.cnf -extensions server -days 365 -outform PEM -out server.cer

echo "Suppression de la requête de signature"
rm server.req

