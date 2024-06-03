.PHONY: help
.DEFAULT_GOAL := help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build services.
	docker-compose -f docker-compose.yml build $(c)

up: ## Create and start services.
	docker-compose -f docker-compose.yml up -d $(c)

stop: ## Stop services.
	docker-compose -f docker-compose.yml stop $(c)

restart: stop up ## Restart services.

down: ## Stop and remove containers and volumes.
	docker-compose -f docker-compose.yml down -v $(c)

ps: ## Show started services.
	docker-compose ps

logs: ## Display logs.
	docker-compose -f docker-compose.yml logs --tail=200 -f $(c)

console: ## Login in backend console.
	docker-compose -f docker-compose.yml exec app /bin/bash