.PHONY: help

help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

clean:
	rm -rf public/build static/build

install:
	composer install && yarn install

dev: install # Start dev server.
	symfony run -d yarn encore dev --watch
	symfony server:start --no-tls -d

log: # View dev server logs.
	symfony server:log

dev-stop: # Stop dev server
	symfony server:stop

build: install # Static site generation.
	mkdir -p static
	yarn encore production
	cp -r public/build static/build
	php bin/console site:generate --env=prod

prod: build # Preview production site.
	php -S 127.0.0.1:8080 -t static/
