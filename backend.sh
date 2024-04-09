#!/usr/bin/env bash

# Make us independent from working directory
pushd `dirname $0` > /dev/null
popd > /dev/null

if [[ -n "$@" ]]; then
  docker-compose exec -u sail -T laravel.test bash -c "$@"
else
  docker-compose exec -u sail laravel.test bash
fi;

