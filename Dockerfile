FROM alpine:3.14

RUN apk add --update php php-sqlite3 php-pdo php-pdo_sqlite nodejs npm
RUN npm install -g node-sass -y

WORKDIR /home/oclock

COPY . .

EXPOSE 3000

# On démarre le watcher sass en background, puis le serveur PHP
CMD node-sass -w style.scss public/css/style.css & php -S 0.0.0.0:3000
