.PHONY: help

help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

clean:
	rm -rf public/assets static/assets

install:
	composer install

dev: install # Start dev server.
	rm -rf public/assets
	php bin/console asset-map:compile
	symfony server:start --no-tls -d

log: # View dev server logs.
	symfony server:log

dev-stop: # Stop dev server
	symfony server:stop

build: install # Static site generation.
	php bin/console cache:clear --env=prod
	mkdir -p static
	php bin/console asset-map:compile --env=prod
	cp -r public/assets static/assets
	cp -r public/images static/images
	php bin/console site:generate --env=prod

prod: build # Preview production site.
	php -S 127.0.0.1:8080 -t static/
