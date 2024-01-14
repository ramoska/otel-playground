# OpenTelemetry playground

## What and why
This repo is a playground for OpenTelemetry. The main goal is to have app "in
cloud" that I can experiment with based on almost real life like scenario. The
evolution of this repo should correspond to theses steps:
- have a simple PHP (Symfony) app with basic logging to file and some
  dependencies (DB, Redis, maybe some other services)
- add OpenTelemetry (OTel) to the app and see how it works
  - add OTel PHP SDK to the app and see where that gets me
  - add OTel Collector and play with it a bit
- maybe add Grafana and Jaeger to the mix
- really want to try out honeycomb.io

## About app itself
App should be pretty simple GraphQL AOI with some basic functionality GraphQL 
because I want to try to experiment with it on Symfony adn see how it works
togehter with API Platform and how hard it would be set up without out of the
box support for types, queries, and mutations API Platform provides.

In later iterations maybe some other PHP service will be added to the mix to
see how OTel works in distributed environment.
