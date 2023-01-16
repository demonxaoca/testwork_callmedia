docker-compose up -d
sleep 5
docker exec -it mysql mysqladmin create testwork -u root -padmin
docker exec -it mysql sh -c "mysql -u root -padmin -D testwork < /var/lib/mysql/dump.sql"