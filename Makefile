permissions:## Set permissions for newly created volumes
	chmod -R 755 .database .nginx_logs
up:## Up the project, apply migrations and permissions
	cp .env.example .env
	docker-compose up -d
	sleep 2
	make permissions
down:
	docker-compose down
init:
	docker exec vb_php php artisan migrate --seed
	docker exec vb_php php artisan storage:link
	docker exec vb_php php artisan bugwall:init --storage
	docker exec vb_php php artisan key:generate
clear-volumes:
	rm -rf .database
	rm -rf .nginx_logs