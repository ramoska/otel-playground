K8S_CONFIG_DIST = k8s-setup.dist.yaml
K8S_CONFIG = k8s-setup.yaml
CONTAINER_RUNTIME = podman
IMAGE_REGISTRY = $(shell multipass info microk8s-vm --format table | grep "IPv4" | grep -Eo "\d{1,3}\.\d*\.\d*\.\d*"):32000
PHP_DOCKER_DIR = $(CURDIR)/docker/php
TAG = $(shell git rev-parse --short=16 HEAD)

build: k8s-setup.dist.yaml  ## Build docker images
	@echo "Building docker image"
	@$(CONTAINER_RUNTIME) build -t $(IMAGE_REGISTRY)/otel-playground/php:$(TAG) -f $(PHP_DOCKER_DIR)/Dockerfile $(PHP_DOCKER_DIR) && \
		$(CONTAINER_RUNTIME) push $(IMAGE_REGISTRY)/otel-playground/php:$(TAG)
	@sed "s~{{pwd}}~$(CURDIR)~g" k8s-setup.dist.yaml | sed "s~{{tag}}~$(TAG)~g" > k8s-setup.yaml

.PHONY: deploy
deploy: build  ## Deploy to microk8s
	@echo "Deploying to microk8s"
	@microk8s kubectl apply -f $(K8S_CONFIG)
