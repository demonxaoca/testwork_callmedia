docker-compose up -d
echo "wait 15 sec"
sleep 15
cp ./dump.sql ./mysql
docker exec -it mysql sh -c "mysqladmin create testwork -u root -padmin"
docker exec -it mysql sh -c "mysql -u root -padmin -D testwork < /var/lib/mysql/dump.sql"
docker restart php_worker