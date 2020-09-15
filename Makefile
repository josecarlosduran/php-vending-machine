.PONY: build deps composer-install composer-update composer reload test run-tests start stop destroy doco rebuild start-local
current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

$(info $(id -u))
build: deps start


deps:
	@docker run --rm --interactive --volume $(current-dir):/app --user $(id -u):$(id -g) clevyr/prestissimo install --ignore-platform-reqs 	--no-ansi --no-interaction




test:
	@docker exec php-vending-machine make exec-test

exec-test:
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --colors=always --log-junit build/test_results/phpunit/junit.xml



# Docker Compose
start: CMD=up -d
stop: CMD=stop
destroy: CMD=down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
doco start stop destroy:
	@docker-compose $(CMD)

rebuild:
	docker-compose build --pull --force-rm --no-cache
	make deps_rebuild
	make start

restart:
	docker-compose down
	make build


