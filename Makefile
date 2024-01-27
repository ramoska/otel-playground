K8S_CONFIG_DIST = k8s-setup.dist.yaml
K8S_CONFIG = k8s-setup.yaml
CONTAINER_RUNTIME = podman
IMAGE_REGISTRY = $(shell multipass info microk8s-vm --format table | grep "IPv4" | grep -Eo "\d{1,3}\.\d*\.\d*\.\d*"):32000
DOCKER_DIR = $(CURDIR)/docker
TAG = $(shell git rev-parse --short=16 HEAD)

config: k8s-setup.dist.yaml
	@echo "Creating k8s config"
	@sed "s~{{pwd}}~$(CURDIR)~g" k8s-setup.dist.yaml | sed "s~{{tag}}~$(TAG)~g" > k8s-setup.yaml

.PHONY: build
build: ## Build docker images
	@echo "Building docker image"
	@$(CONTAINER_RUNTIME) build -t $(IMAGE_REGISTRY)/otel-playground/php:$(TAG) -f $(DOCKER_DIR)/php/Dockerfile $(DOCKER_DIR)/php && \
		$(CONTAINER_RUNTIME) push $(IMAGE_REGISTRY)/otel-playground/php:$(TAG)
	@$(CONTAINER_RUNTIME) build -t $(IMAGE_REGISTRY)/otel-playground/nginx:$(TAG) -f $(DOCKER_DIR)/nginx/Dockerfile $(DOCKER_DIR)/nginx && \
		$(CONTAINER_RUNTIME) push $(IMAGE_REGISTRY)/otel-playground/nginx:$(TAG)

.PHONY: deploy
deploy: build  ## Deploy to microk8s
	@echo "Deploying to microk8s"
	@microk8s kubectl apply -f $(K8S_CONFIG)
