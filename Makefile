FRONT_DIR := $(shell pwd)
front:
	docker run -it --rm \
		-v $(FRONT_DIR):/app \
		-w /app \
		node:latest \
		yarn build

swiper:
	docker run -it --rm \
		-v $(FRONT_DIR):/app \
		-w /app \
		node:latest \
		yarn add swiper

install:
	docker run -it --rm \
		-v $(FRONT_DIR):/app \
		-w /app \
		node:latest \
		yarn install