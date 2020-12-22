.env:
	cp .env.dist .env

local: .env
	aws ecr get-login-password --region us-west-2 | docker login --username AWS --password-stdin 019621153437.dkr.ecr.us-west-2.amazonaws.com
	docker-compose up -d
	dev-exec make build
.PHONY:local

build-cache:
	rm -rf var/cache/*
	bin/console cache:warmup --no-debug --no-interaction
PHONY: build-cache

build-dependencies:
	XDEBUG_CONFIG="" php -d memory_limit=-1 `which composer` install --no-interaction --no-ansi --optimize-autoloader
.PHONY: build-dependencies
	
fix-cs:
	rm -f .php_cs.cache
	php-cs-fixer fix tests --show-progress=estimating --verbose --config=.php_cs.dist --allow-risky=yes
	php-cs-fixer fix src --show-progress=estimating --verbose --config=.php_cs.dist --allow-risky=yes
.PHONY: fix-cs

clean: clean-cs clear-cache
	rm -f .env
	rm -rf vendor/
	rm -f composer.lock
	rm -f symfony.lock
.PHONY: clean

clear-cache:
	rm -rf var/cache/*
	rm -rf /tmp/behat*
	rm -rf build/
.PHONY: clear-cache

clean-composer:
	rm -rf vendor/
	rm -rf ~/.composer/cache
	rm -rf composer.lock symfony.lock
.PHONY: clean-composer

clean-cs:
	rm -f .php_cs.cache
.PHONY: clean-cs

fix-cs:
	rm -f .php_cs.cache
	php-cs-fixer fix tests --show-progress=estimating --verbose --config=.php_cs.dist --allow-risky=yes
	php-cs-fixer fix src --show-progress=estimating --verbose --config=.php_cs.dist --allow-risky=yes
.PHONY: fix-cs

test: test-unit test-feature
.PHONY: test

test-feature:
	php -d memory_limit=-1 vendor/bin/behat --format progress -vv --stop-on-failure
.PHONY: test-feature

test-unit:
	./vendor/bin/simple-phpunit --coverage-html build/coverage --coverage-clover build/coverage/clover.xml
.PHONY: unit-test