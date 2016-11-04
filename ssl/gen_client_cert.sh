#!/bin/bash

FILE="client3"
SERIAL=202

if [ "$1" != "" ]; then
    FILE="$1"
fi

if [ "$2" != "" ]; then
    SERIAL="$2"
fi


echo "Génération d'un certificat pour le client : $FILE"
echo "Génération de la clé privée"
openssl genrsa -out "${FILE}.key" 4096

echo "Génération de la demande de signature"
openssl req -config ./openssl.cnf -new -key "${FILE}.key" -out "${FILE}.req"

echo "Génération du certificat avec notre autorité de certification"
openssl x509 -req -in "${FILE}.req" -CA ca.cer -CAkey ca.key -set_serial ${SERIAL} -extfile openssl.cnf -extensions client -days 365 -outform PEM -out "${FILE}.cer"


echo "Génération du certificat au format PKCS#12"
openssl pkcs12 -export -inkey "${FILE}.key" -in "${FILE}.cer" -out "${FILE}.p12"

echo "Suppression de la requête de signature"
rm "${FILE}.req" "${FILE}.key" "${FILE}.cer"
